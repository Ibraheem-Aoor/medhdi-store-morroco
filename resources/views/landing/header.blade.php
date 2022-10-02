<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Store</title>
    <link rel="shortcut icon" href="{{ asset('assets/landing-assets/img/fav.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/landing-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing-assets/css/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing-assets/css/intlTelInput.min.css') }}">

    @if (app()->getLocale() == 'sa')
        <link rel="stylesheet" href="{{ asset('assets/landing-assets/css/main.css?v=0.08') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/landing-assets/css/main-ltr.css?v=0.08') }}">
    @endif
    @stack('css')
</head>

<body>

    <header class="header">
        <div class="container">
            <div class="header-inner">
                <div class="logo">
                    <a href="#">
                        <img src="{{ asset('assets/landing-assets/img/STORE LOGO-02.png') }}" alt="" class="img-fluid" id="logo">
                    </a>
                </div>

                <div class="header-end">
                    <div class="header-nav">
                        <ul>
                            <li class="active">
                                <a href="javascript;" onclick="event.preventDefault()" data-scroll="home">
                                    {{ translate('Home') }}

                                </a>
                            </li>
                            <li>
                                <a href="javascript;" onclick="event.preventDefault()" data-scroll="features">
                                    {{ translate('Features') }}

                                </a>
                            </li>
                            <li>
                                <a href="javascript;" onclick="event.preventDefault()" data-scroll="testimonials">
                                    {{ translate('Testimonials') }}

                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="header-lang" id="lang-change">
                        @if (app()->getLocale() != 'en')
                            <a href="#" class="lang-link" data-flag="en">
                                EN
                            </a>
                        @else
                            <a href="#" class="lang-link" data-flag="sa">
                                AR
                            </a>
                        @endif
                    </div>

                    <div class="header-action">
                        <button class="btn main-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target=".contact-us-modal">
                            <span>
                                {{ translate('Request your trial copy') }}
                            </span>
                        </button>
                    </div>

                    <div class="toggle-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path fill="none" stroke="#5b5ea8" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32" d="M96 256h320M96 176h320M96 336h320" />
                        </svg>
                    </div>


                </div>
            </div>
        </div>
    </header>
