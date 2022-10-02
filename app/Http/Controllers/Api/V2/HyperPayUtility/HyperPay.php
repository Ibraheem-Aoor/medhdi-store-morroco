<?php


namespace App\Traits;


use App\Models\Client;
use App\Models\Country;
use App\User;
use Illuminate\Http\Request;

trait HyperPay
{

    protected $url = "https://oppwa.com/v1/checkouts";
    protected $url_test = "https://test.oppwa.com/v1/checkouts";

    function isTest() {
        return true;
    }

    function checkout($amount, $currencyCode, $storeUrl, $viewPath , $token = null , $request = null)
    {

        if ($this->isTest()) {
            $url = $this->url_test;
            $entityId = config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = $this->url;
            $entityId = config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }

        $random = mt_rand(10000, 99999);
        $amount = number_format(round($amount, 2), 2, '.', '');
        $transactionId = $random;
        if (auth('api')->check()) {
            $client = auth('api')->user();
//            $transactionId = "MC-" . $random . "-" . $client->id;
            $transactionId ="OSR-" . $random . "-" . $client->id;

        } else {
            $client = User::where('id' , $request['user_id'])->first();
            $transactionId = "OSR-" . $random . "-" . $client['id'];


        }

        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $client->email;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $tokenCode
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
//        $view=view('customer.templates.theme01.order.heyperpay')
        $view = $viewPath
            ->with(["responseData" => $response, 'price' => $amount, 'url' => $storeUrl])->renderSections();
        return $view['main'];
//        return response()->json([
//            'status'  => true,
//            'content' => $view['main']
//        ]);
//        return $response;
    }

    function paymentStatus($id, $resourcePath)
    {
        if ($this->isTest()) {
            $url = $this->url_test . '/' . $id . "/payment";
            $url .= "?entityId=" . config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');
        } else {
            $url = $this->url;
            $url = $this->url . '/' . $id . "/payment";
            $url .= "?entityId=" . config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $tokenCode
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        return $res;
    }

    function madaCheckout($amount, $currencyCode, $storeUrl, $viewPath, $token = null)
    {
        if (isTest()) {
            $url = $this->url_test;
            $entityId = config('services.heyper_pay_test.madaEntityId');
            $tokenCode = config('services.heyper_pay_test.mada_token');

        } else {
            $url = $this->url;
            $entityId = config('services.heyper_pay.madaEntityId');
            $tokenCode = config('services.heyper_pay.token');
        }

        $random = mt_rand(10000, 99999);
        $amount = number_format(round($amount, 2), 2, '.', '');

        $transactionId = $random;
        if (auth('client')->check()) {

            $client = $this->client();
            $transactionId = "MC-" . $random . "-" . $client->id;
        } elseif (auth('client_api')->check()) {
            $client = $this->client_api();
            $transactionId = "MC-M-" . $random . "-" . $client->id;
        } elseif (auth('customer')->check()) {
            $client = $this->customer();
            $transactionId = "ST-" . $random . "-" . $client->store_id . "-" . $client->id;
        } else {
            if ($token) {
                $client = Client::where('api_token', $token)->first();
                $transactionId = "MC-M-" . $random . "-" . $client->id;
            } else {
                $client = new Client();
                $transactionId = "MC-N-" . $random . "-" . $client->id;
            }
        }


        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $client->email;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $tokenCode
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
        $view = $viewPath
            ->with(["responseData" => $response, 'price' => $amount, 'url' => $storeUrl])->renderSections();
        return $view['main'];
    }


    function madaPaymentStatus($id, $resourcePath)
    {
        if (isTest()) {
            $url = $this->url_test . '/' . $id . "/payment";
            $url .= "?entityId=" . config('services.heyper_pay_test.madaEntityId');
            $tokenCode = config('services.heyper_pay_test.mada_token');
        } else {
            $url = $this->url . '/' . $id . "/payment";
            $url .= "?entityId=" . config('services.heyper_pay.madaEntityId');
            $tokenCode = config('services.heyper_pay.token');
        }


//        $url .= "?entityId=8ac7a4ca742436880174263b644b109d";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGFjN2E0Y2E3NDI0MzY4ODAxNzQyNjM4ZjRjZjEwOGZ8c242a04zZmFDcQ=='
            'Authorization:Bearer ' . $tokenCode
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        return $res;
    }

    function applePayCheckout($amount, $currencyCode, $storeUrl, $viewPath, $token = null)
    {

        $url = $this->url;
        $random = mt_rand(10000, 99999);

        $transactionId = $random;
        if (auth('client')->check()) {

            $client = $this->client();
            $transactionId = "MC-" . $random . "-" . $client->id;
        } elseif (auth('client_api')->check()) {
            $client = $this->client_api();
            $transactionId = "MC-M-" . $random . "-" . $client->id;
        } elseif (auth('customer')->check()) {
            $client = $this->customer();
            $transactionId = "ST-" . $random . "-" . $client->store_id . "-" . $client->id;
        } else {
            if ($token) {
                $client = Client::where('api_token', $token)->first();
                $transactionId = "MC-M-" . $random . "-" . $client->id;
            } else {
                $client = new Client();
                $transactionId = "MC-N-" . $random . "-" . $client->id;
            }
        }
        if (isset($client->mobile_country_code)) {
            $country = Country::where('code', $client->mobile_country_code)->first();
            $country_code = $client->mobile_country_code;
            $zip_code = $country->zip_code;
        } else {
            $country_code = 'SA';
            $zip_code = '966';
        }

        $orderAmount = number_format(round($amount, 2), 2, '.', '');
        //    $data = "entityId=8ac7a4c77891db4501789bb239f90dc3". //test
        if (isset($zip_code)) {
            $zip_code = $zip_code;
        } else {
            $zip_code = 966;
        }

        $data = "entityId=8ac9a4ce732312dd017333cca3cb224a" .
            "&amount=" . $orderAmount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $client->email .
            "&billing.street1=none" .
            "&billing.city=none" .
            "&billing.state=none" .
            "&billing.country=" . strtoupper($country_code) .
            "&billing.postcode=" . $zip_code .
            "&customer.givenName=" . $client->first_name .
            "&customer.surname=" . $client->last_name;
        //      $data .="&testMode=EXTERNAL";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //   'Authorization:Bearer OGFjN2E0Yzk3MWE3NDQ5ZjAxNzFhNzRmNjJlMTAwYmJ8dzg2V0M5bUhicA=='
            'Authorization:Bearer ' . config('services.heyper_pay.token')
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
        $view = $viewPath
            ->with(["responseData" => $response, 'price' => $amount, 'url' => $storeUrl])->renderSections();
        return $view['main'];

    }

    function applePayPaymentStatus($id, $resourcePath)
    {

        $url = "https://oppwa.com/v1/checkouts/" .
            $id . "/payment";
        //    $url .= "?entityId=8ac7a4c77891db4501789bb239f90dc3";//test
        $url .= "?entityId=8ac9a4ce732312dd017333cca3cb224a";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //   'Authorization:Bearer OGFjN2E0Yzk3MWE3NDQ5ZjAxNzFhNzRmNjJlMTAwYmJ8dzg2V0M5bUhicA=='
            'Authorization:Bearer ' . config('services.heyper_pay.token')

        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        return $res;
    }


    function checkoutTest($amount, $currencyCode, $order, $referal_company)
    {
        $url = $this->url;
        $amount = number_format(round($amount, 2), 2, '.', '');


        $random = mt_rand(10000, 99999);
        $transactionId = "MC-" . $random . "-" . $referal_company->id;


//        $data = "entityId=" . config('services.heyper_pay.entityId') .
        $data = "entityId=8ac7a4c971a7449f0171a74fb5b900c0" .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $referal_company->email;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . config('services.heyper_pay.token')
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
        //        return $response;
    }


    public function checkoutAddCard()
    {
        if (isTest()) {
            $url = $this->url_test;
            $entityId = config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = $this->url;
            $entityId = config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }


        $data = "entityId=" . $entityId .
            "&amount=1" .
            "&currency=SAR" .
            "&paymentType=DB" .
            "&createRegistration=true";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);
        return $response;
    }

    public function getCardData($id)
    {
        if (isTest()) {
            $url = $this->url_test . '/' . $id . "/registration";
            $entityId = config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = $this->url . '/' . $id . "/registration";
            $entityId = config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }
        $url .= "?entityId=" . $entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        return $res;
    }


    public function makePaymentUsingCard($client, $amount)
    {
        $amount = number_format($amount, 2, '.', '');

        if (isTest()) {
            $url = $this->url_test;
            $entityId = config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = $this->url;
            $entityId = config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }

        $random = mt_rand(10000, 99999);
        $transactionId = $random;
        if (auth('client')->check()) {
            $client = $this->client();
            $transactionId = "MC-" . $random . "-" . $client->id;
        } elseif (auth('client_api')->check()) {
            $client = $this->client_api();
            $transactionId = "MC-M-" . $random . "-" . $client->id;
        }


        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=SAR" .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB";

        foreach ($client->cards as $key => $card) {
            $data .= "&registrations[$key].id=$card->registration_id";
        }
        $data .= "&standingInstruction.source=CIT" .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

    public function makePaymentUsingMadaCard($client, $amount)
    {
        $amount = number_format($amount, 2, '.', '');

        if (isTest()) {
            $url = $this->url_test;
            $entityId = config('services.heyper_pay_test.madaEntityId');
            $tokenCode = config('services.heyper_pay_test.mada_token');
        } else {
            $url = $this->url;
            $entityId = config('services.heyper_pay.madaEntityId');
            $tokenCode = config('services.heyper_pay.token');
        }
        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=SAR" .
            "&paymentType=DB";

        $cards = $client->cards()->where('brand', "MADA")->get();
        foreach ($cards as $key => $card) {
            $data .= "&registrations[$key].id=$card->registration_id";
        }
        $data .= "&standingInstruction.source=CIT" .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }


    function deleteClientCard($registration_id)
    {

        if (isTest()) {
            $url = "https://test.oppwa.com/v1/registrations/" . $registration_id;
            $entityId = config('services.heyper_pay_test.entityId');
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = "https://oppwa.com/v1/registrations/" . $registration_id;
            $entityId = config('services.heyper_pay.entityId');
            $tokenCode = config('services.heyper_pay.token');
        }

        $url .= "?entityId=" . $entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }


    public function makeRepeatedPaymentUsingCard($client, $card_id, $amount)
    {
        $amount = number_format($amount, 2, '.', '');

        if (isTest() || in_array($client->id  , Client::TEST_ACCOUNTS)) {
            $url = "https://test.oppwa.com/v1/registrations/$card_id/payments";
            $tokenCode = config('services.heyper_pay_test.token');

        } else {
            $url = "https://oppwa.com/v1/registrations/$card_id/payments";
            $tokenCode = config('services.heyper_pay.token');
        }

        $random = mt_rand(10000, 99999);
        $transactionId = $random;
        if (isset($client)) {
            $transactionId = "MC-" . $random . "-" . $client->id;
        }


        $data = "entityId=8ac7a4c97af72a05017b00675237137b" .
            "&amount=" . $amount .
            "&currency=SAR" .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $client->email .
            "&standingInstruction.mode=REPEATED" .
            "&standingInstruction.type=UNSCHEDULED" .
            "&standingInstruction.source=CIT";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $tokenCode));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }


}
