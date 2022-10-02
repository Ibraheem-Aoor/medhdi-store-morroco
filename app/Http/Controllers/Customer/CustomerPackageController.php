<?php
namespace App\Http\Controllers\Customer;

use App\Utility\PayfastUtility;
use Illuminate\Http\Request;
use App\Models\CustomerPackage;
use App\Models\CustomerPackageTranslation;
use App\Models\CustomerPackagePayment;
use Auth;
use Session;
use App\Models\User;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\VoguePayController;
use App\Utility\PayhereUtility;
use App\Http\Controllers\Controller;

class CustomerPackageController extends Controller
{

    public function purchase_package(Request $request)
    {
        $data['customer_package_id'] = $request->customer_package_id;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'customer_package_payment');
        $request->session()->put('payment_data', $data);

        $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);

        if ($customer_package->amount == 0) {
            $user = User::findOrFail(Auth::user()->id);
            if ($user->customer_package_id != $customer_package->id) {
                return $this->purchase_payment_done(Session::get('payment_data'), null);
            } else {
                flash(translate('You can not purchase this package anymore.'))->warning();
                return back();
            }
        }

        $decorator = __NAMESPACE__ . '\\Payment\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $request->payment_option))) . "Controller";
        if (class_exists($decorator)) {
            return (new $decorator)->pay($request);
        }
    }


}
