@php
$random_products = Cache::remember('random_products', 86400, function () {
    return \App\Models\Product::where('featured', 1)
        ->inRandomOrder()
        ->take(36)
        ->get();
});
@endphp

@if (count($random_products) > 0)
    @foreach ($random_products as $key => $product)
        <div class="col mb-2">
            <div class="aiz-card-box border border-light rounded  hov-shadow-md h-100 has-transition bg-white">
                <div class="position-relative">
                    <a href="{{ route('product', $product->slug) }}" class="d-block">
                        <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                            src="{{ asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                    </a>
                    <div class="absolute-top-left pt-2 pl-2">
                        @if ($product->conditon == 'new')
                            <span class="badge badge-inline badge-success">{{ translate('new') }}</span>
                        @elseif($product->conditon == 'used')
                            <span class="badge badge-inline badge-danger">{{ translate('Used') }}</span>
                        @endif
                    </div>
                </div>
                <div class="p-md-3 p-2 text-left">
                    <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                        <a href="{{ route('product', $product->slug) }}"
                            class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                    </h3>
                    <div class="fs-15">
                        <span class="fw-700 text-primary">{{ single_price($product->unit_price) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
