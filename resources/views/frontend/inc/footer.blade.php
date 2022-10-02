{{-- <div class="container">
    <section class="bg-white border-top mt-auto footer-cards-links">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('terms') }}">
                    <i class="la la-file-text la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Terms & conditions') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('returnpolicy') }}">
                    <i class="la la-mail-reply la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Return Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('supportpolicy') }}">
                    <i class="la la-support la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Support Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left border-right text-center p-4 d-block"
                    href="{{ route('privacypolicy') }}">
                    <i class="las la-exclamation-circle la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Privacy Policy') }}</h4>
                </a>
            </div>
        </div>
    </section>
</div> --}}



@php
$colSize = null;
if (get_setting('vendor_system_activation') == 0) {
    $colSize = 5;
}
@endphp

<section class="bg-dark text-light footer-widget fotter-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-xl-4 text-center text-md-left">
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="d-block logo-footer">
                        @if (get_setting('footer_logo') != null)
                            <img class="lazyload" src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset(get_setting('footer_logo')) }}"
                                alt="{{ env('APP_NAME') }}" height="80" style="min-width:200px !important;">
                        @else
                            <img class="lazyload" src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                height="44">
                        @endif
                    </a>
                    <div class="footer-main-text">
                        {!! get_setting('about_us_description', null, App::getLocale()) !!}
                    </div>
                    {{-- <div class="d-inline-block d-md-block mb-4">
                        <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                            @csrf
                            <div class="form-group mb-0">
                                <input type="email" class="form-control"
                                    placeholder="{{ translate('Your Email Address') }}" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ translate('Subscribe') }}
                            </button>
                        </form>
                    </div> --}}
                    <div class="w-300px mw-100 mx-auto mx-md-0">
                        @if (get_setting('play_store_link') != null)
                            <a href="{{ get_setting('play_store_link') }}" target="_blank"
                                class="d-inline-block mr-3 ml-0">
                                <img src="{{ asset('assets/img/play.png') }}" class="mx-100 h-40px">
                            </a>
                        @endif
                        @if (get_setting('app_store_link') != null)
                            <a href="{{ get_setting('app_store_link') }}" target="_blank" class="d-inline-block">
                                <img src="{{ asset('assets/img/app.png') }}" class="mx-100 h-40px">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-{{ $colSize - 1 ?? 3 }} ml-xl-auto col-md-4 mr-0">
                <div class="text-center text-md-left mt-4">
                    <h4 class="fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-3 mb-3">
                        {{ translate('Contact Info') }}
                    </h4>
                    <ul class="list-unstyled">
                        {{-- <li class="mb-2">
                            <span class="d-block">{{ translate('Address') }}:</span>
                            <span class="d-block">{{ get_setting('contact_address', null, App::getLocale()) }}</span>
                        </li> --}}
                        @if (get_setting('contact_phone') != null)
                            <li class="mb-2">
                                <span class="d-block">{{ translate('Whatsapp') }}:</span>
                                <span class="d-block"><bdo
                                        dir="ltr">{{ get_setting('contact_phone') }}</bdo></span>
                            </li>
                        @endif
                        @if (get_setting('contact_email') != null)
                            <li class="mb-2">
                                <span class="d-block">{{ translate('Email') }}:</span>
                                <span class="d-block">
                                    <a href="mailto:{{ get_setting('contact_email') }}"
                                        class="text-reset">{{ get_setting('contact_email') }}</a>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-{{ $colSize - 2 ?? 2 }} col-md-4">
                <div class="text-center text-md-left mt-4">
                    <h4 class="fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-3 mb-3">
                        {{ get_setting('widget_one', null, App::getLocale()) }}
                    </h4>
                    <ul class="list-unstyled">
                        @if (get_setting('widget_one_labels', null, App::getLocale()) != null)
                            @foreach (json_decode(get_setting('widget_one_labels', null, App::getLocale()), true) as $key => $value)
                                <li class="mb-2">
                                    <a href="{{ json_decode(get_setting('widget_one_links'), true)[$key] ?? '' }}"
                                        class="text-reset">
                                        {{ $value }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            @if (get_setting('vendor_system_activation') == 1)
                <div class="col-md-4 col-lg-2 account-footer-col">
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                            {{ translate('My Account') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (!Auth::check())
                                <li class="mb-2">
                                    <a class="text-reset" href="{{ route('login') }}">
                                        {{ translate('Seller Login') }}
                                    </a>
                                </li>

                                <li class="mb-2">
                                    <a class="text-reset" href="{{ route('shops.create') }}">
                                        {{ translate('Seller Register') }}
                                    </a>
                                </li>
                            @else
                                <li class="mb-2">
                                    <a class="text-reset" href="{{ route('logout') }}">
                                        {{ translate('Logout') }}
                                    </a>
                                </li>
                            @endif
                            @if (addon_is_activated('affiliate_system'))
                                <li class="mb-2">
                                    <a class="text-light"
                                        href="{{ route('affiliate.apply') }}">{{ translate('Be an affiliate partner') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- @if (get_setting('vendor_system_activation') == 1)
                    <div class="text-center text-md-left mt-4">
                        <h4 class="fs-13 text-uppercase fw-600 border-bottom border-gray-900 pb-3 mb-3">
                            {{ translate('Be a Seller') }}
                        </h4>
                        <a href="{{ route('shops.create') }}" class="btn btn-primary btn-sm shadow-md">
                            {{ translate('Apply Now') }}
                        </a>
                    </div>
                @endif --}}
                </div>
            @endif
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="">
                    @if (get_setting('show_social_links'))
                        <ul class="list-inline my-3 my-md-0 social colored">
                            @if (get_setting('facebook_link') != null)
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i
                                            class="lab la-facebook-f"></i></a>
                                </li>
                            @endif
                            @if (get_setting('twitter_link') != null)
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i
                                            class="lab la-twitter"></i></a>
                                </li>
                            @endif
                            @if (get_setting('instagram_link') != null)
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('instagram_link') }}" target="_blank"
                                        class="instagram"><i class="lab la-instagram"></i></a>
                                </li>
                            @endif
                            @if (get_setting('youtube_link') != null)
                                <li class="list-inline-item">
                                    <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i
                                            class="lab la-youtube"></i></a>
                                </li>
                            @endif
                            @if (get_setting('linkedin_link') != null)
                                <li class="list-inline-item mx-2">
                                    <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i
                                            class="lab la-linkedin-in"></i></a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 bg-black text-light copyright-footer">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <div class=" copyright-p-text" current-verison="{{ get_setting('current_version') }}">
                    {!! get_setting('frontend_copyright_text', null, App::getLocale()) !!}
                </div>
            </div>

            <div class="col-lg-6">
                <div class=" text-md-right">
                    <ul class="list-inline mb-0">
                        @if (get_setting('payment_method_images') != null)
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item">
                                    <img src="{{ uploaded_asset($value) }}" height="30" class="mw-100 h-auto"
                                        style="max-height: 30px">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top rounded-top"
    style="box-shadow: 0px -1px 10px rgb(0 0 0 / 15%)!important; ">
    <div class="row align-items-center gutters-5">
        <div class="col"></div>
        <div class="col">
            <a href="{{ route('home') }}" class="text-reset d-block text-center pb-2 pt-3">
                <i
                    class="las la-home fs-20 opacity-60 {{ areActiveRoutes(['home'], 'opacity-100 text-primary') }}"></i>
                <span
                    class="d-block fs-10 fw-600 opacity-60 {{ areActiveRoutes(['home'], 'opacity-100 fw-600') }}">{{ translate('Home') }}</span>
            </a>
        </div>
        @php
            if (auth()->user() != null) {
                $user_id = Auth::user()->id;
                $cart = \App\Models\Cart::where('user_id', $user_id)->get();
            } else {
                $temp_user_id = Session()->get('temp_user_id');
                if ($temp_user_id) {
                    $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
                }
            }
        @endphp
        <div class="col-auto">
            <a href="{{ route('cart') }}" class="text-reset d-block text-center pb-2 pt-3">
                <span
                    class="align-items-center bg-primary border border-white border-width-4 d-flex justify-content-center position-relative rounded-circle size-50px"
                    style="margin-top: -33px;box-shadow: 0px -5px 10px rgb(0 0 0 / 15%);border-color: #fff !important;">
                    <i class="las la-shopping-bag la-2x text-white"></i>
                </span>
                <span
                    class="d-block mt-1 fs-10 fw-600 opacity-60 {{ areActiveRoutes(['cart'], 'opacity-100 fw-600') }}">
                    {{ translate('Cart') }}
                    @php
                        $count = isset($cart) && count($cart) ? count($cart) : 0;
                    @endphp
                    (<span class="cart-count">{{ $count }}</span>)
                </span>
            </a>
        </div>
        <div class="col">
            <a href="{{ route('categories.all') }}" class="text-reset d-block text-center pb-2 pt-3">
                <i
                    class="las la-list-ul fs-20 opacity-60 {{ areActiveRoutes(['categories.all'], 'opacity-100 text-primary') }}"></i>
                <span
                    class="d-block fs-10 fw-600 opacity-60 {{ areActiveRoutes(['categories.all'], 'opacity-100 fw-600') }}">{{ translate('Categories') }}</span>
            </a>
        </div>
        <div class="col">
            @if (Auth::check())
                @if (isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-reset d-block text-center pb-2 pt-3">
                        <span class="d-block mx-auto">
                            @if (Auth::user()->photo != null)
                                <img src="{{ custom_asset(Auth::user()->avatar_original) }}"
                                    class="rounded-circle size-20px">
                            @else
                                <img src="{{ asset('assets/img/avatar-place.png') }}"
                                    class="rounded-circle size-20px">
                            @endif
                        </span>
                        <span class="d-block fs-10 fw-600 opacity-60">{{ translate('Account') }}</span>
                    </a>
                @endif
            @endif
        </div>
    </div>
</div>
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-backdrop="static"
            data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
