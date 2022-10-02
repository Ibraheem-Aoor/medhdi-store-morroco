<footer class="footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer-info">
                            <div class="footer-inner-logo">
                                <img src="{{ asset('assets/landing-assets/img/STORE 2-04.png') }}" alt=""
                                    class="img-fluid">
                            </div>
                            <div class="footer-inner-text">
                                <p>
                                    {{translate('Start trading with Apex by owning an online store, you will be able to compete with the major traders and achieve higher revenue, get your demo and display your products for sale by just a few simple steps.')}}
                                </p>
                            </div>
                            <div class="footer-inner-social">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/apex4itsol" target="_blank">
                                            <img src="{{ asset('assets/landing-assets/img/facebook.svg') }}"
                                                alt="" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/Apex4itsol" target="_blank">
                                            <img src="{{ asset('assets/landing-assets/img/twitter.svg') }}"
                                                alt="" class="img-fluid">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://instagram.com/apex4itsol" target="_blank">
                                            <img src="{{ asset('assets/landing-assets/img/instagram.svg') }}"
                                                alt="" class="img-fluid">
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="">
                                            <img src="{{ asset('assets/landing-assets/img/youtube.svg') }}"
                                                alt="" class="img-fluid">
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="footer-list">
                                    <h4>{{translate('Menu')}}</h4>
                                    <ul>
                                        <li>
                                            <a href="#home">
                                                {{translate('Home')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#features">
                                                {{translate('Features')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#testimonials">
                                                {{translate('Testimonials')}}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="footer-list connect-us-list">
                                    <h4>{{translate('Contact Us')}}</h4>
                                    <ul>
                                        <li>
                                            <a href="">
                                                <img src="{{ asset('assets/landing-assets/img/phone.svg') }}"
                                                    alt="" class="img-fluid">
                                                <span>
                                                    <a href="tel:+966530320831">
                                                        <bdo dir="ltr">
                                                            +966530320831
                                                        </bdo>
                                                    </a>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <img src="{{ asset('assets/landing-assets/img/mail.svg') }}"
                                                    alt="" class="img-fluid">
                                                <span>
                                                    <a href="mailto:stores@apex.ps">
                                                        stores@apex.ps
                                                    </a>
                                                </span>
                                            </a>
                                        </li>
                                        {{-- <li>
                                            <a href="">
                                                <img src="{{ asset('assets/landing-assets/img/location.svg') }}"
                                                    alt="" class="img-fluid">
                                                <span>{{translate('Jeddah - Saudi Arabia')}}</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <p>
                    {{translate('All rights reserved to Apex')}} &copy; {{date('Y')}}
                </p>
            </div>
        </div>
    </div>
</footer>



<script src="{{ asset('assets/landing-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/landing-assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/landing-assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/landing-assets/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('assets/landing-assets/js/main.js') }}"></script>
<script>
    var myCarousel = document.querySelector('#testimonialCarousel')
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 4000,
        wrap: true
    })
</script>
@stack('js')
</body>

</html>
