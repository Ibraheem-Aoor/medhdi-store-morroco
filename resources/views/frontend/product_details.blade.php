@extends('frontend.layouts.app')

{{-- @section('meta_title'){{ $detailedProduct->meta_title }}@stop --}}

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency"
        content="{{ \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
    <style>
        meter{
            width:80%;
        }
        .custom-btn{
            width: 60%;
        }

        .countdown-timer-container {
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        }
        .countdown-timer-container div {
        width: 25%;
        text-align: center;
        font-size: 20px;
        }
        .countdown-timer-values {
        font-size: 30px !important;
        }

    @media (max-width: 767.98px) {
        meter{
            width: 80% !important;
        }
        .custom-btn{
            width: 85%;
        }

    }
    </style>
@endsection

@section('content')
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white shadow-sm rounded p-3">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            @php
                                $photos = explode(',', $detailedProduct->photos);
                            @endphp
                            <div class="col order-1 order-md-2">
                                <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb'
                                    data-fade='true' data-auto-height='true'>
                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box img-zoom rounded">
                                            <img class="img-fluid lazyload"
                                                src="{{ asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box img-zoom rounded">
                                                <img class="img-fluid lazyload"
                                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                <div class="aiz-carousel product-gallery-thumb" data-items='5'
                                    data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false'
                                    data-focus-select='true' data-arrows='true'>
                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box c-pointer border p-1 rounded">
                                            <img class="lazyload mw-100 size-50px mx-auto"
                                                src="{{ asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                    @endforeach
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box c-pointer border p-1 rounded"
                                                data-variation="{{ $stock->variant }}">
                                                <img class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="">
                            <h1 class="mb-2 fs-22 fw-600 text-center">
                                {{ $detailedProduct->getTranslation('name') }}
                            </h1>

                            {{-- <div class="row align-items-center">
                                <div class="col-12 mb-2">
                                    @php
                                        $total = 0;
                                        $total += $detailedProduct->reviews->count();
                                    @endphp
                                    <span class="rating">
                                        {{ renderStarRating($detailedProduct->rating) }}
                                    </span>
                                    <span class="ml-1 opacity-50">({{ $total }}
                                        {{ translate('reviews') }})</span>
                                </div>
                                @if ($detailedProduct->est_shipping_days)
                                    <div class="col-auto ml">
                                        <small class="mr-2 opacity-90">{{ translate('Estimate Shipping Time') }}:
                                        </small>{{ $detailedProduct->est_shipping_days }} {{ translate('Days') }}
                                    </div>
                                @endif
                            </div> --}}

                            {{-- <hr> --}}

                            <div class="row no-gutters align-items-center my-2">


                                @if ($detailedProduct->brand != null)
                                    <div class="col-sm-10">
                                        <a href="{{ route('products.brand', $detailedProduct->brand->slug) }}">
                                            <img src="{{ uploaded_asset($detailedProduct->brand->logo) }}"
                                                alt="{{ $detailedProduct->brand->getTranslation('name') }}"
                                                height="30">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- <hr> --}}

                            @if ($detailedProduct->wholesale_product)
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Min Qty') }}</th>
                                            <th>{{ translate('Max Qty') }}</th>
                                            <th>{{ translate('Unit Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detailedProduct->stocks->first()->wholesalePrices as $wholesalePrice)
                                            <tr>
                                                <td>{{ $wholesalePrice->min_qty }}</td>
                                                <td>{{ $wholesalePrice->max_qty }}</td>
                                                <td class="fw-600 fs-15">{{ single_price($wholesalePrice->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                @if (home_price($detailedProduct) != home_discounted_price($detailedProduct))
                                    <div class="row no-gutters my-2">
                                        <div class="col-sm-12">
                                            <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Price') }}: &nbsp;<del class="h6 opacity-60" style="font-weight: 900; font-size:20px;">
                                                {{ home_price($detailedProduct) }}
                                            </del></div>

                                        </div>
                                    </div>

                                    <div class="row no-gutters my-2">
                                        <div class="col-sm-12">
                                            <div class="opacity-90 fs-16 mb-2 mb-sm-0" >
                                                {{ translate('Discount Price') }}: &nbsp; <strong class="h6  text-primary" style="font-weight: 900; font-size:20px;">
                                                    {{ home_discounted_price($detailedProduct) }}
                                                </strong>
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    <div class="row no-gutters my-2">
                                        <div class="col-sm-12">
                                            <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Price') }}: &nbsp;  <strong class="h6 fw-600 text-primary" style="font-weight: 900; font-size:1.7rem;"> {{ home_discounted_price($detailedProduct) }}
                                            </strong></div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if (addon_is_activated('club_point') && $detailedProduct->earn_point > 0)
                                <div class="row no-gutters my-2">
                                    <div class="col-sm-2">
                                        <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Club Point') }}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div
                                            class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                            <span class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- <hr> --}}

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                @if ($detailedProduct->choice_options != null)
                                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                                        <div class="row no-gutters my-2">
                                            <div class="col-sm-2">
                                                <div class="opacity-90 fs-16 mb-2 mb-sm-0">
                                                    {{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="aiz-radio-inline">
                                                    @foreach ($choice->values as $key => $value)
                                                        <label class="aiz-megabox pl-0 mr-2">
                                                            <input type="radio"
                                                                name="attribute_id_{{ $choice->attribute_id }}"
                                                                value="{{ $value }}"
                                                                @if ($key == 0) checked @endif>
                                                            <span
                                                                class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                                {{ $value }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if (count(json_decode($detailedProduct->colors)) > 0)
                                    <div class="row no-gutters my-2">
                                        <div class="col-sm-2">
                                            <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Color') }}:</div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="aiz-radio-inline">
                                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                    <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip"
                                                        data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                                        <input type="radio" name="color"
                                                            value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                                            @if ($key == 0) checked @endif>
                                                        <span
                                                            class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                            <span class="size-30px d-inline-block rounded"
                                                                style="background: {{ $color }};"></span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <hr> --}}
                                @endif

                                <!-- Quantity + Add to cart -->
                                <div class="row no-gutters my-2 mt-3 product-quantity-box">
                                    {{-- <div class="col-lg-5 col-sm-4 text-left">
                                        <div></div>
                                    </div> --}}
                                    <div class="col-sm-8  col-lg-6">
                                        <div class="product-quantity d-flex align-items-center">

                                            <div class="row no-gutters align-items-center aiz-plus-minus"
                                                style="width: 100px;">
                                                <span  class="opacity-90 fs-16 mb-3 mb-sm-0">{{ translate('Quantity') }}:
                                                </span>
                                                <button class="btn-sm btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                    type="button" data-type="minus" data-field="quantity" style="width: 15%;"
                                                    disabled=""> &nbsp;
                                                    <i class="las la-minus"></i>
                                                </button>
                                                <input style="width: 10%;margin-right:7%;" type="number" name="quantity"
                                                    class="col border-0 flex-grow-1 fs-16 input-number"
                                                    placeholder="1" value="{{ $detailedProduct->min_qty }}"
                                                    min="{{ $detailedProduct->min_qty }}" max="10"
                                                    lang="en"
                                                    onchange="updateQuantity({{ $detailedProduct->id }}, this)">
                                                <button class="btn-sm btn  col-auto btn-icon btn-sm btn-circle btn-light"
                                                    type="button" data-type="plus" data-field="quantity" style="width: 15%;">
                                                    <i class="las la-plus"></i>
                                                </button>
                                            </div>
                                            @php
                                                $qty = 0;
                                                foreach ($detailedProduct->stocks as $key => $stock) {
                                                    $qty += $stock->qty;
                                                }
                                            @endphp
                                            <div class="avialable-amount opacity-60 mx-2">
                                                @if ($detailedProduct->stock_visibility_state == 'quantity')
                                                    (<span id="available-quantity">{{ $qty }}</span>
                                                    {{ translate('available') }})
                                                @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
                                                    (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <hr> --}}

                                <div class="row no-gutters my-3 d-none" id="chosen_price_div">
                                    <div class="col-sm-12">
                                        <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Total Price') }}: &nbsp;<strong id="chosen_price" class="h4 fw-600 text-primary">
                                            </strong>
                                        </div>

                                </div>
                                </div>
                            </form>

                            <div class="mt-3 text-center">
                                <button type="button" class="btn buy-now-btn buy-now fw-600 custom-btn" id="buy_now_button"  onclick="buyNow();">
                                    <i class="la la-shopping-cart fs-24"></i>
                                    <span>{{ translate('Buy Now') }}&nbsp;&nbsp;&nbsp;</span>
                                </button>
                                <button type="button" class="btn btn-info out-of-stock fw-600 d-none" disabled>
                                    {{-- <i class="la la-cart-arrow-down"></i> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25"
                                        height="25">
                                        <path
                                            d="M3.5 3C2.673 3 2 3.673 2 4.5L2 9L3 9L3 19C3 20.103 3.897 21 5 21L10.587891 21C10.331891 20.369 10.155359 19.699 10.068359 19L5 19L5 9L19 9L19 10.068359C19.699 10.155359 20.369 10.331891 21 10.587891L21 9L22 9L22 4.5C22 3.673 21.327 3 20.5 3L3.5 3 z M 4 5L20 5L20 7L4 7L4 5 z M 9 11L9 13L11.759766 13C12.410766 12.189 13.215859 11.507 14.130859 11L9 11 z M 18 12C14.698136 12 12 14.698136 12 18C12 21.301864 14.698136 24 18 24C21.301864 24 24 21.301864 24 18C24 14.698136 21.301864 12 18 12 z M 18 14C20.220984 14 22 15.779016 22 18C22 18.743688 21.786236 19.429056 21.4375 20.023438L15.976562 14.5625C16.570944 14.213764 17.256312 14 18 14 z M 14.5625 15.976562L20.023438 21.4375C19.429056 21.786236 18.743688 22 18 22C15.779016 22 14 20.220984 14 18C14 17.256312 14.213764 16.570944 14.5625 15.976562 z"
                                            fill="#856404" />
                                    </svg>
                                    <span class="px-2"> {{ translate('Out of Stock') }} </span>
                                </button>
                            </div>
                            <div class="mt-2 text-center">
                                <button type="button" class="btn btn add-to-cart-btn add-to-cart custom-btn fw-600"
                                onclick="addToCart()">
                                <i class="las la-shopping-bag fs-24"></i>
                                <span class=" d-md-inline-block"> {{ translate('Add to cart') }}</span>
                            </button>
                            </div>
                            <div class="mt-2 text-center">
                                <h4>{{ translate('Left Quantity') }} <span class="text-danger fs-40">{{ mt_rand(20, 50) }}</span> {{ translate('In Stock') }} </h4>

                                <div class="text-center my-4">
                                    <h4 class="text-danger">{{ translate('This Offer End After:') }}</h4>
                                    <meter id="disk_c" value="{{ rand(20, 80) }}" low="30" high="60" min="20" max="100"></meter>
                                    <h4>
                                        <div class="countdown-timer-container">
                                            <div class="countdown-timer-values" id="days">00</div>
                                            <div class="countdown-timer-values" id="hours">00</div>
                                            <div class="countdown-timer-values" id="minutes">00</div>
                                            <div class="countdown-timer-values" id="seconds">00</div>
                                            <div>{{translate('Day')}}</div>
                                            <div>{{translate('Hour')}}</div>
                                            <div>{{translate('Minute')}}</div>
                                            <div>{{translate('Second')}}</div>
                                            </div>
                                        <h4>
                                </div>
                            </div>








                            @php
                                $refund_sticker = get_setting('refund_sticker');
                            @endphp
                            @if (addon_is_activated('refund_request'))
                                <div class="row no-gutters my-2">
                                    <div class="col-2">
                                        <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Refund') }}:</div>
                                    </div>
                                    <div class="col-10">
                                        <a href="{{ route('returnpolicy') }}" target="_blank">
                                            @if ($refund_sticker != null)
                                                <img src="{{ uploaded_asset($refund_sticker) }}" height="36">
                                            @else
                                                <img src="{{ asset('assets/img/refund-sticker.jpg') }}" height="36">
                                            @endif
                                        </a>
                                        <a href="{{ route('returnpolicy') }}" class="ml-2"
                                            target="_blank">{{ translate('View Policy') }}</a>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="row no-gutters my-2">
                                <div class="col-sm-1 align-self-center">
                                    <div class="opacity-90 fs-16 mb-2 mb-sm-0">{{ translate('Share') }}:</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-share"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                <div class="col-xl-3 order-1 order-xl-0">
                    @if ($detailedProduct->added_by == 'seller' && $detailedProduct->user->shop != null)
                        <div class="bg-white shadow-sm mb-3">
                            <div class="position-relative p-3 text-left">
                                @if ($detailedProduct->user->shop->verification_status)
                                    <div class="absolute-top-right p-2 bg-white z-1">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                            viewBox="0 0 287.5 442.2" width="22" height="34">
                                            <polygon style="fill:#F8B517;"
                                                points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 " />
                                            <circle style="fill:#FBD303;" cx="143.8" cy="143.8"
                                                r="143.8" />
                                            <circle style="fill:#F8B517;" cx="143.8" cy="143.8"
                                                r="93.6" />
                                            <polygon style="fill:#FCFCFD;"
                                                points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.3
                                                    60,116.6 124.1,116.6 " />
                                        </svg>
                                    </div>
                                @endif
                                <div class="opacity-50 fs-12 border-bottom">{{ translate('Sold by') }}</div>
                                <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                    class="text-reset d-block fw-600">
                                    {{ $detailedProduct->user->shop->name }}
                                    @if ($detailedProduct->user->shop->verification_status == 1)
                                        <span class="ml-2"><i class="fa fa-check-circle"
                                                style="color:green"></i></span>
                                    @else
                                        <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span>
                                    @endif
                                </a>
                                <div class="location opacity-70">{{ $detailedProduct->user->shop->address }}</div>
                                <div class="text-center border rounded p-2 mt-3">
                                    <div class="rating">
                                        @if ($total > 0)
                                            {{ renderStarRating($detailedProduct->user->shop->rating) }}
                                        @else
                                            {{ renderStarRating(0) }}
                                        @endif
                                    </div>
                                    <div class="opacity-60 fs-12">({{ $total }}
                                        {{ translate('customer reviews') }})</div>
                                </div>
                            </div>
                            {{-- <div class="row no-gutters align-items-center border-top">
                                <div class="col">
                                    <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                        class="d-block btn btn-soft-primary rounded-0">{{ translate('Visit Store') }}</a>
                                </div>
                                <div class="col">
                                    <ul class="social list-inline mb-0">
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->facebook }}"
                                                class="facebook" target="_blank">
                                                <i class="lab la-facebook-f opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->google }}" class="google"
                                                target="_blank">
                                                <i class="lab la-google opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->twitter }}"
                                                class="twitter" target="_blank">
                                                <i class="lab la-twitter opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ $detailedProduct->user->shop->youtube }}"
                                                class="youtube" target="_blank">
                                                <i class="lab la-youtube opacity-60"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    @endif
                    <div class="bg-white rounded shadow-sm mb-3">
                        <div class="p-3 border-bottom fs-16 fw-600">
                            {{ translate('Top Selling Products') }}
                        </div>
                        <div class="p-3">
                            <ul class="list-group list-group-flush">
                                @foreach (filter_products(\App\Models\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))->limit(6)->get() as $key => $top_product)
                                    <li class="py-3 px-0 list-group-item border-light">
                                        <div class="row gutters-10 align-items-center">
                                            <div class="col-5">
                                                <a href="{{ route('product', $top_product->slug) }}"
                                                    class="d-block text-reset">
                                                    <img class="img-fit lazyload h-xxl-110px h-xl-80px h-120px"
                                                        src="{{ asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                                        alt="{{ $top_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="col-7 text-left">
                                                <h4 class="fs-13 text-truncate-2">
                                                    <a href="{{ route('product', $top_product->slug) }}"
                                                        class="d-block text-reset">{{ $top_product->getTranslation('name') }}</a>
                                                </h4>
                                                <div class="rating rating-sm mt-1">
                                                    {{ renderStarRating($top_product->rating) }}
                                                </div>
                                                <div class="mt-2">
                                                    <span
                                                        class="fs-17 fw-600 text-primary">{{ home_discounted_base_price($top_product) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 order-0 order-xl-1">
                    <div class="bg-white mb-3 shadow-sm rounded">
                        <div class="nav border-bottom aiz-nav-tabs">
                            <a href="#tab_default_1" data-toggle="tab"
                                class="p-3 fs-16 fw-600 text-reset active show">{{ translate('Description') }}</a>
                            @if ($detailedProduct->video_link != null)
                                <a href="#tab_default_2" data-toggle="tab"
                                    class="p-3 fs-16 fw-600 text-reset">{{ translate('Video') }}</a>
                            @endif
                            @if ($detailedProduct->pdf != null)
                                <a href="#tab_default_3" data-toggle="tab"
                                    class="p-3 fs-16 fw-600 text-reset">{{ translate('Downloads') }}</a>
                            @endif
                        </div>

                        <div class="tab-content pt-0">
                            <div class="tab-pane fade active show" id="tab_default_1">
                                <div class="p-4">
                                    <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                                        <?php echo $detailedProduct->getTranslation('description'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab_default_2">
                                <div class="p-4">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                                            <iframe class="embed-responsive-item"
                                                src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                        @elseif ($detailedProduct->video_provider == 'dailymotion' &&
                                            isset(explode('video/', $detailedProduct->video_link)[1]))
                                            <iframe class="embed-responsive-item"
                                                src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                        @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                                            <iframe
                                                src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                                                width="500" height="281" frameborder="0" webkitallowfullscreen
                                                mozallowfullscreen allowfullscreen></iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab_default_3">
                                <div class="p-4 text-center ">
                                    <a href="{{ uploaded_asset($detailedProduct->pdf) }}"
                                        class="btn btn-primary">{{ translate('Download') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded shadow-sm">
                        <div class="border-bottom p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                <span class="mr-4">{{ translate('Related products') }}</span>
                            </h3>
                        </div>
                        <div class="p-3">
                            <div class="aiz-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="3"
                                data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2"
                                data-arrows='true' data-infinite='true'>
                                @foreach (filter_products(\App\Models\Product::where('category_id', $detailedProduct->category_id)->where('id', '!=', $detailedProduct->id))->limit(10)->get() as $key => $related_product)
                                    <div class="carousel-box">
                                        <div
                                            class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="">
                                                <a href="{{ route('product', $related_product->slug) }}"
                                                    class="d-block">
                                                    <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                        src="{{ asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                                        alt="{{ $related_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">
                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                    <a href="{{ route('product', $related_product->slug) }}"
                                                        class="d-block text-reset">{{ $related_product->getTranslation('name') }}</a>
                                                </h3>
                                                <div class="fs-15">
                                                    @if (home_base_price($related_product) != home_discounted_base_price($related_product))
                                                        <del
                                                            class="fw-600 opacity-50 mr-1">{{ home_base_price($related_product) }}</del>
                                                    @endif
                                                    <span
                                                        class="fw-700 text-primary">{{ home_discounted_base_price($related_product) }}</span>
                                                </div>
                                                <div class="rating rating-sm mt-1">
                                                    {{ renderStarRating($related_product->rating) }}
                                                </div>

                                                @if (addon_is_activated('club_point'))
                                                    <div
                                                        class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                        {{ translate('Club Point') }}:
                                                        <span
                                                            class="fw-700 float-right">{{ $related_product->earn_point }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" id="chatForm"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600" id="submitQuestion">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                @if (addon_is_activated('otp_system'))
                                    <input type="text"
                                        class="form-control h-auto form-control-lg {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                                        name="email" id="email">
                                @else
                                    <input type="text"
                                        class="form-control h-auto form-control-lg {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        value="{{ old('phone') }}" placeholder="{{ translate('Phone') }}"
                                        name="phone">
                                @endif
                                @if (addon_is_activated('otp_system'))
                                    <span class="opacity-60">{{ translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                        </div>
                        @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                            class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('google_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                            class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                            class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('script')
<script>
    function show_address_modal(){
          $('#new-address-modal').modal('show');
  }
</script>

<script>
    var rand_days = {{date('d' , (int)$discount_end_date)}};
    var rand_hours = {{date('h' , (int)$discount_end_date)}};
    var rand_minutes = {{date('i' , (int)$discount_end_date)}};
    var rand_seconds = {{date('s' , (int)$discount_end_date)}};
</script>
<script src="{{ asset('assets/js/countdown.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
            $('#chatForm').on('submit' , function()
            {
                $('#submitQuestion').attr('disabled' , 'disabled');
            });
        });






        function updateQuantity(key, element) {
            $.post('{{ route('product.updateQuantity') }}', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element.value
            }, function(data) {
                $('#chosen_price').html(data);
            });
        }

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show'); @endif
                                                                                }
                                                                            </script>

@endsection
