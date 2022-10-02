@extends('admin.layouts.app')

@section('content')
    <h4 class="text-center text-muted">{{ translate('Payment Activation') }}</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center bord-btm">
                    <h3 class="mb-0 h6 text-center">{{ translate('Paypal Payment Activation') }}</h3>
                </div>
                <div class="card-body">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/paypal.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'paypal_payment')" <?php if (get_setting('paypal_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert text-center"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Paypal correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Stripe Payment Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/stripe.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'stripe_payment')" <?php if (get_setting('stripe_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure Stripe correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Mercadopago Payment Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/mercadopago.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'mercadopago_payment')"
                                <?php if (get_setting('mercadopago_payment') == 1) {
                                    echo 'checked';
                                } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure Mercadopago correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('SSlCommerz Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/sslcommerz.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'sslcommerz_payment')"
                                <?php if (get_setting('sslcommerz_payment') == 1) {
                                    echo 'checked';
                                } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure SSlCommerz correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Instamojo Payment Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/instamojo.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'instamojo_payment')" <?php if (get_setting('instamojo_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Instamojo Payment correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Razor Pay Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/rozarpay.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'razorpay')" <?php if (get_setting('razorpay') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Razor correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('PayStack Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/paystack.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'paystack')" <?php if (get_setting('paystack') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure PayStack correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('VoguePay Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/vogue.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'voguepay')" <?php if (get_setting('voguepay') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure VoguePay correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Payhere Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/payhere.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'payhere')" <?php if (get_setting('payhere') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure VoguePay correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Ngenius Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/ngenius.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'ngenius')" <?php if (get_setting('ngenius') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Ngenius correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Iyzico Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/iyzico.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'iyzico')" <?php if (get_setting('iyzico') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure iyzico correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Bkash Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/bkash.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'bkash')" <?php if (get_setting('bkash') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure bkash correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Nagad Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/nagad.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'nagad')" <?php if (get_setting('nagad') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure nagad correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Proxy Pay Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/proxypay.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'proxypay')" <?php if (get_setting('proxypay') == '1') {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure proxypay correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Amarpay Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/aamarpay.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'aamarpay')"
                                @if (get_setting('aamarpay') == '1') checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure amarpay correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Authorize Net Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/authorizenet.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'authorizenet')" <?php if (get_setting('authorizenet') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure authorize net correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Payku Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/payku.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'payku')" <?php if (get_setting('payku') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure payku net correctly to enable this feature') }}. <a
                            href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Mada Payement Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/mada.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'mada_payment')" <?php if (get_setting('mada_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure Mercadopago correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Visa / Master Card Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/visa-master.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'visa_payment')" <?php if (get_setting('visa_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure Mercadopago correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('HyperPay Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/hyper-pay.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'hyperpay_payment')"
                                <?php if (get_setting('hyperpay_payment') == 1) {
                                    echo 'checked';
                                } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        You need to configure Mercadopago correctly to enable this feature. <a
                            href="{{ route('payment_method.index') }}">Configure Now</a>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Cash Payment Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/cod-1.png') }}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'cash_payment')" <?php if (get_setting('cash_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
