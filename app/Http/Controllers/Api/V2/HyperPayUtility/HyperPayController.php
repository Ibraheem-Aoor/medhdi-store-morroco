<?php
namespace App\Http\Controllers\Api\V2\HyperPayUtility;

use App\Http\Controllers\Api\V2\Controller;
use App\Models\CombinedOrder;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\Shop;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Iyzipay\Model\Currency as ModelCurrency;

class HyperPayController extends Controller
{
    //the  combined order which is used to set the payment


    function first_step(Request $request) {
        $combined_order = $request->session()->get('payment_data');
        $combinedOrder = CombinedOrder::findOrFail($combined_order['combined_order_id']);
        $amount = $this->getConvertedAmount($combined_order);
        // return dd($amount);
        $combinedShippingInfo = $this->getCombinedShippingInfo($combinedOrder);
        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=".config('services.heyper_pay_test.entityId').
                    "&amount=".$amount.
                    "&currency=SAR" .
                    "&paymentType=DB".
                    "&customer.phone=".$combinedShippingInfo->phone.
                    "&billing.city=".$combinedShippingInfo->city.
                    "&billing.state=".$combinedShippingInfo->state.
                    "&customer.givenName=" .$combinedShippingInfo->name;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer '.config('services.heyper_pay_test.token')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData , true);
        // return dd($response);
        return view('frontend.hyperpay.payment-form' , compact('response'));
    }//end method


    /**
     * Currency converter to SAR (Hyper pay default currency)
     */
    public function getConvertedAmount($combined_order)
    {
        $totalOrderAmount = $combined_order['total'];
        $currency = Currency::findOrFail($combined_order['currency_id']); //order currency.
        $amountInSar = 0;
        if($currency->code != 'SR')
        {
            $currencySar = Currency::where('code' , 'SR')->first();
            if($currency->code != 'USD')
            {
                if($currency->exchange_rate > 1)
                    $amountInUsd = $totalOrderAmount / $currency->exchange_rate;
                elseif($currency->exchange_rate < 1)
                    $amountInUsd = $totalOrderAmount * $currency->exchange_rate;
                else
                    $amountInUsd = $totalOrderAmount;
                $amountInSar = $amountInUsd / $currencySar->exchange_rate;
            }else{
                $amountInSar = $totalOrderAmount / $currencySar->exchange_rate;
            }
        }else{
            $amountInSar = $totalOrderAmount;
        }
        return Self::formatAmountNumber($amountInSar);
    }//end method



    /**
        *return shopping info of the combined order
     */
    public function getCombinedShippingInfo($combinedOrder)
    {
        return json_decode($combinedOrder->shipping_address);
    }


    /**
     * Hyper Pay Last Step
     */
    public function second_step(Request $request)
    {
        $data = $request->all();
        $combined_order = $request->session()->get('payment_data');
        $combinedOrder = CombinedOrder::findOrFail($combined_order['combined_order_id']);
        // return dd($data);
        $url = "https://eu-test.oppwa.com/v1/checkouts/".$data['id']."/payment";
        $url .= "?entityId=8ac7a4c971a7449f0171a74fb5b900c0";
        // return dd($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGFjN2E0Yzk3MWE3NDQ5ZjAxNzFhNzRmNjJlMTAwYmJ8dzg2V0M5bUhicA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData , true);

        // return dd($response);
        if ($response['result']['code'] == '000.100.110' || $response['result']['code'] == '000.000.000') {
            // return dd($response);
            $this->setOrderPaymentStatus($combinedOrder , $response);
            $this->updateSellersRevenueAmount($combinedOrder);
            $this->createPaymentLog($response , $combinedOrder);
            flash(translate('Payment completed'))->success();
            return redirect()->route('order_confirmed');
        }else{
            flash(translate('Something Went Wrong'))->error();
            return redirect('dashboard');
        }
        // return dd($responseData);
    }//end method


    /**
     * change each order and orderDetail('product') payment status
     */
    public function setOrderPaymentStatus($combinedOrder , $response)
    {
        foreach($combinedOrder->orders as  $order)
        {
            $order->payment_status = 'paid';
            $order->payment_details = $response;
            $order->save();
            foreach($order->orderDetails() as $detailedOrder)
            {
                $detailedOrder->payment_status = 'paid';
                $detailedOrder->save();
            }
            $order->save();
        }


    }//end method

    /**
     * Update Seller Revenue Amount
     */
    public function updateSellersRevenueAmount($combinedOrder)
    {
         //In case seller product
        $seller_ids = $combinedOrder->orders->pluck('seller_id');
        $shops = Shop::whereIn('user_id' , $seller_ids)->get();
        foreach($shops as $shop)
        {
            $totalSellerOrdersAmount = $combinedOrder->orders()->where('seller_id' , $shop->user_id)->sum('grand_total');
            $shop->admin_to_pay = $shop->admin_to_pay +  $totalSellerOrdersAmount;
            $shop->save();
        }
    }



    /**
     * Register Payment Details
     */

    public function createPaymentLog($response , $combinedOrder)
    {
        foreach($combinedOrder->orders as  $order)
        {
            $payment = new Payment();
            $payment->seller_id = $order->seller_id;
            $payment->amount = $order->grand_total;
            $payment->payment_method = $response['paymentBrand'];
            $payment->txn_code = null;
            $payment->save();
        }
        // return dd(Payment::last());
    }//end method



    /**
     * Format Total Amount
     */
    public static function formatAmountNumber($amount)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_amount= number_format($amount, get_setting('no_of_decimals'));
        } else {
            $fomated_amount= number_format($amount, get_setting('no_of_decimals'), ',', ' ');
        }
        return $fomated_amount;
    }//end method

}



