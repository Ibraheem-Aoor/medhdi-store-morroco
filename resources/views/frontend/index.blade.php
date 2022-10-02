@extends('frontend.layouts.app')
{{-- TEST --}}

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area mb-2 pt-3">
        <div class="container">
            <div class="row gutters-10  position-relative">
                <div class="col-lg-3 position-static d-none d-lg-block category_menu-wrap">
                    @include('frontend.partials.category_menu')
                </div>

                @php
                    $num_todays_deal = count($todays_deal_products);
                @endphp



                <div class="@if ($num_todays_deal > 0) col-lg-7 @else col-lg-9 @endif">
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom" data-arrows="true" data-dots="true"
                            data-autoplay="true">
                            @php
                                $slider_images = json_decode(get_setting('home_slider_images', null, app()->getLocale()), true);
                                //Bring Arabic sliders
                                if ($slider_images == null) {
                                    $slider_images = json_decode(get_setting('home_slider_images', null, 'sa'), true);
                                }
                            @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden slider-img-edit"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME') }} promo"
                                            @if (count($featured_categories) == 0) height="457"
                                            @else
                                            @endif
                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder-rect.jpg') }}';">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    {{-- @if (count($featured_categories) > 0)
                        <ul class="list-unstyled mb-0 row gutters-5 category-boxs">
                            @foreach ($featured_categories as $key => $category)
                                <li class="minw-0 col-4 col-md mt-3">
                                    <a href="{{ route('products.category', $category->slug) }}"
                                        class="d-block rounded bg-white pb-2 text-reset shadow-sm">
                                        <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($category->banner) }}"
                                            alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit"
                                            height="88"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder-rect.jpg') }}';">
                                        <div class="text-truncate fs-12 fw-600 text-center mt-2 opacity-70">
                                            {{ $category->getTranslation('name') }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif --}}
                </div>
{{--
                @if ($num_todays_deal > 0)
                    <div class="col-lg-2 order-3 mt-3 mt-lg-0 todays-deal-sec">
                        <div class="bg-white rounded shadow-sm deal-of-day">
                            <div class="bg-soft-primary rounded-top p-3 d-flex align-items-center justify-content-center">
                                <span class="fw-600 fs-16 mr-2 text-truncate">
                                    {{ translate('Todays Deal') }}
                                </span>
                                <span class="badge badge-primary badge-inline">{{ translate('Hot') }}</span>
                            </div>
                            <div class="c-scrollbar-light overflow-auto h-lg-400px p-2 rounded-bottom">
                                <div class="gutters-5 lg-no-gutters row row-cols-2 row-cols-lg-1">
                                    @foreach ($todays_deal_products as $key => $product)
                                        @if ($product != null)
                                            <div class="col mb-2">
                                                <a href="{{ route('product', $product->slug) }}"
                                                    class="d-block p-2 text-reset bg-white h-100 rounded">
                                                    <div class="row gutters-5 align-items-center">
                                                        <div class="col-xxl">
                                                            <div class="img">
                                                                <img class="lazyload img-fit h-140px h-lg-80px"
                                                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                    alt="{{ $product->getTranslation('name') }}"
                                                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl">
                                                            <div class="fs-16">
                                                                <span
                                                                    class="d-block text-primary fw-600 price">{{ home_discounted_base_price($product) }}</span>
                                                                @if (home_base_price($product) != home_discounted_base_price($product))
                                                                    <del
                                                                        class="d-block opacity-70">{{ home_base_price($product) }}</del>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}

            </div>
        </div>
    </div>

    {{-- Top 10 categories and Brands --}}
    @if (get_setting('top10_categories') != null && get_setting('top10_brands') != null)
        <section class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    {{-- @if (get_setting('top10_categories') != null)
                        <div class="col-lg-6 top10_categories">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="h5 fw-700 mb-0">
                                    <span
                                        class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Categories') }}</span>
                                </h3>
                                <a href="{{ route('categories.all') }}"
                                    class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Categories') }}</a>
                            </div>
                            <div class="row gutters-5">
                                @php $top10_categories = json_decode(get_setting('top10_categories')); @endphp
                                @foreach ($top10_categories as $key => $value)
                                    @php $category = \App\Models\Category::find($value); @endphp
                                    @if ($category != null)
                                        <div class="col-sm-6">
                                            <a href="{{ route('products.category', $category->slug) }}"
                                                class="category-box bg-white border d-block text-reset rounded p-2 hov-shadow-md mb-2">
                                                <div class="row align-items-center no-gutters">
                                                    <div class="col-3 text-center">
                                                        <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                            data-src="{{ uploaded_asset($category->banner) }}"
                                                            alt="{{ $category->getTranslation('name') }}"
                                                            class="img-fluid img lazyload h-60px"
                                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="text-truncat-2 fs-14 fw-600 text-left">
                                                            {{ $category->getTranslation('name') }}</div>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <i class="la la-angle-right text-primary"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                    @if (get_setting('top10_brands') != null)
                        <div class="col-lg-12 top10_brands">
                            <div class="d-flex mb-3 align-items-baseline border-bottom">
                                <h3 class="h5 fw-700 mb-0">
                                    <span
                                        class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Top 10 Brands') }}</span>
                                </h3>
                                <a href="{{ route('brands.all') }}"
                                    class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Brands') }}</a>
                            </div>
                        </div>





                        <div class="swiper w-100 top-brands-slider">
                            <div class="swiper-wrapper">
                                @php $top10_brands = json_decode(get_setting('top10_brands')); @endphp
                                @foreach ($top10_brands as $key => $value)
                                    @php $brand = \App\Models\Brand::find($value); @endphp
                                    @if ($brand != null)
                                        {{-- <div class="col-sm-2 text-center">
                                        <a href="{{ route('products.brand', $brand->slug) }}"
                                            class="brands-box bg-white border d-block text-reset rounded  hov-shadow-md mb-2 text-center">
                                            <div class="row align-items-center no-gutters">
                                                <div class="col-4 align-items-center">
                                                    <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($brand->logo) }}"
                                                        alt="{{ $brand->getTranslation('name') }}"
                                                        class="img-fluid img lazyload h-60px mr-2"
                                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-truncate-2 fs-14 fw-600 text-center">
                                                        {{ $brand->getTranslation('name') }}</div>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <i class="la la-angle-right text-primary"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div> --}}

                                        <div class="swiper-slide">
                                            <div class="text-center">
                                                <a href="{{ route('products.brand', $brand->slug) }}"
                                                    class="brands-box bg-white border d-block text-reset rounded  hov-shadow-md mb-2 text-center">
                                                    <div class="row align-items-center no-gutters">
                                                        <div class="col-4 align-items-center">
                                                            <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($brand->logo) }}"
                                                                alt="{{ $brand->getTranslation('name') }}"
                                                                class="img-fluid img lazyload h-60px mr-2"
                                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-truncate-2 fs-14 fw-600 text-center">
                                                                {{ $brand->getTranslation('name') }}</div>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            <i class="la la-angle-right text-primary"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- <div class="mb-4">
        <div class="container">
            @if (count($featured_categories) > 0)
                <ul class="list-unstyled mb-0 row gutters-5">
                    @foreach ($featured_categories as $key => $category)
                        <li class="minw-0 col-4 col-md mt-3">
                            <a href="{{ route('products.category', $category->slug) }}"
                                class="d-block rounded bg-white text-reset pb-2 shadow-sm overflow-hidden">
                                <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($category->banner) }}"
                                    alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit" height="99"
                                    ف
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder-rect.jpg') }}';">
                                <div class="text-truncate fs-14 fw-600 mt-2 opacity-70 text-center">
                                    {{ $category->getTranslation('name') }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div> --}}




    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\Models\FlashDeal::where('status', 1)
            ->where('featured', 1)
            ->first();
    @endphp
    @if ($flash_deal != null &&
        strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date &&
        strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                    <div class="d-flex flex-wrap mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span
                                class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                        </h3>
                        <div class="aiz-count-down ml-auto ml-lg-3 align-items-center"
                            data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                        <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                            class="ml-auto mt-md-0 mt-3 mr-0 btn btn-primary btn-sm shadow-md w-100 w-md-auto">{{ translate('View More') }}</a>
                    </div>

                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                        data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                        @foreach ($flash_deal->flash_deal_products->take(20) as $key => $flash_deal_product)
                            @php
                                $product = \App\Models\Product::find($flash_deal_product->product_id);
                            @endphp
                            @if ($product != null && $product->published != 0)
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1', ['product' => $product])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif



    {{-- Banner section 1 --}}
    @php
        $bannerImages = get_setting('home_banner1_images', null, app()->getLocale());
        if ($bannerImages == null) {
            $bannerImages = get_setting('home_banner1_images', null, 'sa');
        }
    @endphp
    @if ($bannerImages != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_1_imags = json_decode($bannerImages ,true); @endphp
                    @foreach ($banner_1_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0 home_banner_images_box">
                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                    class="d-block text-reset">
                                    <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div id="section_newest">
        @if (count($newest_products) > 0)
            <section class="mb-4">
                <div class="container">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">
                                    {{ app()->getLocale() == 'en' ? 'New Products' : 'وصل حديثاً' }}
                                </span>
                            </h3>
                        </div>
                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                            data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                            @foreach ($newest_products as $key => $new_product)
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1', [
                                        'product' => $new_product,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    {{-- Featured Section --}}
    <div id="section_featured">

    </div>

    {{-- Best Selling --}}
    <div id="section_best_selling">
    </div>

    <!-- Auction Product -->
    @if (addon_is_activated('auction'))
        <div id="auction_products">

        </div>
    @endif



    {{-- Banner Section 2 --}}
    @php
        $banner_2_images = get_setting('home_banner2_images', null, app()->getLocale());
        if ($banner_2_images == null) {
            $banner_2_images = get_setting('home_banner2_images', null, 'sa');
        }
    @endphp
    @if ($banner_2_images != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_2_imags = json_decode($banner_2_images , true); @endphp
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0 home_banner_images_box">
                                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] ?? '#' }}"
                                    class="d-block text-reset">
                                    <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_2_imags[$key] ?? '#') }}"
                                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>

    {{-- Classified Product --}}
    @if (get_setting('classified_product') == 1)
        @php
            $classified_products = \App\Models\CustomerProduct::where('status', '1')
                ->where('published', '1')
                ->take(10)
                ->get();
        @endphp
        @if (count($classified_products) > 0)
            <section class="mb-4">
                <div class="container">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span
                                    class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
                            </h3>
                            <a href="{{ route('customer.products') }}"
                                class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                        </div>
                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                            data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                            @foreach ($classified_products as $key => $classified_product)
                                <div class="carousel-box">
                                    <div
                                        class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                        <div class="position-relative">
                                            <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                class="d-block">
                                                <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"
                                                    alt="{{ $classified_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                            <div class="absolute-top-left pt-2 pl-2">
                                                @if ($classified_product->conditon == 'new')
                                                    <span
                                                        class="badge badge-inline badge-success">{{ translate('new') }}</span>
                                                @elseif($classified_product->conditon == 'used')
                                                    <span
                                                        class="badge badge-inline badge-danger">{{ translate('Used') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-md-3 p-2 text-left">
                                            <div class="fs-15 mb-1">
                                                <span
                                                    class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                            </div>
                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                    class="d-block text-reset">{{ $classified_product->getTranslation('name') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- Banner Section 2 --}}
    @php
        $banner_3_images = get_setting('home_banner3_images', null, app()->getLocale());
        if ($banner_3_images == null) {
            $banner_3_images = get_setting('home_banner3_images', null, 'sa') != null;
        }
    @endphp
    @if ($banner_3_images != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_3_imgs = json_decode($banner_3_images , true); @endphp
                    @foreach ($banner_3_imgs as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0 home_banner_images_box">
                                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] ?? '#' }}"
                                    class="d-block text-reset">
                                    <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_3_imgs[$key]) }}"
                                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Best Seller --}}
    <div>
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span
                                class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Other Products') }}</span>
                        </h3>
                    </div>
                    <div class="row gutters-5 row-cols-xl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2"
                        id="section_random_products">
                    </div>
                    <div class="aiz-pagination aiz-pagination-center mt-4 text-center">
                        <button id="load_more" class="btn btn-primary">{{ translate('Show More') }}</button>
                    </div>
                </div>
            </div>
        </section>
    </div>


    {{-- Best Seller --}}
    @if (get_setting('vendor_system_activation') == 1)
        <div id="section_best_sellers">
        </div>
    @endif



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.post('{{ route('home.section.featured') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.auction_products') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#auction_products').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.random_products') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_random_products').append(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_sellers') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            $('#load_more').on('click', function() {
                $.post('{{ route('home.section.load_random_products') }}', {
                    _token: '{{ csrf_token() }}',
                }, function(data) {
                    $('#section_random_products').append(data);
                    AIZ.plugins.slickCarousel();
                });
            });
        });


        const swiper = new Swiper('.top-brands-slider', {
            slidesPerView: 6,
            spaceBetween: 10,
            // loop: true,
            // autoplay: {
            //     delay: 5000,
            // },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                // when window width is >= 992px
                992: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                // when window width is >= 1200px
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 10
                },
                1300: {
                    slidesPerView: 6,
                    spaceBetween: 10
                },
            }
        });
    </script>
@endsection
