<a href="{{ route('compare') }}" class="d-flex align-items-center text-reset position-relative">
    {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="26" height="26">
        <path d="M12.5 5C10.458334 5 8.7371483 5.8196334 7.6289062 7.0664062C6.5206642 8.3131791 6 9.9166668 6 11.5C6 13.083333 6.5206642 14.686821 7.6289062 15.933594C8.4533588 16.861103 9.6175162 17.550618 11 17.84375L11 32.5C11 35.519774 13.480226 38 16.5 38L20.878906 38L19.439453 39.439453 A 1.50015 1.50015 0 1 0 21.560547 41.560547L25.560547 37.560547 A 1.50015 1.50015 0 0 0 25.560547 35.439453L21.560547 31.439453 A 1.50015 1.50015 0 0 0 20.484375 30.984375 A 1.50015 1.50015 0 0 0 19.439453 33.560547L20.878906 35L16.5 35C15.101774 35 14 33.898226 14 32.5L14 17.816406C16.855038 17.132705 19 14.555329 19 11.5C19 7.9279176 16.072085 5 12.5 5 z M 27.470703 5.9863281 A 1.50015 1.50015 0 0 0 26.439453 6.4394531L22.439453 10.439453 A 1.50015 1.50015 0 0 0 22.439453 12.560547L26.439453 16.560547 A 1.50015 1.50015 0 1 0 28.560547 14.439453L27.121094 13L31.5 13C32.898226 13 34 14.101774 34 15.5L34 30.304688C32.649706 30.606312 31.43873 31.155354 30.628906 32.066406C29.520664 33.313179 29 34.916667 29 36.5C29 38.083333 29.520664 39.686821 30.628906 40.933594C31.737148 42.180367 33.458334 43 35.5 43C39.072085 43 42 40.072082 42 36.5C42 33.458708 39.835368 31.002599 37 30.304688L37 15.5C37 12.480226 34.519774 10 31.5 10L27.121094 10L28.560547 8.5605469 A 1.50015 1.50015 0 0 0 27.470703 5.9863281 z M 12.5 8C14.450766 8 16 9.549235 16 11.5C16 13.40254 14.52312 14.912308 12.640625 14.986328 A 1.50015 1.50015 0 0 0 12.476562 14.978516 A 1.50015 1.50015 0 0 0 12.347656 14.986328C11.154195 14.950981 10.40526 14.542343 9.8710938 13.941406C9.3126698 13.313179 9 12.416667 9 11.5C9 10.583333 9.3126698 9.6868209 9.8710938 9.0585938C10.429518 8.4303665 11.208334 8 12.5 8 z M 35.408203 33.017578 A 1.50015 1.50015 0 0 0 35.585938 33.017578C37.49337 33.065201 39 34.579875 39 36.5C39 38.450765 37.450766 40 35.5 40C34.208334 40 33.429518 39.569633 32.871094 38.941406C32.31267 38.313179 32 37.416667 32 36.5C32 35.583333 32.31267 34.686821 32.871094 34.058594C33.413375 33.448527 34.182432 33.041576 35.408203 33.017578 z" fill="#5B5B5B" />
    </svg> --}}
    <i class="la la-refresh la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
        @if(Session::has('compare'))
            <span class="badge badge-primary badge-inline badge-pill">{{ count(Session::get('compare'))}}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Compare')}}</span>
    </span>
</a>