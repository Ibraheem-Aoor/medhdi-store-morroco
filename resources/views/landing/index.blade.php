{{-- @extends('landing.master')
@section('content')
    <main class="page-wrapper">
        <section class="main-sec block-sec" id="home">
            <div class="container">
                <div class="main-sec-inner">
                    <div class="main-sec-text">
                        <div class="main-icon">
                            <img src="{{ asset('assets/landing-assets/img/main-sec-icon.svg') }}" alt=""
                                class="img-fluid">
                        </div>
                        <h1>
                            {{ translate('Get an online store with professional features with Apex') }}
                        </h1>
                        <p>
                            {{ translate('After we realized the importance of e-commerce and the need for traders to transfer their business to the Internet, we have provided') }}
                            <span>{{ translate('The best version for online stores') }}
                            </span>{{ translate('Which contains all the characteristics that are every trader is looking for them to ensure the success of his trade.') }}
                        </p>
                        <div class="main-sec-btns">
                            <button class="btn main-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target=".contact-us-modal">
                                {{ translate('Request your Demo') }}
                            </button>
                            <a href="{{ route('home') }}" class="btn second-btn">
                                {{ translate('Start the trial for free') }}
                            </a>
                        </div>
                    </div>
                    <div class="main-sec-img">
                        <div class="main-img-box">
                            @if (app()->getLocale() == 'sa')
                                <img src="{{ asset('assets/landing-assets/img/main-img.svg') }}" alt=""
                                    class="img-fluid">
                            @else
                                <img src="{{ asset('assets/landing-assets/img/main-img-en.png') }}" alt=""
                                    class="img-fluid">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec-pattern">
                <img src="{{ asset('assets/landing-assets/img/circle1.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus1.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/circle2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/circle1.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/successfully-pattern.png') }}" alt=""
                    class="img-fluid">
            </div>

        </section>

        <section class="out-features-sec block-sec" id="features">
            <div class="container">
                <div class="out-features-inner">
                    <div class="sec-head">
                        <div class="title">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/features-icon.svg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <h5>{{ translate('Features') }}</h5>
                        </div>
                        <p>{{ translate('There are many reasons to have an online store from Apex') }}</p>
                    </div>

                    <div class="features-boxs">
                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img1.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Control Panel Management') }}</h5>
                            <p>
                                {{ translate('You can manage the online store and control all its settings and features through an easy-to-use control panel') }}
                            </p>
                        </div>


                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img2.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Modern and distinctive designs') }}</h5>
                            <p>
                                {{ translate('The interfaces give an easy and enjoyable experience, which makes the user prefer dealing with your store over others.') }}
                            </p>
                        </div>

                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img3.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Products, orders and sections') }}</h5>
                            <p>
                                {{ translate('You can add an infinite number of products, sections and receive a lot of customer requests on the online store.') }}
                            </p>
                        </div>

                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img4.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Multi Vendor') }}</h5>
                            <p>
                                {{ translate('You can activate the addition of more than one trader to display his products and sell them through your store in exchange for a financial benefit.') }}
                            </p>
                        </div>

                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img5.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Performance reports and stats') }}</h5>
                            <p>
                                {{ translate('You can get reports for store statistics, performance and customer behavior from the online store.') }}
                            </p>
                        </div>

                        <div class="feature-card">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/feature-img6.svg') }}" alt="">
                            </div>
                            <h5>{{ translate('Professional Marketing Tools') }}</h5>
                            <p>
                                {{ translate('You can connect your online store with professional marketing tools that ensures that you can reach your potential customers easily.') }}
                            </p>
                        </div>


                    </div>

                </div>
            </div>

            <div class="sec-pattern">
                <img src="{{ asset('assets/landing-assets/img/plus1.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/circle2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/circle3.svg') }}" alt="" class="img-fluid">
            </div>

        </section>

        <section class="video-sec block-sec">
            <div class="container">
                <div class="video-inner">
                    <div class="sec-head">
                        <div class="title">
                            <div class="icon">
                                <img src="{{ asset('assets/landing-assets/img/video-icon.svg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <h5>{{ translate('Video') }}</h5>
                        </div>
                        <p>{{ translate('You will find here an explanation of store features and how it works') }}
                        </p>
                    </div>
                    <div class="video-box">
                        <a href="https://www.youtube.com/watch?v=PkFoVUEZ1EU" data-fancybox>
                            <div class="video-main-img">
                                <img src="{{ asset('assets/landing-assets/img/video-box-img4.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="video-second-img">
                                <img src="{{ asset('assets/landing-assets/img/video-box-img2.jpg') }}" alt=""
                                    class="img-fluid">
                            </div>

                            <div class="play">
                                <img src="{{ asset('assets/landing-assets/img/play-icon.svg') }}" alt=""
                                    class="img-fluid">
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="sec-pattern">
                <img src="{{ asset('assets/landing-assets/img/circle2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus1.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/circle2.svg') }}" alt="" class="img-fluid">
            </div>


            <div class="video-bg">
                <img src="{{ asset('assets/landing-assets/img/video-bg.svg') }}" alt="" class="img-fluid">
            </div>
        </section>

        <section class="stores-sec block-sec">
            <div class="container">
                <div class="stores-inner">
                    <div class="stores-info">
                        <div class="sec-head">
                            <div class="title">
                                <div class="icon">
                                    <img src="{{ asset('assets/landing-assets/img/stores-icon.svg') }}" alt=""
                                        class="img-fluid">
                                </div>
                                <h5>{{ translate('Examples of our customers\' stores') }}</h5>
                            </div>
                        </div>
                        <h4>
                            {{ translate('Every successful online store has a success partner') }}
                        </h4>
                        <p>
                            {{ translate('Every successful online store which created by us is represents an intrinsic value at Apex') }}
                        </p>
                    </div>
                    <div class="stores-box">
                        <div class="store-card">
                            <a href="https://raedsports.apex.ps/" target="_blank">
                                <img src="{{ asset('assets/landing-assets/img/1-01.png') }}" alt=""
                                    class="img-fluid">
                                <p>رائد للرياضة</p>
                            </a>
                        </div>
                        <div class="store-card">
                            <a href="https://loto-home.com/" target="_blank">
                                <img src="{{ asset('assets/landing-assets/img/3-03.png') }}" alt=""
                                    class="img-fluid">
                                <p>متجر لوتو Loto</p>
                            </a>
                        </div>
                        <div class="store-card">
                            <a href="https://lojaso.apex.ps/"
                                target="_blank">
                                <img src="{{ asset('assets/landing-assets/img/5-05.png') }}" alt=""
                                    class="img-fluid">
                                <p>متجر لوجاسو</p>
                            </a>
                        </div>
                        <div class="store-card">
                            <a href="https://onastores.apex.ps/"
                                target="_blank">
                                <img src="{{ asset('assets/landing-assets/img/6-06.png') }}" alt=""
                                    class="img-fluid">
                                <p>متجر أونا</p>
                            </a>
                        </div>

                        <div class="stores-box-bg">
                            <img src="{{ asset('assets/landing-assets/img/stores-box-bg.svg') }}" alt=""
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec-pattern">
                <img src="{{ asset('assets/landing-assets/img/circle4.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/rectangle.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/point.svg') }}" alt="" class="img-fluid">
            </div>

        </section>

        <section class="testimonials-sec block-sec" id="testimonials">
            <div class="container">
                <div class="sec-head">
                    <div class="title">
                        <div class="icon">
                            <img src="{{ asset('assets/landing-assets/img/testimonials-head-icon.svg') }}"
                                alt="" class="img-fluid">
                        </div>
                        <h5>{{ translate('What did they say about us') }}</h5>
                    </div>
                    <p>
                        {{ translate('Our customers\' trust in us made us devote all our energies and efforts to provide the best for them') }}
                    </p>
                </div>

                <div class="testimonial-inner">

                    <div id="testimonialCarousel" class="carousel slide " data-bs-ride="carousel">
                        <div class="carousel-indicators">

                            <ul>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"
                                    aria-current="true" aria-label="Slide 1">
                                    <img src="{{ asset('assets/landing-assets/img/avatar7.jpg') }}" alt=""
                                        class="img-fluid">
                                </li>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2">
                                    <img src="{{ asset('assets/landing-assets/img/avatar8.jpg') }}" alt=""
                                        class="img-fluid">
                                </li>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3">
                                    <img src="{{ asset('assets/landing-assets/img/avatar9.jpg') }}" alt=""
                                        class="img-fluid">
                                </li>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="3" aria-label="Slide 4">
                                    <img src="{{ asset('assets/landing-assets/img/avatar4.jpg') }}" alt=""
                                        class="img-fluid">
                                </li>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="4" aria-label="Slide 5">
                                    <img src="{{ asset('assets/landing-assets/img/avatar6.jpg') }}" alt=""
                                        class="img-fluid">
                                </li>
                                <li data-bs-target="#testimonialCarousel" data-bs-slide-to="5" aria-label="Slide 6">
                                    <img src="{{ asset('assets/landing-assets/img/avatar5.png') }}" alt=""
                                        class="img-fluid">
                                </li>
                            </ul>
                        </div>
                        <div class="carousel-inner">

                            <div class="carousel-item active">

                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('Masha Allah a great store
                                                                                                                                                                                                                                                I benefited from many of his services that expanded my business and reached me to many clients') }}
                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Fahad Al-Ansari') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="carousel-item">
                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('Apex helped me create my independence by fulfilling my dream of owning my own business
                                                                                                                                                                                                                                                Through them I got an online store that saved me a lot of income') }}

                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Mary Alafasy') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('I did not have a large capital to open a business and I went to trade through Apex
                                                                                                                                                                                                                                                I made a lot of profits') }}
                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Rabah Al Shaeri') }}</span>

                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('I was looking for a store that is easy to control and manage
                                                                                                                                                                                                                                                And I found it through them as much as I can control all the settings of my store easily') }}

                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Mohammed Al-Otaibi') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('Thank you Apex for contributing to opening my own store and starting my business as soon as possible and without high costs') }}

                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Ilham Alshammari') }}</span>

                                    </div>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <div class="testimonial-box">
                                    <p>
                                        {{ translate('My experience with Apex was one of the most fruitful experiences in my life, and my store through them made it easier for me to reach customers because they support it with marketing tools') }}
                                    </p>
                                    <div>
                                        <i></i>
                                        <span>{{ translate('Talal Al Samri') }}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="testimonial-bg">
                    <img src="{{ asset('assets/landing-assets/img/testimonials-bg.svg') }}" alt=""
                        class="img-fluid">
                </div>

            </div>
        </section>

        <section class="contact-us-sec block-sec">
            <div class="container">
                <div class="sec-head">
                    <div class="title">
                        <div class="icon">
                            <img src="{{ asset('assets/landing-assets/img/subscribe-icon.svg') }}" alt=""
                                class="img-fluid">
                        </div>
                        <h5>{{ translate('Subscribe') }}</h5>
                    </div>
                    <p>{{ translate('Get your demo from online stores') }}</p>
                </div>
                <div class="contact-us-inner">
                    <div class="contact-img">
                        <img src="{{ asset('assets/landing-assets/img/contact-img.png') }}" alt=""
                            class="img-fluid">
                    </div>
                    <div class="contact-card">
                        <div class="contact-head">
                            <h6>{{ translate('Contact Us') }}</h6>
                            <p>
                                {{ translate('If you want to enter the world of commerce, become one of the top traders, get an online store and achieve the highest profits, just subscribe with us.') }}
                            </p>
                        </div>
                        <form class="w-100" action="{{ route('landing.submit') }}" method="POST" id="demo-form">
                            @csrf
                            <div class="from-group">
                                <div class="from-box">
                                    <label>
                                        {{ translate('name') }}
                                    </label>
                                    <input type="text" class="form-control" name="name" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="from-group">
                                <div class="from-box">
                                    <label>
                                        {{ translate('E-mail') }}
                                    </label>
                                    <input type="email" class="form-control" name="email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="from-group">
                                <div class="from-box">
                                    <label>
                                        {{ translate('Phone') }}
                                    </label>
                                    <div class="phone-box">
                                        <input type="text" class="form-control phone-input" name="contact_number"
                                            required>
                                        @error('contact_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="from-group">
                                <div class="from-box">
                                    <label>
                                        {{ translate('Store Type') }}
                                    </label>
                                    <select class="form-control" title="تصنيف المتجر" required name="shop_type">
                                        <option selected></option>
                                        <option value="Vendor">{{ translate('Single Vendor') }}</option>
                                        <option value="Mulit Vendor">{{ translate('Mutlipe Vendors') }}</option>
                                        {{-- <option value="">تصنيف 4</option> --}}
                                    </select>

                                    @error('shop_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="contact-btn">
                                <button class="btn main-btn" type="submit" class="btn btn-primary">
                                    <span>{{ translate('submit') }}</span>
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

            <div class="sec-pattern">
                <img src="{{ asset('assets/landing-assets/img/circle2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/rectangle.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/plus2.svg') }}" alt="" class="img-fluid">
                <img src="{{ asset('assets/landing-assets/img/point-big.svg') }}" alt="" class="img-fluid">

            </div>


        </section>

    </main>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                $('#successfully').modal('show');
            @endif

            $('#demo-form').on('submit', function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
            });

            $('#demo-form-2').on('submit', function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
            });
        });

        $('#lang-change a').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                var locale = $this.data('flag');
                $.post('{{ route('language.change') }}', {
                    _token: "{{ csrf_token() }}",
                    locale: locale
                }, function(data) {
                    location.reload();
                });

            });
        });
    </script>
@endpush --}}
