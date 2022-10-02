@if (get_setting('topbar_banner') != null)
    <div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">
        <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">
            <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="w-100 mw-100 h-40px  img-fit">
        </a>
        <button class="btn text-white absolute-top-right set-session" data-key="top-banner" data-value="removed"
            data-toggle="remove-parent" data-parent=".top-banner">
            <i class="la la-close la-x"></i>
        </button>
    </div>
@endif
<!-- Top Bar -->
<div class="top-navbar bg-white border-bottom border-soft-secondary z-1035">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if (get_setting('show_language_switcher') == 'on')
                        <li class="list-inline-item dropdown mr-3" id="lang-change">
                            @php
                                if (Session::has('locale')) {
                                    $locale = Session::get('locale', Config::get('app.locale'));
                                } else {
                                    $locale = 'en';
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown"
                                data-display="static">
                                <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ asset('assets/img/flags/' . $locale . '.png') }}" class="mr-2 lazyload"
                                    alt="{{ \App\Models\Language::where('code', $locale)->first()->name }}"
                                    height="11">
                                <span
                                    class="opacity-60">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left">
                                @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                                    <li>
                                        <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                            class="dropdown-item @if ($locale == $language) active @endif">
                                            <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ asset('assets/img/flags/' . $language->code . '.png') }}"
                                                class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                            <span class="language">{{ $language->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if (get_setting('show_currency_switcher') == 'on')
                        <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">
                            @php
                                if (Session::has('currency_code')) {
                                    $currency_code = Session::get('currency_code');
                                } else {
                                    $currency_code = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
                                }
                            @endphp
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60"
                                data-toggle="dropdown" data-display="static">
                                {{ \App\Models\Currency::where('code', $currency_code)->first()->name }}
                                {{ \App\Models\Currency::where('code', $currency_code)->first()->symbol }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                    <li>
                                        <a class="dropdown-item @if ($currency_code == $currency->code) active @endif"
                                            href="javascript:void(0)"
                                            data-currency="{{ $currency->code }}">{{ $currency->name }}
                                            ({{ $currency->symbol }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-5 text-right d-none d-lg-block">
                <ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">
                    @if (get_setting('helpline_number'))
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="tel:{{ get_setting('helpline_number') }}"
                                class="text-reset d-inline-block opacity-60 py-2">
                                <i class="la la-phone"></i>
                                <span>{{ get_setting('helpline_number') }}</span>
                            </a>
                        </li>
                    @endif
                    @auth
                        @if (isAdmin())
                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-reset d-inline-block opacity-60 py-2">{{ translate('My Panel') }}</a>
                            </li>
                        @else
                            <li
                                class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0 dropdown notification-dropdown">
                                <a class="dropdown-toggle no-arrow text-reset" data-toggle="dropdown"
                                    href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="">
                                        <span class="position-relative d-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20"
                                                height="20">
                                                <path
                                                    d="M12 2C11.172 2 10.5 2.672 10.5 3.5L10.5 4.1953125C7.9131836 4.862095 6 7.2048001 6 10L6 15L18 15L18 10C18 7.2048001 16.086816 4.862095 13.5 4.1953125L13.5 3.5C13.5 2.672 12.828 2 12 2 z M 4 17L4 19L10.269531 19 A 2 2 0 0 0 10 20 A 2 2 0 0 0 12 22 A 2 2 0 0 0 14 20 A 2 2 0 0 0 13.728516 19L20 19L20 17L4 17 z"
                                                    fill="#5B5B5B" />
                                            </svg>
                                            @if (count(Auth::user()->unreadNotifications) > 0)
                                                <span
                                                    class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                            @endif
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                    <div class="p-3  border-bottom">
                                        <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                    </div>
                                    <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                        <ul class="list-group list-group-flush">
                                            @forelse(Auth::user()->unreadNotifications as $notification)
                                                <li class="list-group-item">
                                                    @if ($notification->type == 'App\Notifications\OrderNotification')
                                                        @if (Auth::user()->user_type == 'customer')
                                                            <a href="javascript:void(0)"
                                                                onclick="show_purchase_history_details({{ $notification->data['order_id'] }})"
                                                                class="text-reset">
                                                                <span class="ml-2">
                                                                    {{ translate('Order code: ') }}
                                                                    {{ $notification->data['order_code'] }}
                                                                    {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                </span>
                                                            </a>
                                                        @elseif (Auth::user()->user_type == 'seller')
                                                            @if (Auth::user()->id == $notification->data['user_id'])
                                                                <a href="javascript:void(0)"
                                                                    onclick="show_purchase_history_details({{ $notification->data['order_id'] }})"
                                                                    class="text-reset">
                                                                    <span class="ml-2">
                                                                        {{ translate('Order code: ') }}
                                                                        {{ $notification->data['order_code'] }}
                                                                        {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)"
                                                                    onclick="show_order_details({{ $notification->data['order_id'] }})"
                                                                    class="text-reset">
                                                                    <span class="ml-2">
                                                                        {{ translate('Order code: ') }}
                                                                        {{ $notification->data['order_code'] }}
                                                                        {{ translate('has been ' . ucfirst(str_replace('_', ' ', $notification->data['status']))) }}
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="py-4 text-center fs-16">
                                                        {{ translate('No notification found') }}
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="text-center border-top">
                                        <a href="{{ route('all-notifications') }}" class="text-reset d-block py-2">
                                            {{ translate('View All Notifications') }}
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                @if (Auth::user()->user_type == 'seller')
                                    <a href="{{ route('seller.dashboard') }}"
                                        class="text-reset d-inline-block opacity-60 py-2">{{ translate('My Panel') }}</a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                        class="text-reset d-inline-block opacity-60 py-2">{{ translate('My Panel') }}</a>
                                @endif
                            </li>
                        @endif
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}"
                                class="text-reset d-inline-block opacity-60 py-2">{{ translate('Logout') }}</a>
                        </li>
                    @else
                        {{-- <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('user.login') }}"
                                class="text-reset d-inline-block opacity-60 py-2">{{ translate('Login') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}"
                                class="text-reset d-inline-block opacity-60 py-2">{{ translate('Registration') }}</a>
                        </li> --}}
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Top Bar -->
<header class="@if (get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
    <div class="position-relative logo-bar-area z-1">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">

                <div class="col-auto col-xl-3 pl-0 pr-3 justify-content-center d-flex  align-items-center">
                    <a class="d-block py-10px  logo-box" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if ($header_logo != null)
                            <img src="{{ uploaded_asset(get_setting('system_logo_black')) }}"
                                alt="{{ env('APP_NAME') }}" class="mw-100" id="header-logo">
                        @endif

                    </a>

                    {{-- <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">
                        <div class="h-100 d-flex align-items-center" id="category-menu-icon">
                            <div
                                class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">
                                <span class="navbar-toggler-icon"></span>
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{-- mobile --}}

                <div class="d-flex nav-mobile-lang">
                    <div class="d-lg-none ml-auto mr-0">
                        <a class="p-2 d-block text-reset search-mobile" href="javascript:void(0);"
                            data-toggle="class-toggle" data-target=".front-header-search">
                            <i class="las la-search la-flip-horizontal la-2x"></i>
                        </a>
                    </div>
                    <ul class="p-0 lang-dropdown">
                        @if (get_setting('show_language_switcher') == 'on')
                            <li class="list-inline-item dropdown" id="lang-change">
                                @php
                                    if (Session::has('locale')) {
                                        $locale = Session::get('locale', Config::get('app.locale'));
                                    } else {
                                        $locale = 'en';
                                    }
                                @endphp
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2"
                                    data-toggle="dropdown" data-display="static">
                                    <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ asset('assets/img/flags/' . $locale . '.png') }}"
                                        class="mr-2 lazyload"
                                        alt="{{ \App\Models\Language::where('code', $locale)->first()->name }}"
                                        height="11" style="width:auto">
                                    <span
                                        class="opacity-60">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                                        <li>
                                            <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                                class="dropdown-item @if ($locale == $language) active @endif">
                                                <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ asset('assets/img/flags/' . $language->code . '.png') }}"
                                                    class="mr-1 lazyload" alt="{{ $language->name }}" height="11"
                                                    style="width:auto">
                                                <span class="language">{{ $language->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        @if (get_setting('show_currency_switcher') == 'on')
                            <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">
                                @php
                                    if (Session::has('currency_code')) {
                                        $currency_code = Session::get('currency_code');
                                    } else {
                                        $currency_code = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
                                    }
                                @endphp
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60"
                                    data-toggle="dropdown" data-display="static">
                                    {{ \App\Models\Currency::where('code', $currency_code)->first()->name }}
                                    {{ \App\Models\Currency::where('code', $currency_code)->first()->symbol }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                    @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                        <li>
                                            <a class="dropdown-item @if ($currency_code == $currency->code) active @endif"
                                                href="javascript:void(0)"
                                                data-currency="{{ $currency->code }}">{{ $currency->name }}
                                                ({{ $currency->symbol }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                    <div class="position-relative flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i
                                            class="la la-2x la-long-arrow-left"></i></button>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="border-0 border-lg form-control" id="search"
                                        name="keyword"
                                        @isset($query) value="{{ $query }}" @endisset
                                        placeholder="{{ translate('I am shopping for...') }}" autocomplete="off">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="la la-search la-flip-horizontal fs-18"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                            style="min-height: 200px">
                            <div class="search-preloader absolute-top-center">
                                <div class="dot-loader">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="search-nothing d-none p-3 text-center fs-16">

                            </div>
                            <div id="search-content" class="text-left">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>

                <div class="d-none d-lg-block  align-self-center ml-4 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>
                {{--
                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="compare">
                        @include('frontend.partials.compare')
                    </div>
                </div>

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div> --}}

                {{-- <div class="dropdown user-menu-dropdown d-none d-lg-block">
                    <a class="dropdown-toggle no-arrow text-reset" type="button" data-toggle="dropdown"
                        href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                            <path
                                d="M12 3C9.8027056 3 8 4.8027056 8 7C8 9.1972944 9.8027056 11 12 11C14.197294 11 16 9.1972944 16 7C16 4.8027056 14.197294 3 12 3 z M 12 5C13.116414 5 14 5.8835859 14 7C14 8.1164141 13.116414 9 12 9C10.883586 9 10 8.1164141 10 7C10 5.8835859 10.883586 5 12 5 z M 12 14C10.255047 14 8.1871638 14.409783 6.4492188 15.095703C5.5802462 15.438663 4.7946961 15.84605 4.1660156 16.369141C3.5373351 16.892231 3 17.599384 3 18.5L3 21L21 21L21 20L21 18.5C21 17.599384 20.462665 16.892231 19.833984 16.369141C19.205304 15.84605 18.419754 15.438663 17.550781 15.095703C15.812836 14.409783 13.744953 14 12 14 z M 12 16C13.414047 16 15.346055 16.373999 16.818359 16.955078C17.554512 17.245618 18.176961 17.591965 18.554688 17.90625C18.932412 18.220535 19 18.434616 19 18.5L19 19L5 19L5 18.5C5 18.434616 5.0675867 18.220535 5.4453125 17.90625C5.8230383 17.591965 6.4454882 17.245618 7.1816406 16.955078C8.6539455 16.373999 10.585953 16 12 16 z"
                                fill="#5B5B5B" />
                        </svg>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if (!Auth::check())
                            <a class="dropdown-item"
                                href="{{ route('user.registration') }}">{{ translate('Register') }}</a>
                            <a class="dropdown-item" href="{{ route('user.login') }}">{{ translate('login') }}</a>
                        @else
                            <a class="dropdown-item"
                                href="{{ route('dashboard') }}">{{ translate('Dashboard') }}</a>
                            <a class="dropdown-item"
                                href="{{ route('wishlists.index') }}">{{ translate('Wishlist') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">{{ translate('Logout') }} </a>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="dropdown notification-dropdown d-none d-lg-block">
                    <a class="dropdown-toggle no-arrow text-reset" data-toggle="dropdown" href="javascript:void(0);"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="">
                            <span class="position-relative d-inline-block">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26"
                                    height="26">
                                    <path
                                        d="M12 2C11.172 2 10.5 2.672 10.5 3.5L10.5 4.1953125C7.9131836 4.862095 6 7.2048001 6 10L6 16L4 18L4 19L10.269531 19 A 2 2 0 0 0 10 20 A 2 2 0 0 0 12 22 A 2 2 0 0 0 14 20 A 2 2 0 0 0 13.728516 19L20 19L20 18L18 16L18 10C18 7.2048001 16.086816 4.862095 13.5 4.1953125L13.5 3.5C13.5 2.672 12.828 2 12 2 z M 12 6C14.206 6 16 7.794 16 10L16 16L16 16.828125L16.171875 17L7.828125 17L8 16.828125L8 16L8 10C8 7.794 9.794 6 12 6 z"
                                        fill="#5B5B5B" />
                                </svg>
                                <span
                                    class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">

                    </div>
                </div> --}}

                {{-- <div class="d-none d-lg-block">
                    <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0 lang-dropdown">
                        @if (get_setting('show_language_switcher') == 'on')
                            <li class="list-inline-item dropdown" id="lang-change">
                                @php
                                    if (Session::has('locale')) {
                                        $locale = Session::get('locale', Config::get('app.locale'));
                                    } else {
                                        $locale = 'en';
                                    }
                                @endphp
                                <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2"
                                    data-toggle="dropdown" data-display="static">
                                    <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ asset('assets/img/flags/' . $locale . '.png') }}"
                                        class="mr-2 lazyload"
                                        alt="{{ \App\Models\Language::where('code', $locale)->first()->name }}"
                                        height="11">
                                    <span
                                        class="opacity-60">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                                        <li>
                                            <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                                                class="dropdown-item @if ($locale == $language) active @endif">
                                                <img src="{{ asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ asset('assets/img/flags/' . $language->code . '.png') }}"
                                                    class="mr-1 lazyload" alt="{{ $language->name }}"
                                                    height="11">
                                                <span class="language">{{ $language->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div> --}}


                {{-- @if (get_setting('show_language_switcher') == 'on')
                <div class="header-lang" id="lang-change">

                    @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                    <a href="javascript:void(0)" data-flag="{{ $language->code }}"
                        class="@if ($locale == $language) active @endif">
                        <span class="language">{{ $language->name }}</span>
                    </a>
                    @endforeach
                </div>
                @endif --}}

            </div>
        </div>
        @if (Route::currentRouteName() != 'home')
            <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3"
                id="hover-category-menu">
                <div class="container">
                    <div class="row gutters-10 position-relative">
                        <div class="col-lg-3 position-static">
                            @include('frontend.partials.category_menu')
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{-- Edited: Defining the locale to get the translated lables --}}
    @if (get_setting('header_menu_labels', null, $locale) != null)
        <div class="bg-white border-top border-gray-200 py-1 header-menu">
            <div class="container">
                {{-- <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-center">
                    @foreach (json_decode(get_setting('header_menu_labels', null, $locale), true) as $key => $value)
                        <li class="list-inline-item mr-0">
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] ?? '' }}"
                                class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                                {{ $value }}
                            </a>
                        </li>
                    @endforeach
                </ul> --}}



                <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-center header-menu-list">
                    {{-- <li class="list-inline-item mr-0">
                        <a href="/" class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                            <span>
                                {{ app()->getLocale() == 'en' ? 'Home' : 'الرئيسية' }}
                            </span>
                        </a>
                    </li> --}}
                    {{-- @foreach (\App\Models\Category::where('level', 0)->orderBy('order_level', 'desc')->get()->take(11) as $key => $category)
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('products.category', $category->slug) }}"
                                class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                                <span>{{ $category->getTranslation('name') }}</span>
                            </a>
                            @if (count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id)) > 0)
                                <ul class="list-child">
                                    @forelse(\App\Utility\CategoryUtility::get_immediate_children($category->id) as $child)
                                        <li>
                                            <a href="{{ route('products.category', $child->slug) }}">
                                                {{ $child->getTranslation('name') }}
                                            </a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            @endif
                        </li>
                    @endforeach --}}
                    @foreach (json_decode(get_setting('header_menu_labels', null, $locale), true) as $key => $value)
                        <li class="list-inline-item mr-0">
                            <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] ?? '' }}"
                                class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                                <span>{{ $value }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>


                {{-- <li class="list-inline-item mr-0">
                        <a href="" class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                            <span>تنس طاولة</span>
                        </a>
                        <ul class="list-child">
                            <li>
                                <a href="">
                                    تنس طاولة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    جلد
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    مضارب جاهزة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    إكسسوارات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    كرات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    ملابس
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="list-inline-item mr-0">
                        <a href="" class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                            <span>تنس الريشة</span>
                        </a>
                        <ul class="list-child">
                            <li>
                                <a href="">
                                    ريش
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    مضارب
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    خيوط
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    إكسسوارات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    ملابس
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    احذية
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="list-inline-item mr-0">
                        <a href="" class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                            <span>تنس طاولة</span>
                        </a>
                        <ul class="list-child">
                            <li>
                                <a href="">
                                    تنس طاولة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    جلد
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    مضارب جاهزة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    إكسسوارات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    كرات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    ملابس
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="list-inline-item mr-0">
                        <a href="" class="fs-15 px-3 py-2 d-inline-block fw-600 text-reset">
                            <span>تنس طاولة</span>
                        </a>
                        <ul class="list-child">
                            <li>
                                <a href="">
                                    تنس طاولة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    جلد
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    مضارب جاهزة
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    إكسسوارات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    كرات
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    ملابس
                                </a>
                            </li>
                        </ul>
                    </li> --}}




            </div>
        </div>
    @endif
</header>

<div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div id="order-details-modal-body">

            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        function show_order_details(order_id) {
            $('#order-details-modal-body').html(null);

            if (!$('#modal-size').hasClass('modal-lg')) {
                $('#modal-size').addClass('modal-lg');
            }

            $.post('{{ route('orders.details') }}', {
                _token: AIZ.data.csrf,
                order_id: order_id
            }, function(data) {
                $('#order-details-modal-body').html(data);
                $('#order_details').modal();
                $('.c-preloader').hide();
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }
    </script>
@endsection
