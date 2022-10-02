@extends('frontend.layouts.app')

@section('content')
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    @php
                        $first_order = $combined_order->orders->first();
                    @endphp
                    <div class="text-center py-4 mb-4">
                        <i class="la la-check-circle la-3x text-success mb-3"></i>
                        <h1 class="h3 mb-3 fw-600">{{ translate('Thank You for Your Order!') }}</h1>
                        <p class="opacity-70 font-italic">
                            {{-- {{ translate('A copy or your order summary has been sent to') }} --}}
                            {{-- {{ json_decode($first_order->shipping_address)->email }}</p> --}}
                    </div>
                    <div class="mb-4 bg-white p-4 rounded shadow-sm">
                        <h5 class="fw-600 mb-3 fs-17 pb-2 text-center text-success"> <span>{{translate('Order Recived')}}</span></h5>
                        <p class="fw-200 mb-1 text-center">
                            {{translate('contact_will_be')}}
                        </p>
                        {{-- <p class="fw-200 mb-1 text-center">
                            <span class="fw-900"> {{translate('important_note')}}: </span> {{translate('please_keep_phone_alive')}}
                        </p> --}}

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
