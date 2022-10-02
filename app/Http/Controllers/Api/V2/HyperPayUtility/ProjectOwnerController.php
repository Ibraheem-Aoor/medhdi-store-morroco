<?php

namespace App\Http\Controllers\Api\V2\HyperPayUtility;

use App\Http\Requests\User\Owner\ShipProjectsRequest;
use App\Http\Requests\User\Owner\ShopRequest;
use App\Http\Requests\User\ShopRating;
use App\Http\Requests\User\ShopReport;
use App\Http\Resources\AdsRescource;
use App\Http\Resources\FullAds;
use App\Http\Resources\MyAdsRescource;
use App\Http\Resources\PackagesResource;
use App\Http\Resources\ServiceResourceAdsSingle;
use App\Http\Resources\ShipProjectsResource;
use App\Http\Resources\ShopProjectResource;
use App\Http\Resources\User\ProfileResource;
use App\Package;
use App\Payment;
use App\Ships;
use App\ShipsProjects;
use App\ShopsProjects;

use App\Traits\HyperPay;
use App\Traits\MobileNotification;
use App\UserAds;
use App\Ads;
use App\UsersFinancialOperations;
use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Owner\ProjectRequest;
use App\Http\Requests\User\Rating;
use App\Http\Requests\User\Report;
use App\Http\Resources\RatingResource;
use App\Http\Resources\ServiceRequestResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceResourceAds;
use App\Http\Resources\ShipResource;
use App\Project;
use App\User;
use App\Country;
use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProjectOwnerController extends Controller
{
    use MobileNotification, HyperPay;


    public function payment(Request $request)
    {
        $data = $request->all();
        $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $iMac = stripos($_SERVER['HTTP_USER_AGENT'], "Mac");
        if ($iPod || $iPhone || $iPad || $iMac)
            $data['is_ios_device'] = TRUE;
        else
            $data['is_ios_device'] = TRUE;

        return view('payment', compact('data'));
    }

    public function visa(Request $request)
    {
        $data = $request->all();
        $url = "https://test.oppwa.com/v1/checkouts";
        $random = mt_rand(10000, 99999);
        $user = ModelsUser::where('id', $data['user_id'])->first();
        $transactionId = "OSR-" . $random . "-" . $user['id'];

        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . number_format($data['amount'], 2) .
            "&currency=EUR" .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $user['email'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
//        return $responseData;
        $response = json_decode($responseData, true);

        return view('payment-form', compact('response'));
        $currencyCode = 'SAR';
        $data['class'] = 'charge';
        $view = view('payment-form-new', $data);
        $amount = number_format(round($data['amount'], 2), 2, '.', '');

        return $this->checkout($amount, $currencyCode, '', $view, '', $data);


//            $url = "https://oppwa.com/v1/checkouts";
        $url = "https://test.oppwa.com/v1/checkouts";
        $random = mt_rand(10000, 99999);
        $amount = number_format(round($data['amount'], 2), 2, '.', '');
//            return $amount;
//            $currencyCode= 'SAR';
        $currencyCode = 'EUR';
        $transactionId = $random;
        $user = User::where('id', $data['user_id'])->first();
        $transactionId = "OSR-" . $random . "-" . $user['id'];

        $entityId = config('services.heyper_pay_test.entityId');
        $tokenCode = config('services.heyper_pay_test.token');

        $data = "entityId=" . $entityId .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $user['email'] .
            "&customer.ip=" . '2.88.2.24';
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

        return view('payment-form', compact('response'));

    }

    public function mada(Request $request)
    {
        $data = $request->all();

        $url = "https://test.oppwa.com/v1/checkouts";
        $random = mt_rand(10000, 99999);
        $user = User::where('id', $data['user_id'])->first();
        $transactionId = "OSR-" . $random . "-" . $user['id'];

        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . number_format($data['amount'], 2) .
            "&currency=SAR" .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $user['email'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
//        dd($responseData);
        $response = json_decode($responseData, true);
//        return $response;
//        085f2cb3f703d5c18d9195efaac46ccaf360c661@2022-04-19
        return view('payment-mada-form', compact('response'));
//        $url = "https://oppwa.com/v1/checkouts";
        $url = "https://test.oppwa.com/v1/checkouts";
        $random = mt_rand(10000, 99999);
        $amount = number_format(round($data['amount'], 2), 2, '.', '');
        $currencyCode = 'SAR';
        $transactionId = $random;
        $user = User::where('id', $data['user_id'])->first();
        $transactionId = "OSR-" . $random . "-" . $user['id'];

        $data = "entityId=8ac7a4ca742436880174263b644b109d" .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $user['email'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NDI0MzY4ODAxNzQyNjM4ZjRjZjEwOGZ8c242a04zZmFDcQ=='
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

        return view('payment-mada-form', compact('response'));

    }

    public function applepay(Request $request)
    {
        $data = $request->all();


        $url = "https://oppwa.com/v1/checkouts";
        $random = mt_rand(10000, 99999);
        $amount = number_format(round($data['amount'], 2), 2, '.', '');
        $currencyCode = 'SAR';
        $transactionId = $random;
        $user = User::where('id', $data['user_id'])->first();
        $transactionId = "OSR-" . $random . "-" . $user['id'];

        $country = Country::where('id', $user->country_id)->first();
//        return $country;

        $data = "entityId=8ac9a4c87dd81a4a017de0e4cb7573cf" .
            "&amount=" . $amount .
            "&currency=" . $currencyCode .
            "&merchantTransactionId=" . $transactionId .
            "&paymentType=DB" .
            "&customer.email=" . $user['email'] .
            "&billing.street1=none" .
            "&billing.city=none" .
            "&billing.state=none" .
            "&billing.country=" . strtoupper($country['sort_name']) .
            "&billing.postcode=" . $country['code'] .
            "&customer.givenName=" . $user['name'] .
            "&customer.surname=" . $user['name'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Yzc3Y2ViYzI3OTAxN2NmYTNmY2U1NTE2ZmZ8eWg3OThFbk1tRQ=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);

        return view('payment-apple_pay-form', compact('response'));

    }

    public function visaResponse(Request $request, $id = null)
    {
        $data = $request->all();
//        if(!empty($id)) {
//            return $this->paymentStatus($id , '');
//        }
        $url = "https://test.oppwa.com/v1/checkouts/" . $data['id'] . "/payment";
//        $url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";
        $status = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        $res = json_decode($responseData, true);
//        dd($res);
        if ($res['result']['code'] == '000.100.110' || $res['result']['code'] == '000.000.000') {
            $customer_email = $res['customer']['email'];
            $type = $res['paymentBrand'];
            $amount = $res['amount'];
            $status = $this->createPaymentLog($customer_email, $type, $amount);
        }
//        dd($status);
        if ($status) {
            if ($data['type'] === 'package') {
                $dataR = $this->upgrade_package_new($data['item_id'], $data['user_id'], $data['payment_type']);

            } elseif ($data['type'] === 'ads') {
                $dataR = $this->update_ads_pay($data['item_id'], $data['user_id'], $data['payment_type']);
            }
            return view('errors.payment', compact('status' , 'dataR'));
        }
        if ($data['type'] === 'ads') {
            UserAds::where('id', $data['item_id'])->delete();
        }
        return view('errors.payment', compact('status'));

        return $res;

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $responseData = curl_exec($ch);
//        if(curl_errno($ch)) {
//            return curl_error($ch);
//        }
//        curl_close($ch);
//        return $responseData;
//        $url = "https://oppwa.com/v1/checkouts";
//        $url = "https://test.oppwa.com/v1/checkouts";
//        $url = $url . '/' . $data['id'] . "/payment";
//        $entityId = config('services.heyper_pay_test.entityId');
//        $tokenCode = config('services.heyper_pay_test.token');
//        $url .= "?entityId=8ac9a4c77cebc279017cfa40dbb61704";
//        $url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";

        $status = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=='
        ));
//        OGFjOWE0Yzc3Y2ViYzI3OTAxN2NmYTNmY2U1NTE2ZmZ8eWg3OThFbk1tRQ==
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $res = json_decode($responseData, true);
        dd($res);
        if ($res['result']['code'] == '000.100.110' || $res['result']['code'] == '000.000.000') {
            $customer_email = $res['customer']['email'];
            $type = $res['paymentBrand'];
            $amount = $res['amount'];
            $status = $this->createPaymentLog($customer_email, $type, $amount);
        }
        if ($status) {
            return view('errors.payment', compact('status'));
        }
        return view('errors.payment', compact('status'));

        return $res;

    }


    public function madaResponse(Request $request)
    {
        $data = $request->all();
        $url = "https://test.oppwa.com/v1/checkouts/" . $data['id'] . "/payment";
//        $url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";
        $status = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        $res = json_decode($responseData, true);
//        dd($res);
        if ($res['result']['code'] == '000.100.110' || $res['result']['code'] == '000.000.000') {
            $customer_email = $res['customer']['email'];
            $type = $res['paymentBrand'];
            $amount = $res['amount'];
            $status = $this->createPaymentLog($customer_email, $type, $amount);
        }
//        dd($status);
        if ($status) {
            if ($data['type'] === 'package') {
                $dataR = $this->upgrade_package_new($data['item_id'], $data['user_id'], $data['payment_type']);
            } elseif ($data['type'] === 'ads') {
                $dataR = $this->update_ads_pay($data['item_id'], $data['user_id'], $data['payment_type']);
            }

            return view('errors.payment', compact('status' , 'dataR'));
        }
        if ($data['type'] === 'ads') {
            UserAds::where('id', $data['item_id'])->delete();
        }
        return view('errors.payment', compact('status'));
        $url = "https://oppwa.com/v1/checkouts";
        $url = $url . '/' . $data['id'] . "/payment";
        $url .= "?entityId=8a8294174d0595bb014d05d829cb01cd";
//        $url .= "?entityId=8ac9a4c77cebc279017cfa4149b91709";
        $status = false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Yzc3Y2ViYzI3OTAxN2NmYTNmY2U1NTE2ZmZ8eWg3OThFbk1tRQ=='
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
        //dd($res);
        if ($res['result']['code'] == '000.100.110' || $res['result']['code'] == '000.000.000') {
            $customer_email = $res['customer']['email'];
            $type = $res['paymentBrand'];
            $amount = $res['amount'];
            $status = $this->createPaymentLog($customer_email, $type, $amount);
        }
        if ($status) {
            return view('errors.payment', compact('status'));
        }


        return view('errors.payment', compact('status'));

        return $res;

    }

    public function applePayResponse(Request $request)
    {
        $data = $request->all();
        $url = "https://oppwa.com/v1/checkouts";
        $url = $url . '/' . $data['id'] . "/payment";
        $url .= "?entityId=8ac9a4c87dd81a4a017de0e4cb7573cf";
        $status = false;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjOWE0Yzc3Y2ViYzI3OTAxN2NmYTNmY2U1NTE2ZmZ8eWg3OThFbk1tRQ=='
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
        //  dd($res);
        if ($res['result']['code'] == '000.100.110' || $res['result']['code'] == '000.000.000') {
            $customer_email = $res['customer']['email'];
            $type = $res['paymentBrand'];
            $amount = $res['amount'];
            $status = $this->createPaymentLog($customer_email, $type, $amount);
        }
        if ($status) {
            return view('errors.payment', compact('status'));
        }
        return view('errors.payment', compact('status'));

        return $res;

    }

    public function createPaymentLog($customer_email, $type, $amount)
    {
        $status = false;
        $user = User::where('email', $customer_email)->first();
        $data = UsersFinancialOperations::create([
            'TypeMovement' => 'plus',
            'TypePayment' => $type,
            'SectionOperation' => 'account',
            'TypeOperation' => 'charge',
            'OperationData' => '0',
            'OperationType' => '1',
            'Amount' => $amount,
            'UserId' => $user['id'],
            'Status' => 1,
        ]);
        if ($data) {
            $status = true;
        }

        return $status;
    }


    public function session(Request $request)
    {

        $PRODUCTION_CERTIFICATE_KEY = '/home/jpnxl0ipaxst/applepay/ap_key.pem';
        $PRODUCTION_CERTIFICATE_PATH = '/home/jpnxl0ipaxst/applepay/ap_cert.pem';

        $PRODUCTION_CERTIFICATE_KEY_PASS = 'Zxc123!@#';

        $PRODUCTION_MERCHANTIDENTIFIER = 'merchant.com.osr-app';
        $PRODUCTION_DOMAINNAME = 'osrapp.com';
        $PRODUCTION_CURRENCYCODE = 'USD';
        $PRODUCTION_COUNTRYCODE = 'US';
        $PRODUCTION_DISPLAYNAME = 'Test';
        $validation_url = $request->url;

        $data = '{"merchantIdentifier":"' . $PRODUCTION_MERCHANTIDENTIFIER . '", "domainName":"' . $PRODUCTION_DOMAINNAME . '", "displayName":"' . $PRODUCTION_DISPLAYNAME . '"}';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $validation_url);
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
        curl_setopt($ch, CURLOPT_SSLCERT, $PRODUCTION_CERTIFICATE_PATH);
        curl_setopt($ch, CURLOPT_SSLKEY, $PRODUCTION_CERTIFICATE_KEY);
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $PRODUCTION_CERTIFICATE_KEY_PASS);
        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $PRODUCTION_CERTIFICATE_KEY_PASS);

        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "changeit");
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, "PEM");
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, "PEM");

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if (curl_exec($ch) === false) {
            echo '{"curlError":"' . curl_error($ch) . '"}';
        }

        // close cURL resource, and free up system resources
        curl_close($ch);
    }

    public function paymentRedurect(Request $request)
    {
        $typemove = $request->typemove;
        $type = 'plus';
        $Status = 1;
        $amount = $request->amount / 100;
        if ($request->status == 'failed') {
            $type = $request->status;
            $Status = $request->status == 'failed' ? 0 : 1;
        }
        $data = UsersFinancialOperations::create([
            'TypeMovement' => $type,
            'TypePayment' => $typemove,
            'SectionOperation' => 'account',
            'TypeOperation' => 'charge',
            'OperationData' => '0',
            'Amount' => $amount,
            'UserId' => $request->user_id,
            'Status' => $Status,
        ]);

        return view('errors.payment', compact('Status'));
    }

    /**
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function createProject($id = null, ProjectRequest $request)
    {
        $project = Project::register($id, $request);
        if (isset($project)) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_saved_successfully'), 'data' => ['project_id' => $project->id]]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }

    /**
     * @param $id
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function updateProject($id, ProjectRequest $request)
    {
        $request['status_id'] = 19;
        $project = Project::updateOrCreate(['id' => $id], $request->only(Project::FILLABLE));
        if (isset($project)) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_saved_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }


    /**
     * @return JsonResponse
     */
    public function ships()
    {
        $user = User::where('type_id', '3')->has('user')->withCount('providerServices')->orderby('provider_services_count', 'DESC')->paginate(10);
        return response()->json(['status' => true, 'data' => ShipResource::collection($user),
            'currentPage' => $user->currentPage()
            , 'lastPage' => $user->lastPage()
            , 'hasMorePages' => $user->hasMorePages()
            , 'next' => $user->nextPageUrl()
        ]);
    }

    public function ships_post(Request $request)
    {
        $shops = Ships::WithCount('ShopsProjectsActive')->has('user');
        if (isset($request->title) && $request->title != null) {
            $shops = $shops->where('name', 'LIKE', '%' . $request->title . '%');
        }
        if (isset($request->status) && $request->status != null && $request->status == 'my') {
            if (Auth('api')->user() != null && Auth('api')->user()->type_id == 23) {
                $shops = $shops->where('user_id', Auth('api')->user()->id);
            }
            if (Auth('api')->user() != null && Auth('api')->user()->type_id == 3) {
                $shops = $shops->WhereHas('Projects', function ($q) {
                    $q->where('user_id', Auth('api')->user()->id);
                });
            }
        } else {
            $shops = $shops->where('status_id', 26);
        }

        if (isset($request->status) && $request->status != null && $request->status == 'country') {
            $defaultCountry = Country::where('sort_name', 'KSA')->first()->id;
            if (auth('api')->check()) {
                $defaultCountry = auth('api')->user()->Country->id;
            }
            $shops = $shops->whereHas('user', function ($q) use ($defaultCountry) {
                $q->where('country_id', $defaultCountry);
            });
        }
        if (isset($request->status) && !empty($request->status) && $request->status == 'city' && isset(auth('api')->user()->city_id)) {
            $shops = $shops->WhereHas('user', function ($query) use ($request) {
                $query->where('city_id', auth('api')->user()->city_id);
            });
        }
        if (isset($request->status) && $request->status != null && $request->status == 'close' && isset(auth('api')->user()->map_x) && isset(auth('api')->user()->map_y)) {

            $lat = auth('api')->user()->map_x ? auth('api')->user()->map_x : 0;
            $lng = auth('api')->user()->map_y ? auth('api')->user()->map_y : 0;
            $distance = 15;
            $shops = $shops->WhereHas('user', function ($query) use ($lat, $lng, $distance) {
                $query->WhereRaw("((ACOS(SIN({$lat} * PI() / 180) * SIN(map_x * PI() / 180) + COS({$lat} * PI() / 180) * COS(map_x * PI() / 180) * COS(({$lng} - map_y) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) <= {$distance}");
            });
        }

        $shops = $shops->orderby('created_at', 'DESC')->paginate(10);
// >orderby('shops_projects_active_count' , 'DESC')-
        return response()->json(['status' => true, 'data' => ShipResource::collection($shops),
            'currentPage' => $shops->currentPage()
            , 'lastPage' => $shops->lastPage()
            , 'hasMorePages' => $shops->hasMorePages()
            , 'next' => $shops->nextPageUrl()
        ]);
    }

    public function shop_project($shop_id)
    {
        $shops = ShopsProjects::where('status_id', '5')->where('shop_id', $shop_id)->paginate(10);
        return response()->json(['status' => true, 'data' => ShopProjectResource::collection($shops),
            'currentPage' => $shops->currentPage()
            , 'lastPage' => $shops->lastPage()
            , 'hasMorePages' => $shops->hasMorePages()
            , 'next' => $shops->nextPageUrl()
        ]);
    }

    public function shop_project_ivited()
    {
        $provider = auth('api')->user();
        $shops = ShopsProjects::WhereHas('shop', function ($q) {
            $q->where('deleted_at', NULL)->where('status_id', '26');
        })
            ->WhereHas('GetProject', function ($q) use ($provider) {
                $q->where('user_id', $provider->id);
            })
            ->orderby('created_at', 'DESC')->paginate(10);

        return response()->json(['status' => true, 'data' => ShipProjectsResource::collection($shops),
            'currentPage' => $shops->currentPage()
            , 'lastPage' => $shops->lastPage()
            , 'hasMorePages' => $shops->hasMorePages()
            , 'next' => $shops->nextPageUrl()
        ]);
    }

    public function shop_project_ivited_status($shop_id, $project_id, $status_id)
    {
        $provider = auth('api')->user();
        $shops = ShopsProjects::where('project_id', $project_id)
            ->where('shop_id', $shop_id)
            ->WhereHas('GetProject', function ($q) use ($provider) {
                $q->where('user_id', $provider->id);
            })->first();

        if (!$shops) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.project_not_found')]);
        }
        if ($status_id == 'delete') {
            if ($shops->delete()) {
                return JsonResponse::create(['status' => true, 'message' => __('lang.done')]);
            }
        } else {
            $shops->status_id = $status_id;
            if ($status_id == 5) {
                try {
                    $shops->GetShop->user->notifyShopInviteAccept($shops);
                } catch (\Exception $e) {
                }
            } elseif ($status_id == 6) {
                try {
                    $shops->GetShop->user->notifyShopInviteReject($shops);
                } catch (\Exception $e) {
                }
            }
            if ($shops->save()) {
                return JsonResponse::create(['status' => true, 'message' => __('lang.done')]);
            }
        }

        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }

    public function singleshop($id)
    {
        $shop = Ships::find($id);
        if (!$shop) {
            return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
        }
        return response()->json(['status' => true, 'data' => new ShipResource($shop)]);
    }

    public function createshop($id = null, ShopRequest $request)
    {
        $shop = Ships::register($id, $request);
        if (isset($shop)) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.ship_saved_successfully'), 'data' => ['shop_id' => $shop->id]]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }

    public function deleteshop($id)
    {
        $provider = auth('api')->user();
        $project = Ships::where('id', $id)->where('user_id', $provider->id)->first();
        if (isset($project->id) && $project->delete()) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.done')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }

    public function deleteprojectshop($id, $project_id)
    {
        $provider = auth('api')->user();
        $project = Ships::where('id', $id)->where('user_id', $provider->id)->first();
        if ($project) {
            $project = ShopsProjects::where('shop_id', $id)->where('project_id', $project_id)->first();
            if ($project) {
                try {
                    $project->GetProject->user->notifyShopInviteRemove($project);
                } catch (\Exception $e) {
                }
            }
        } else {
            $project = null;
        }
        if (isset($project->id) && $project->delete()) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_deleted_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_not_found')]);
    }

    public function rateShopRequest(ShopRating $request)
    {
        $customer = auth('api')->user();
        $serviceRequest = Ships::find($request->shop_id);
        if ($serviceRequest) {
            if ($customer->hasShopCustomerRating($serviceRequest->id)) {
                return JsonResponse::create(['status' => false, 'message' => __('lang.shop_already_rated')]);
            }
            $request['provider_id'] = $serviceRequest->user_id;
            $request['shop_id'] = $serviceRequest->id;

            $customer->createShopRating($request);
            try {
                $customer->notifyShopRating($request);
            } catch (\Exception $e) {
            }
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_rated_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.shop_request_not_found')]);
    }

    public function inviteShop(ShipProjectsRequest $request)
    {
        /* $shop = ShopsProjects::register($request);
         if (isset($shop)) {
             $project = Project::find($request->project_id);
             if($project){
                 try{
                 $project->user->notifyShopInviteSend($shop);
                 }catch (\Exception $e){
                 }
             }
             return JsonResponse::create(['status' => true, 'message' => __('lang.done')]);
         }
         return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
         */
        $check_shop = ShopsProjects::where('shop_id', $request->shop_id)->where('project_id', $request->project_id)->count();

        if ($check_shop == 0) {
            $shop = ShopsProjects::register($request);
            if (isset($shop)) {
                $project = Project::find($request->project_id);
                if ($project) {
                    try {
                        $project->user->notifyShopInviteSend($shop);
                    } catch (\Exception $e) {
                    }
                }
                return JsonResponse::create(['status' => true, 'message' => __('lang.done')]);
            }

        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
    }


    public function fetchProviderServices($id = null, Request $request)
    {
        //   dd($request->user_id);
//        dd(auth('api')->user());

//        if(auth('api')->check() && )
//        $projects = Project::has('user')->get();
////            return $projects;
//        // return $projects;
//        foreach($projects as $project){
//            return $project->user->get_user_finicial_package;
//            $operationFainincial = $project->user->get_user_finicial_package()->first();
//            if(!empty($operationFainincial)) {
//                $now = Carbon::now();
//                $days = $project->user->package->days;
//                $created_at = $operationFainincial->end_date;
//                $package_expire = $operationFainincial->end_date;
//                // dd($created_at, $package_expire );.
//                if($now > $package_expire){
//                    $project->user()->update([
//                        'package_id'=> 2,
//                        'date_start'=> null,
//                        'date_end'=> null,
//                    ]);
//                }
//            }
//
//        }
        if ($id) {
            $projects = Project::has('user')->find($id);
            if (empty($projects)) {
                return response()->json(['status' => false, 'message' => 'لا يوجد بيانات']);

            }
            return response()->json(['status' => true, 'data' => new ServiceResource($projects)]);
        } else {


            $categories = Project::query()->has('user');
            $status_con = 0;
            if (isset($request->title) && !empty($request->title)) {
                $categories = $categories->where('name', 'LIKE', '%' . $request->title . '%');
            }
            if (isset($request->category_id) && !empty($request->category_id)) {
                $categories = $categories->where('category_id', $request->category_id);
            }
            if (isset($request->sub_category_id) && !empty($request->sub_category_id)) {
                $categories = $categories->where('sub_category_id', $request->sub_category_id);
            }
            if (isset($request->city_id) && !empty($request->city_id)) {
                $categories = $categories->whereHas('user', function ($query) use ($request) {
                    $query->where('city_id', $request->city_id);
                });
            }
            if (isset($request->country_id) && !empty($request->country_id)) {
                $categories = $categories->whereHas('user', function ($query) use ($request) {
                    $query->where('country_id', $request->country_id);
                });
            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'city' && isset(auth('api')->user()->city_id)) {
                $categories = $categories->WhereHas('user', function ($query) use ($request) {
                    $query->where('city_id', auth('api')->user()->city_id);
                });
            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'city' && isset(auth('api')->user()->city_id)) {
                $categories = $categories->WhereHas('user', function ($query) use ($request) {
                    $query->where('city_id', auth('api')->user()->city_id);
                });
            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'BestProject') {

                $categories = $categories->WhereHas('user', function ($query) use ($request) {
                    $query->where('package_id', 1);
                });

            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'user') {
//                return $categories->get();
                $categories = $categories->WhereHas('user', function ($query) use ($request) {
                    $query->where('id', $request->user_id);
                });
//                return $categories->get();
                if (isset(auth('api')->user()->id)) {
                    if (auth('api')->user()->id == $request->user_id) {
                        $status_con++;
                    }
                }


            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'country') {
//                return $categories->get();
                $defaultCountry = Country::where('sort_name', 'KSA')->first()->id;

                if (auth('api')->check()) {
                    $defaultCountry = auth('api')->user()->Country->id;
                }
                $categories = $categories->WhereHas('user', function ($query) use ($request, $defaultCountry) {
                    $query->where('country_id', $defaultCountry);
                });
            }
            if (isset($request->status) && !empty($request->status) && $request->status == 'close' && isset(auth('api')->user()->map_x) && isset(auth('api')->user()->map_y)) {

                $lat = auth('api')->user()->map_x ? auth('api')->user()->map_x : 0;
                $lng = auth('api')->user()->map_y ? auth('api')->user()->map_y : 0;
                $distance = 15;
                $categories = $categories->WhereHas('user', function ($query) use ($lat, $lng, $distance) {
                    $query->WhereRaw("((ACOS(SIN({$lat} * PI() / 180) * SIN(map_x * PI() / 180) + COS({$lat} * PI() / 180) * COS(map_x * PI() / 180) * COS(({$lng} - map_y) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) <= {$distance}");
                });
            }

            if ($status_con == 0) {
                $categories = $categories->where('status_id', '20')->where('is_active', '8');
            }

            $now = Carbon::now();
            /*           $projectsads = UserAds::where('begin_date', '<=', $now)
                           ->where('end_date', '>=', $now)
                           ->where('status_id', '20')
                           ->with('AdsType')
                           ->whereHas('AdsType', function ($q) {
                               $q->with('Ads')
                                   ->whereHas('Ads', function ($qy) {
                                       $qy->where('id', 1);
                                   });
                           })
                           ->get();
                           */
            $projectsads = UserAds::where('status_id', '20')
                ->where('end_date', '<', $now)
                ->with('AdsType')
                ->whereHas('AdsType', function ($q) {
                    $q->with('Ads')
                        ->whereHas('Ads', function ($qy) {
                            $qy->where('id', 1);
                        });
                })
                ->get();
            //    return $projectsads;
            //     $projectsads = Ads::findOrFail(1);
//            return $projectsads;

            $ads = 0;
            $rand = null;
            $item = null;
            if (!isset($request->shop_id)) {
                if (sizeof($projectsads) != 0) {
                    $item = $projectsads->random(1)->first();
                    //  return $item;
                    $item['is_ads'] = '1';
                    $ads = 1;
                }
            }
            /*

                        if (isset($request->status) && !empty($request->status) && $request->status == 'city' && isset($request->shop_id) && !empty($request->shop_id)) {
                $shop_id = $request->shop_id;
                $categories = $categories->WhereHas('ShopProject', function ($query) use ($shop_id){
                    $query->where('shop_id', $shop_id);
                });
            }

            */
            $projects = $categories->orderBy('created_at', 'DESC')
                ->WhereHas('user', function ($query) use ($request) {
                    $query->where('package_id', '!=', 0);
                })
                ->with('userads')
                ->paginate(10 - $ads);

            // dd($projects);


            if (sizeof($projects) > 1) {
                $rand = mt_rand(1, sizeof($projects) - 1);
            }

            //   dd($projects);


            $data = collect([]);

            if (sizeof($projects) != 0) {
                for ($i = 0; $i <= 9; $i++) {
                    if ($rand == $i) {
                        if (isset($item) && $item != null) {
                            $data->push($item->toArray());
                        }
                    }
                    if (isset($projects[$i])) {
                        $data->push($projects[$i]->toArray());
                    }
                }
            } else {
                if (isset($item) && $item != null) {
                    $data->push($item->toArray());
                }
            }

            //   return sizeof($projects);


            //return $projects;
            //dd($data);
            //  collect()
            /*
            $datas = Project::whereHas('userads',function($q){
            $q->where('type',"shop");
            })->with('userads')->inRandomOrder()->first();
            return $datas;
                        $projects = $projects->map(function($pro){
                return $pro->id;
            });
            return $projects;


            if(sizeof($projects) > 1){
                $rand = mt_rand( 1 , sizeof($projects)-1 );
            }

             */
            // $item = $projectsads->first();
            if (isset($projectsads) && count($projectsads) > 0)
                $item = $projectsads->random(1)->first();
            //     return $item;

            $data = collect(ServiceResourceAdsSingle::collection($projects));
//            dd($data);
            // dd($data[0]);


//            $projects = $projects->images;
            if (!(isset($request->status) && !empty($request->status) && $request->status == 'city') && !(isset($request->shop_id) && !empty($request->shop_id))) {
                if (isset($item) && in_array($item->type, ["project", "shop"])) {
                    $dd = Project::whereHas('userads', function ($q) {
                        $q->whereIn('type', ["project", "shop"]);
                    })->with('userads')->inRandomOrder()->first();
                    $adds_rand = collect(new ServiceResourceAdsSingle($dd));

                    $data->push($adds_rand);
                } elseif (isset($item) && $item->type == "url") {
                    $adds_rand = [
                        'id' => $item->id,
                        'is_ads' => (int)1,
                        'type' => (string)$item->type,
                        'url' => (string)$item->url,
                        'status_id' => (int)$item->status_id,
                        'country' => (string)@$item->user->Country->name,
                        'city' => (string)@$item->user->city->name,
                        'user_id' => (string)$item->user_id,
                        'image_url' => (string)@$item->getAvatarUrlAttribute(),
                    ];

                    $data->push($adds_rand);
                }

            }
            // dd($data[0]);

            //  return $adds_rand;
            return response()->json([
                'status' => true,
                'data' => $data
                , 'currentPage' => $projects->currentPage()
                , 'lastPage' => $projects->lastPage()
                , 'hasMorePages' => $projects->hasMorePages()
                , 'next' => $projects->nextPageUrl()
            ]);
        }
    }


    public function fetchFavoriteServices()
    {
        $customer = auth('api')->user();
        $services = $customer->favorites()->orderBy('created_at', 'DESC')->get();
        return JsonResponse::create(['status' => true, 'data' => ServiceResource::collection($services)]);
    }

    public function fetchFavoriteShop()
    {
        $customer = auth('api')->user();
        $services = $customer->favoritesShop()->orderBy('created_at', 'DESC')->get();
        return JsonResponse::create(['status' => true, 'data' => ShipResource::collection($services)]);
    }

    public function FeatchRating($id)
    {
        $customer = auth('api')->user();
//        dd($id);
        $ratings = \App\Rating::where('project_id', $id)->get();
//        dd($ratings);
        return JsonResponse::create(['status' => true, 'data' => RatingResource::collection($ratings)]);
    }

    public function favoriteService($id)
    {
        $user = auth('api')->user();
        $service = Project::find($id);
        if (isset($service)) {
            if ($user->hasFavorite($id)) {
                $user->favorites()->detach($id);
                return JsonResponse::create(['status' => true, 'message' => __('lang.deleted_successfully')]);
            } else {
                $user->favorites()->attach($id);
                return JsonResponse::create(['status' => true, 'message' => __('lang.service_favorite_successfully')]);
            }
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_not_found')]);
    }

    public function favoriteShop($id)
    {
        $user = auth('api')->user();
        $service = Ships::find($id);
        if (isset($service)) {
            if ($user->hasFavoriteShop($id)) {
                $user->favoritesShop()->detach($id);
                return JsonResponse::create(['status' => true, 'message' => __('lang.deleted_successfully')]);
            } else {
                $user->favoritesShop()->attach($id);
                return JsonResponse::create(['status' => true, 'message' => __('lang.service_favorite_successfully')]);
            }
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_not_found')]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getServicesRequests(Request $request)
    {
        $provider = auth('api')->user();
//        $projectRequests = $provider->providerRequests()->filter($request)->orderBy('created_at', 'DESC')->paginate(9);
        $projectRequests = $provider->providerServices()->filter($request)->orderBy('created_at', 'DESC')->paginate(9);
//        dd($projectRequests);
        return response()->json(array_merge(['status' => true, 'data' => ServiceRequestResource::collection($projectRequests)], array_except($projectRequests->toArray(), ['data'])));
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteService($id)
    {
        $provider = auth('api')->user();
//        return $provider;
        $project = $provider->providerMainServices()->find($id);
//        return $project;
        if (isset($project->id) && $project->delete()) {
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_deleted_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_not_found')]);
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function acceptServiceRequest($id)
    {
        $provider = auth('api')->user();
        $projectRequest = $provider->providerRequests()->find($id);
        if (isset($projectRequest->customer) && $projectRequest->isPending()) {
            try {
                $projectRequest->notifyCustomerForAccept();
            } catch (\Exception $e) {
            }
            $projectRequest->update(['status_id' => 13]);
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_request_accepted_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_request_not_found')]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function rejectServiceRequest($id, Request $request)
    {
        $provider = auth('api')->user();
        $projectRequest = $provider->providerRequests()->find($id);
        if (isset($projectRequest->customer) && $projectRequest->isPending()) {
            try {
                $projectRequest->notifyCustomerForReject($request);
            } catch (\Exception $e) {
            }
            $projectRequest->update(['status_id' => 15, 'reject_reason' => $request->reject_reason]);
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_request_rejected_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_request_not_found')]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function completeServiceRequest($id, Request $request)
    {
        $provider = auth('api')->user();
        $projectRequest = $provider->providerRequests()->find($id);
        if (isset($projectRequest->customer) && $projectRequest->isInProgress()) {
            try {
                $projectRequest->notifyCustomerForComplete($request);
            } catch (\Exception $e) {
            }
            $projectRequest->update(['status_id' => 17, 'price' => $request->price]);
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_request_completed_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_request_not_found')]);
    }


    /**
     * @return JsonResponse
     */
    public function fetchCommonServices()
    {
        $provider = auth('api')->user();
        $projects = $provider->providerServices()->orderByRequests()->latest()->take(5)->get();
        return JsonResponse::create(['status' => true, 'data' => ServiceResource::collection($projects)]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function reportServiceRequest(Report $request)
    {
        $provider = auth('api')->user();
        $project = Project::find($request->project_id);
        if (!$project) {
            return JsonResponse::create(['status' => false, 'message' => __('lang.project_not_found')]);
        }

        $project->createReport($request);
        return JsonResponse::create(['status' => true, 'message' => __('lang.report_sent_successfully')]);
    }

    public function reportShopRequest(ShopReport $request)
    {
        $provider = auth('api')->user();
        $project = Ships::find($request->shop_id);
        if (!$project) {
            return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
        }
        $project->createReport($request);
        return JsonResponse::create(['status' => true, 'message' => __('lang.report_sent_successfully')]);
    }


    public function rateServiceRequest(Rating $request)
    {
        $customer = auth('api')->user();
//        dd($customer);
        $serviceRequest = Project::find($request->project_id);
        if ($serviceRequest) {
            if ($customer->hasCustomerRating($serviceRequest->id)) {
                return JsonResponse::create(['status' => false, 'message' => __('lang.service_already_rated')]);
            }
            $request['provider_id'] = $serviceRequest->user_id;
            $request['project_id'] = $serviceRequest->id;

            $customer->createRating($request);
            try {
                $customer->notifyRating($request);
            } catch (\Exception $e) {
            }
            return JsonResponse::create(['status' => true, 'message' => __('lang.service_rated_successfully')]);
        }
        return JsonResponse::create(['status' => false, 'message' => __('lang.service_request_not_found')]);
    }

    public function sendpushnotification(Request $request)
    {
        try {
            return $this->sendpushnotifications($request);
        } catch (\Exception $e) {
//            return 'err';
//            return $e->getMessage();
        }
    }

    public function FeatchRatingShips($id)
    {
        $customer = auth('api')->user();
//        dd($id);
        $ratings = \App\ShopRating::where('shop_id', $id)->get();
//        dd($ratings);
        return JsonResponse::create(['status' => true, 'data' => RatingResource::collection($ratings)]);
    }

    public function payment_step_one(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $data = array();
//        $data['type'] = $type;
        $payment_methods = Payment::get_payment_method_last();
        if ($type == 'package') {
            $package = Package::query()->where('id', $id)->first();
//            return $package;
            if (!$package) {
                return JsonResponse::create([
                    'status' => false,
                    'message' => __('lang.error')
                ]);
            }
            $data['item'] = new PackagesResource($package);
            $data['payment_methods'] = $payment_methods;

        } elseif ($type == 'ads') {
            $ads = UserAds::query()->where('id', $id)->where('status_id', 30)->first();
            if (!$ads) {
                return JsonResponse::create([
                    'status' => false,
                    'message' => __('lang.error')
                ]);
            }
            $data['item'] = new MyAdsRescource($ads);
            $data['payment_methods'] = $payment_methods;
        }

        return response()->json(['status' => true, 'type' => $type, 'data' => $data]);
    }

    public function payment_step_two(Request $request)
    {
        $dataReq = $request->all();
        if ($dataReq['payment_type'] === 'visa') {
            $url = "https://test.oppwa.com/v1/checkouts";
            $random = mt_rand(10000, 99999);
            $user = User::where('id', $dataReq['user_id'])->first();
            $transactionId = "OSR-" . $random . "-" . $user['id'];

            $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                "&amount=" . number_format($dataReq['amount'], 2) .
                "&currency=EUR" .
                "&merchantTransactionId=" . $transactionId .
                "&paymentType=DB" .
                "&customer.email=" . $user['email'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
//        return $responseData;
            $response = json_decode($responseData, true);
            return view('payment-form', compact('response', 'dataReq'));

        } elseif ($dataReq['payment_type'] === 'mada') {
            $url = "https://test.oppwa.com/v1/checkouts";
            $random = mt_rand(10000, 99999);
            $user = User::where('id', $dataReq['user_id'])->first();
            $transactionId = "OSR-" . $random . "-" . $user['id'];

            $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                "&amount=" . number_format($dataReq['amount'], 2) .
                "&currency=SAR" .
                "&merchantTransactionId=" . $transactionId .
                "&paymentType=DB" .
                "&customer.email=" . $user['email'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
//        dd($responseData);
            $response = json_decode($responseData, true);


            return view('payment-mada-form', compact('response', 'dataReq'));
//        $url = "https://oppwa.com/v1/checkouts";
            $url = "https://test.oppwa.com/v1/checkouts";
            $random = mt_rand(10000, 99999);
            $amount = number_format(round($data['amount'], 2), 2, '.', '');
            $currencyCode = 'SAR';
            $transactionId = $random;
            $user = User::where('id', $data['user_id'])->first();
            $transactionId = "OSR-" . $random . "-" . $user['id'];

            $data = "entityId=8ac7a4ca742436880174263b644b109d" .
                "&amount=" . $amount .
                "&currency=" . $currencyCode .
                "&merchantTransactionId=" . $transactionId .
                "&paymentType=DB" .
                "&customer.email=" . $user['email'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjN2E0Y2E3NDI0MzY4ODAxNzQyNjM4ZjRjZjEwOGZ8c242a04zZmFDcQ=='
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

            return view('payment-mada-form', compact('response'));
        }
    }

    public function upgrade_package_new($id, $user_id, $payment_type)
    {
        $user = User::find($user_id);
        $data = [];
        if (!$user) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }
        $packages = Package::find($id);
        if (!$packages) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }

//        return view('payment.payment_log' , $data);
//        $balance = $user->Balance;
//
//        if($packages->price > $balance){
//            return JsonResponse::create([
//                'status' => false,
//                'message' => __('lang.balance')
//            ]);
//        }

        $package_operation = $user->get_user_finicial_package()->first();
//        return $package_operation;
        $operation_type = 2;
        if (!empty($package_operation) && $package_operation->user->date_end < Carbon::now()) {
            if ($packages->id == $package_operation->OperationData) {
                $operation_type = 3;
            } elseif ($packages->id !== $package_operation->OperationData) {
                $operation_type = 4;
            }
        }

        $days = (int)isset($packages->days) ? $packages->days : 0;
        if ($days == 0) {
            $days = null;
        } else {
            $days = Carbon::now()->addDays($days);
        }

        $UserFinanical = UsersFinancialOperations::create([
            'TypeMovement' => 'minus',
            'SectionOperation' => 'account',
            'TypeOperation' => 'upgrade',
            'TypePayment' => $payment_type,
            'OperationData' => $packages->id,
            'OperationType' => $operation_type,
            'Amount' => $packages->price,
            'start_date' => Carbon::now(),
            'end_date' => $days,
            'UserId' => $user->id
        ]);
        if (!$UserFinanical) {
            return JsonResponse::create(['status' => false, 'message' => __('lang.error')]);
        }


        $user->package_id = $packages->id;
        $user->date_start = Carbon::now();
        $user->date_end = $days;
        $user->save();
        $data['user'] = $user;
        $data['pay'] = $user->package;
        $data['type'] = 'package';
        return $data;
    }

    public function update_ads_pay($id, $user_id, $payment_type)
    {
        $myAds = UserAds::find($id);
        $user = User::find($user_id);
        if (!$myAds) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }
        if (!$user) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }
        $UserFinanical = UsersFinancialOperations::create([
            'TypeMovement' => 'minus',
            'SectionOperation' => $myAds->type,
            'TypeOperation' => 'ads',
            'OperationData' => $myAds->id,
            'TypePayment' => $payment_type,
            'start_date' => $myAds->begin_date,
            'end_date' => $myAds->end_date,
            'Amount' => $myAds->AdsType->price,
            'UserId' => $user->id
        ]);
        if (!$UserFinanical) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }

        $myAds->status_id = 20;
        $myAds->finanical_id = $UserFinanical->OperationId;
        $saved = $myAds->save();
        if (!$saved) {
            return JsonResponse::create([
                'status' => false,
                'message' => __('lang.error')
            ]);
        }

        $data['user'] = $user;
        $data['pay'] = $myAds;
        $data['type'] = 'ads';
        return $data;
    }

    public function fetchSplashPannerAds() {
        $proj = UserAds::where('begin_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->where('status_id', '20')
            ->whereHas('AdsType', function ($q) {
                $q->where('ads_id' , 2);
                $q->orWhere('ads_id' , 5);
            })->get();
        $size = 3;
        if($size <= sizeof($proj)){
            $proj = $proj->random($size);
        }
//        return $proj;

        return JsonResponse::create(['status' => true, 'data' => FullAds::collection($proj)]);

    }

}
