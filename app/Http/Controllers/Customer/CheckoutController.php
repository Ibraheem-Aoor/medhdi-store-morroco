<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Admin\Sales\Order\OrderController;
use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Address;
use App\Models\CombinedOrder;
use App\Utility\PayhereUtility;
use App\Utility\NotificationUtility;
use Session;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Models\Currency;

class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    /**
     * Each Combined Order has Many Orders
     * Each Order Has Many OrderDetails
     * Each OrderDetail Represents details of single Product.
     */
    public function checkout(Request $request)
    {
        $request->validate(
            ['name' => 'required'  , 'phone' => 'required|numeric|digits:10' , 'city' => 'required' , 'address' => 'required'] ,
            ['name.required' => translate('Name Is Required') , 'phone.required' => translate('Phone Is Required') , 'phone.digits' => translate('Phone Number Not Correct') , 'city.required' => translate('City Is Required') , 'address.required' => translate('City Is Required')]
            );

        $temp_user_id = $request->session()->get('temp_user_id');
        $shippingAddress = $request->toArray();
        $request['shippingAddress'] = $shippingAddress;

        // Minumum order amount check
        if(get_setting('minimum_order_amount_check') == 1){
            $subtotal = 0;
            foreach (Cart::where('temp_user_id', $temp_user_id)->get() as $key => $cartItem){
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
            }
            if ($subtotal < get_setting('minimum_order_amount')) {
                $message   = translate('You order amount is less than the minimum order amount');
                return response()->json(['status' => false , 'message' => $message] , 400);
            }
        }

        // Minumum order amount check end

            $order_creation_result = (new OrderController)->store($request);
            if(is_array($order_creation_result))
            {
                return response()->json($order_creation_result );
            }

            $request->session()->put('payment_type', 'cash_on_delivery');

            $data['combined_order_id'] = $request->session()->get('combined_order_id');
            $combined_order = CombinedOrder::findOrFail($data['combined_order_id']);
            if(get_setting('tax_activation'))
            {
                if (get_setting('general_tax_type') == 'percent')
                {
                    $taxInPercent = get_setting('tax_value') / 100;
                    $combined_order->grand_total += $combined_order->grand_total * $taxInPercent;
                }else{
                    $fixedTax = get_setting('tax_value');
                    $combined_order->grand_total += $fixedTax;
                }
                $combined_order->save();
            }
            $currency_id = get_setting('system_default_currency');
            $data = array_merge($data , ['total' => $combined_order->grand_total , 'customer_id' => Auth::id() , 'currency_id' => $currency_id]);
            // return dd($data);
            $request->session()->put('payment_data', $data);
            if ($request->session()->get('combined_order_id') != null) {
                    $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));
                    foreach ($combined_order->orders as $order) {
                        $order->manual_payment = 1;
                        $order->save();
                    }
                    return $this->order_confirmed($temp_user_id);
            }//end method

    }

    //redirects to this method after a successfull checkout
    public function checkout_done($combined_order_id, $payment)
    {
        $combined_order = CombinedOrder::findOrFail($combined_order_id);

        foreach ($combined_order->orders as $key => $order) {
            $order = Order::findOrFail($order->id);
            $order->payment_status = 'paid';
            $order->payment_details = $payment;
            $order->save();

            calculateCommissionAffilationClubPoint($order);
        }
        Session::put('combined_order_id', $combined_order_id);
        return redirect()->route('order_confirmed');
    }

    public function get_shipping_info(Request $request)
    {
        $temp_user_id = $request->session()->get('temp_user_id');
        $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        if ($carts && count($carts) > 0) {
                $categories = Category::all();
                return view('frontend.shipping_info', compact('categories', 'carts'));
            }
        flash(translate('Your cart is empty'))->success();
            return back();
    }

    public function store_shipping_info(Request $request)
    {
        if ($request->address_id == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }
        $temp_user_id = $request->session()->get('temp_user_id');
        $carts = Cart::where('temp_user_id' , $temp_user_id)->get();

        foreach ($carts as $key => $cartItem) {
            $cartItem->address_id = $request->address_id;
            $cartItem->save();
        }

        // return view('frontend.delivery_info', compact('carts'));
        // return view('frontend.payment_select', compact('total'));
        return $this->store_delivery_info($request);
    }

    public function store_delivery_info(Request $request)
    {
        $temp_user_id = $request->session()->get('temp_user_id');
        $carts = Cart::where('temp_user_id', $temp_user_id)
                ->get();
        if($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;

        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = \App\Models\Product::find($cartItem['product_id']);
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $subtotal += $cartItem['price'] * $cartItem['quantity'];

                if ($request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    $cartItem['shipping_type'] = 'pickup_point';
                    $cartItem['pickup_point'] = $request['pickup_point_id_' . $product->user_id];
                } else {
                    $cartItem['shipping_type'] = 'home_delivery';
                }
                $cartItem['shipping_cost'] = 0;
                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                }

                if(isset($cartItem['shipping_cost']) && is_array(json_decode($cartItem['shipping_cost'], true))) {

                    foreach(json_decode($cartItem['shipping_cost'], true) as $shipping_region => $val) {
                        if($shipping_info['city'] == $shipping_region) {
                            $cartItem['shipping_cost'] = (double)($val);
                            break;
                        } else {
                            $cartItem['shipping_cost'] = 0;
                        }
                    }
                } else {
                    if (!$cartItem['shipping_cost'] ||
                            $cartItem['shipping_cost'] == null ||
                            $cartItem['shipping_cost'] == 'null') {

                        $cartItem['shipping_cost'] = 0;
                    }
                }

                $shipping += $cartItem['shipping_cost'];
                $cartItem->save();

            }
            $total = $subtotal + $tax + $shipping;
            return $this->checkout($request);

        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        $temp_user_id = $request->session()->get('temp_user_id');
        $coupon = Coupon::where('code', $coupon_code)->first();
        $message = '';
        $status = null;
        if($coupon)
        {
        if ($coupon != null && $request->session()->get('coupon_used') != $coupon_code)   {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                    $coupon_details = json_decode($coupon->details);

                    $carts = Cart::where('temp_user_id', $temp_user_id)
                                    ->get();
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach ($carts as $key => $cartItem) {
                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                            $tax += $cartItem['tax'] * $cartItem['quantity'];
                            $shipping += $cartItem['shipping_cost'];
                        }
                        $sum = $subtotal + $tax + $shipping;

                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }

                        }

                    if($coupon_discount > 0){
                        Cart::where('temp_user_id', $temp_user_id)
                            ->update(
                                [
                                    'discount' => $coupon_discount / count($carts),
                                    'coupon_code' => $coupon_code,
                                    'coupon_applied' => 1
                                ]
                            );
                        $status = true;
                        $request->session()->put('coupon_used' , $coupon_code);
                        $message = translate('Coupon has been applied');
                    }
                    else{
                        $status = false;
                        $message = translate('This coupon is not applicable to your cart products!');
                    }
        }else{
            $status = false;
            $message = translate('Coupon expired!');
        }
        }else{
            $status = false;
            $message = translate('Invalid coupon!');
        }//end coupon date check
    }else{
        $status = false;
        $message = translate('Invalid coupon!');
    }
    return response()->json(['status' => $status , 'message' => $message]);
}

    public function remove_coupon_code(Request $request)
    {

        Cart::where('user_id', Auth::user()->id)
                ->update(
                        [
                            'discount' => 0.00,
                            'coupon_code' => '',
                            'coupon_applied' => 0
                        ]
        );

        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('user_id', Auth::user()->id)
                ->get();

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();

        if($request->has('flag'))
            return view('frontend.partials.coupon_cart_view', compact('carts' , 'coupon'));
        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'));
    }

    public function apply_club_point(Request $request) {
        if (addon_is_activated('club_point')){

            $point = $request->point;

            if(Auth::user()->point_balance >= $point) {
                $request->session()->put('club_point', $point);
                flash(translate('Point has been redeemed'))->success();
            }
            else {
                flash(translate('Invalid point!'))->warning();
            }
        }
        return back();
    }

    public function remove_club_point(Request $request) {
        $request->session()->forget('club_point');
        return back();
    }

    public function order_confirmed($temp_user_id)
    {
        $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));

        Cart::where('temp_user_id', $temp_user_id)
                ->delete();

        Session::forget('club_point');
        Session::forget('combined_order_id');

        foreach($combined_order->orders as $order){
            NotificationUtility::sendOrderPlacedNotification($order);
        }
        $message = translate('Your order has been placed successfully. Please submit payment information from purchase history');

        return response()->json(['status' => true , 'is_confirmed' => true , 'message' => $message , 'route' => route('order_confirmed' , encrypt($combined_order->id))]);
    }


    public function getOrderConfirmedPage($id)
    {
        $combined_order = CombinedOrder::findOrFail(decrypt($id));
        return view('frontend.order_confirmed', compact('combined_order'));
    }
}
