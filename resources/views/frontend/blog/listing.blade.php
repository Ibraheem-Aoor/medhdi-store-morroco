@extends('frontend.layouts.app')

@section('content')
    @php
    $lang = App()->getLocale();
    @endphp
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Blog') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">
                                {{ translate('Home') }}
                            </a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('blog') }}">
                                "{{ translate('Blog') }}"
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-4">
        <div class="container">
            <div class="card-columns">
                @foreach ($blogs as $blog)
                    <div class="card mb-3 overflow-hidden shadow-sm">
                        <a href="{{ url('blog') . '/' . $blog->slug }}" class="text-reset d-block">
                            <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset($blog->banner) }}"
                                alt="{{ $blog->getTranslation('title', $lang) }}" class="img-fluid lazyload ">
                        </a>
                        <div class="p-4">
                            <h2 class="fs-18 fw-600 mb-1">
                                <a href="{{ url('blog') . '/' . $blog->slug }}" class="text-reset">
                                    {{ $blog->getTranslation('title', $lang) }}
                                </a>
                            </h2>
                            @if ($blog->category != null)
                                <div class="mb-2 opacity-50">
                                    <i>{{ $blog->category->getTranslation('category_name', $lang) }}</i> <br>
                                    @isset($blog->author)
                                        <i>{{ translate('Writer') }}: {{ $blog->getTranslation('author', $lang) }}</i>
                                    @endisset

                                </div>
                            @endif
                            <p class="opacity-70 mb-4">
                                {{ $blog->getTranslation('short_description', $lang) }}
                            </p>
                            <a href="{{ url('blog') . '/' . $blog->slug }}" class="btn btn-soft-primary">
                                {{ translate('View More') }}

                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="aiz-pagination aiz-pagination-center mt-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
@endsection
