@extends('admin.layouts.app')

@section('content')
    <h4 class="text-center text-muted">{{ translate('System') }}</h4>
    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center bord-btm">
                    <h3 class="mb-0 h6 text-center">{{ translate('HyperPay Payment Activation') }}</h3>
                </div>
                <div class="card-body">
                    <div class="clearfix">
                        <img class="float-left" src="{{asset('assets/img/cards/hyper-pay.png')}}" height="30">
                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                            <input type="checkbox" onchange="updateSettings(this, 'hyperpay_payment')" <?php if (get_setting('hyperpay_payment') == 1) {
                                echo 'checked';
                            } ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="alert text-center"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Hyperpay correctly to enable this feature') }}. <a
                            href="{{ route('payment_configuration.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{ translate('Cash Payment Activation') }}</h3>
                </div>
                <div class="card-body text-center">
                    <div class="clearfix">
                        <img class="float-left" src="{{ asset('assets/img/cards/cod.png') }}" height="30">
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
                    console.log(data);
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    console.log(data);
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
