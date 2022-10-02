<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
        <path d="M16.5,3C13.605,3,12,5.09,12,5.09S10.395,3,7.5,3C4.462,3,2,5.462,2,8.5C2,14,12,21,12,21s10-7,10-12.5 C22,5.462,19.538,3,16.5,3z M12,18.518C8.517,15.845,4,11.406,4,8.5C4,6.57,5.57,5,7.5,5C9.902,5,12,7.907,12,7.907S14.14,5,16.5,5 C18.43,5,20,6.57,20,8.5C20,11.406,15.483,15.845,12,18.518z" fill="#5B5B5B" />
      </svg>
    <span class="flex-grow-1 ml-1">
        @if(Auth::check())
            <span class="badge badge-primary badge-inline badge-pill">{{ count(Auth::user()->wishlists)}}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Wishlist')}}</span>
    </span>
</a>
