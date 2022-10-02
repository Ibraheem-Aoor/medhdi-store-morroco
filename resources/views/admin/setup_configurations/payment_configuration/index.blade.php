@extends('admin.layouts.app')
@section('title', translate('Order Configuration'))
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('HYPER PAY SETTINGS') }}</h5>
                </div>
                <form action="{{ route('payment_configuration.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="control-label">{{ translate('Hyper Pay Entity ID') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="hyper_id"
                                    value="{{ env('HYPER_PAY_ID') }}"
                                    placeholder="{{ translate('HYPER PAY ENTITY ID') }}" required>
                                <span class="slider round"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="control-label">{{ translate('Hyper Pay Key') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="hyper_key"
                                    value="{{ env('HYPER_PAY_KEY') }}" placeholder="{{ translate('HYPER PAY KEY') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="control-label">{{ translate('Mada Entity ID') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mada_id"
                                    value="{{ env('HYPER_MADA_ID') }}" placeholder="{{ translate('MADA ENTITY ID') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="control-label">{{ translate('Mada Entity KEY') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="mada_key"
                                    value="{{ env('HYPER_MADA_KEY') }}"
                                    placeholder="{{ translate('MADA ENTITY KEY') }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
