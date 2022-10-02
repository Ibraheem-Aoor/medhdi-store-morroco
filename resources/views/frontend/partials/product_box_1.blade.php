<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">

    <div class="card-box-list">
        @if (discount_in_percentage($product) > 0)
        <div class="list-item">
            <span class="badge-custom sale-badge">{{ translate('OFF') }}<span
                    class="box ml-1 mr-0">{{ discount_in_percentage($product) }}%</span></span>
        </div>
        @endif

        @if ($product->new)
        <div class="list-item">
            <span class="badge-custom badge-text">{{ translate('New') }}</span>
        </div>
        @endif

        @if ($product->soon)
        <div class="list-item">
            <span class="badge-custom badge-text">{{ app()->getLocale() == 'en' ? 'Soon' : 'قريبا' }}</span>
        </div>
        @endif

        @if ($product->best_selling)
        <div class="list-item">
            <span class="badge-custom badge-text">{{ translate('best_selling') }}</span>
        </div>
        @endif
    </div>

    <div class="position-relative">
        <a href="{{ route('product', $product->slug) }}" class="d-block">
            <img class="img-fit lazyload mx-auto h-140px h-md-210px" src="{{ asset('slider.png') }}"
                data-src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
        </a>
        @if ($product->wholesale_product)
            <span class="absolute-bottom-left fs-11 text-white fw-600 px-2 lh-1-8" style="background-color: #455a64">
                {{ translate('Wholesale') }}
            </span>
        @endif
        <div class="absolute-top-right aiz-p-hov-icon aiz-card-absolute">
            {{-- <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to compare') }}" data-placement="left">
                <i class="las la-sync"></i>
            </a>
            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ translate('Add to cart') }}" data-placement="left">
                <i class="las la-shopping-cart"></i>
            </a> --}}
        </div>
    </div>
    <div class="p-md-3 p-2 text-left">

        <h3 class="fw-500 fs-15 text-truncate-2 lh-1-4 mb-0 h-45px">
            <a href="{{ route('product', $product->slug) }}"
                class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
        </h3>
        <div class="fs-15">
            @if (home_base_price($product) != home_discounted_base_price($product))
                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
        </div>
        <div class="rating rating-sm mt-1">
            {{ renderStarRating($product->rating) }}
        </div>

        @if (addon_is_activated('club_point'))
            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                {{ translate('Club Point') }}:
                <span class="fw-700 float-right">{{ $product->earn_point }}</span>
            </div>
        @endif
    </div>
</div>
