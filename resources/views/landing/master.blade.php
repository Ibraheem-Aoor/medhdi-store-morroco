@include('landing.header')
@yield('content')
<a class="whats-app"
href="https://wa.me/+966530320831" title="{{ translate('Contact Us') }}" target="_blank">
<img width="80%" class="my-float"
    src="{{asset('assets/img/Whatsapp-Icon.png')}}">
</a>
@include('landing.contact-modal')
@include('landing.success-modal')
@include('landing.footer')
