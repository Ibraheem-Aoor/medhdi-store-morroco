@extends('admin.layouts.app')
@section('title', translate('General Settings'))

@section('content')

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0 h6">{{ translate('General Settings') }}</h1>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Name') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="site_name">
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ get_setting('site_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Logo - White') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="system_logo_white">
                                    <input type="hidden" name="system_logo_white"
                                        value="{{ get_setting('system_logo_white') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                <small>{{ translate('Will be used in admin panel side menu') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Logo - Black') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="system_logo_black">
                                    <input type="hidden" name="system_logo_black"
                                        value="{{ get_setting('system_logo_black') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                <small>{{ translate('Will be used in admin panel topbar in mobile + Admin login page') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('System Timezone') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="types[]" value="timezone">
                                <select name="timezone" class="form-control aiz-selectpicker" data-live-search="true">
                                    @foreach (timezones() as $key => $value)
                                        <option value="{{ $value }}"
                                            @if (app_timezone() == $value) selected @endif>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Admin login page background') }}</label>
                            <div class="col-sm-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose Files') }}</div>
                                    <input type="hidden" name="types[]" value="admin_login_background">
                                    <input type="hidden" name="admin_login_background"
                                        value="{{ get_setting('admin_login_background') }}" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label">{{ translate('Enable Tax System') }}</label>
                            <div class="col-sm-9">
                                <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                    <input type="checkbox" onchange="updateSettings(this, 'tax_activation')"
                                        <?php if (get_setting('tax_activation') == 1) {
                                            echo 'checked';
                                        } ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-from-label">{{ translate('Tax Type') }}</label>
                            <div class="col-sm-4">
                            <input type="hidden" name="types[]" value="general_tax_type">

                                <select class="form-control aiz-selectpicker" name="general_tax_type">
                                    <option value="amount" @if(get_setting('general_tax_type')  == 'amount') selected @endif>{{ translate('Flat') }}</option>
                                    <option value="percent" @if(get_setting('general_tax_type')  == 'percent') selected @endif>{{ translate('Percent') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label class="col-from-label">{{ translate('Tax Value') }}</label>
                            <input type="hidden" name="types[]" value="tax_value">
                            <div class="col-sm-4">
                                <input type="text" name="tax_value" class="form-control"
                                    value="{{ get_setting('tax_value') }}">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                        </div>
                    </form>
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
