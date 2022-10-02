<div class="modal-body p-4 c-scrollbar-light">
    <div class="row">
        <div class="col-lg-6">
            <div class="row gutters-10 flex-row-reverse">
                @php
                    $photos = explode(',', $product->photos);
                @endphp
                <div class="col">
                    <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true'
                        data-auto-height='true'>
                        @foreach ($photos as $key => $photo)
                            <div class="carousel-box img-zoom rounded">
                                <img class="img-fluid lazyload" src="{{ asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($photo) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                            </div>
                        @endforeach
                        @foreach ($product->stocks as $key => $stock)
                            @if ($stock->image != null)
                                <div class="carousel-box img-zoom rounded">
                                    <img class="img-fluid lazyload" src="{{ asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($stock->image) }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-auto w-90px">
                    <div class="aiz-carousel carousel-thumb product-gallery-thumb" data-items='5'
                        data-nav-for='.product-gallery' data-vertical='true' data-focus-select='true'>
                        @foreach ($photos as $key => $photo)
                            <div class="carousel-box c-pointer border p-1 rounded">
                                <img class="lazyload mw-100 size-60px mx-auto"
                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($photo) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                            </div>
                        @endforeach
                        @foreach ($product->stocks as $key => $stock)
                            @if ($stock->image != null)
                                <div class="carousel-box c-pointer border p-1 rounded"
                                    data-variation="{{ $stock->variant }}">
                                    <img class="lazyload mw-100 size-50px mx-auto"
                                        src="{{ asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($stock->image) }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder.jpg') }}';">
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="text-left">
                <h2 class="mb-2 fs-20 fw-600">
                    {{ $product->getTranslation('name') }}
                </h2>

                @if (home_price($product) != home_discounted_price($product))
                    <div class="row  my-3">
                        <div class="col-3">
                            <div class="opacity-90">{{ translate('Price') }}:</div>
                        </div>
                        <div class="col-9">
                            <div class="h6 opacity-60">
                                <del>
                                    {{ home_price($product) }}
                                    {{-- @if ($product->unit != null)
                                        <span>/{{ $product->getTranslation('unit') }}</span>
                                    @endif --}}
                                </del>
                            </div>
                        </div>
                    </div>

                    <div class="row  my-2">
                        <div class="col-3">
                            <div class="opacity-90">{{ translate('Discount Price') }}:</div>
                        </div>
                        <div class="col-9">
                            <div class="">
                                <strong class="h6 fw-600 text-primary">
                                    {{ home_discounted_price($product) }}
                                </strong>
                                {{-- @if ($product->unit != null)
                                    <span class="opacity-70">/{{ $product->getTranslation('unit') }}</span>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row  mt-3">
                        <div class="col-3">
                            <div class="opacity-90">{{ translate('Price') }}:</div>
                        </div>
                        <div class="col-9">
                            <div class="">
                                <strong class="h5 fw-600 text-primary">
                                    {{ home_discounted_price($product) }}
                                </strong>
                            </div>
                        </div>
                    </div>
                @endif

                @if (addon_is_activated('club_point') && $product->earn_point > 0)
                    <div class="row  mt-4">
                        <div class="col-3">
                            <div class="opacity-90">{{ translate('Club Point') }}:</div>
                        </div>
                        <div class="col-9">
                            <div class="d-inline-block club-point bg-soft-primary px-3 py-1 border">
                                <span class="strong-700">{{ $product->earn_point }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- <hr> --}}

                @php
                    $qty = 0;
                    foreach ($product->stocks as $key => $stock) {
                        $qty += $stock->qty;
                    }
                @endphp

                <form id="option-choice-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <!-- Quantity + Add to cart -->
                    @if ($product->digital != 1)
                        @if ($product->choice_options != null)
                            @foreach (json_decode($product->choice_options) as $key => $choice)
                                <div class="row ">
                                    <div class="col-3">
                                        <div class="opacity-90 mt-2 ">
                                            {{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="aiz-radio-inline">
                                            @foreach ($choice->values as $key => $value)
                                                <label class="aiz-megabox pl-0 mr-2">
                                                    <input type="radio"
                                                        name="attribute_id_{{ $choice->attribute_id }}"
                                                        value="{{ $value }}"
                                                        @if ($key == 0) checked @endif>
                                                    <span
                                                        class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                        {{ $value }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (count(json_decode($product->colors)) > 0)
                            <div class="row ">
                                <div class="col-3">
                                    <div class="opacity-50 mt-2">{{ translate('Color') }}:</div>
                                </div>
                                <div class="col-9">
                                    <div class="aiz-radio-inline">
                                        @foreach (json_decode($product->colors) as $key => $color)
                                            <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip"
                                                data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                                <input type="radio" name="color"
                                                    value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                                    @if ($key == 0) checked @endif>
                                                <span
                                                    class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                    <span class="size-30px d-inline-block rounded"
                                                        style="background: {{ $color }};"></span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <hr>
                        @endif

                        <div class="row mt-4  my-2 product-quantity-box">
                            <div class="col-3">
                                <div class="opacity-90 mt-2">{{ translate('Quantity') }}:</div>
                            </div>
                            <div class="col-9">
                                <div class="product-quantity d-flex align-items-center">
                                    <div class="row  align-items-center aiz-plus-minus mx-0" style="width: 100px;">
                                        <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button"
                                            data-type="minus" data-field="quantity" disabled="">
                                            <i class="las la-minus"></i>
                                        </button>
                                        <input type="number" name="quantity"
                                            class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                            placeholder="1" value="{{ $product->min_qty }}"
                                            min="{{ $product->min_qty }}" max="10" lang="en"  onchange="updateQuantity({{ $product->id }}, this)">
                                        <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light"
                                            type="button" data-type="plus" data-field="quantity">
                                            <i class="las la-plus"></i>
                                        </button>
                                    </div>
                                    <div class="avialable-amount opacity-60 mx-3">
                                        @if ($product->stock_visibility_state == 'quantity')
                                            (<span id="available-quantity">{{ $qty }}</span>
                                            {{ translate('available') }})
                                        @elseif($product->stock_visibility_state == 'text' && $qty >= 1)
                                            (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    <div class="row  mt-4 pb-3 d-none" id="chosen_price_div">
                        <div class="col-3">
                            <div class="opacity-90">{{ translate('Total Price') }}:</div>
                        </div>
                        <div class="col-9">
                            <div class="product-price">
                                <strong id="chosen_price" class="h3 fw-600 text-primary">

                                </strong>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="mt-3">
                    {{-- @if ($product->digital == 1)
                        <button type="button" class="btn add-to-cart-btn buy-now fw-600 add-to-cart" onclick="addToCart()">
                            <i class="la fs-22 la-shopping-cart"></i>
                            <span class="d-none d-md-inline-block">{{ translate('Add to cart')}}</span> --}}
                    </button>
                    @if ($qty > 0)
                        @if ($product->external_link != null)
                            <a type="button" class="btn btn-soft-primary mr-2 add-to-cart fw-600"
                                href="{{ $product->external_link }}">
                                <i class="las la-share"></i>
                                <span
                                    class="d-none d-md-inline-block">{{ translate($product->external_link_btn) }}</span>
                            </a>
                        @else
                            <button type="button" class="btn add-to-cart-btn buy-now fw-600 add-to-cart"
                                onclick="addToCart()">
                                <i class="la fs-22 la-shopping-cart"></i>
                                <span class="d-none d-md-inline-block">{{ translate('Add to cart') }}</span>
                            </button>
                        @endif
                    @endif
                    <button type="button" class="btn btn-secondary out-of-stock fw-600 d-none" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25">
                            <path
                                d="M3.5 3C2.673 3 2 3.673 2 4.5L2 9L3 9L3 19C3 20.103 3.897 21 5 21L10.587891 21C10.331891 20.369 10.155359 19.699 10.068359 19L5 19L5 9L19 9L19 10.068359C19.699 10.155359 20.369 10.331891 21 10.587891L21 9L22 9L22 4.5C22 3.673 21.327 3 20.5 3L3.5 3 z M 4 5L20 5L20 7L4 7L4 5 z M 9 11L9 13L11.759766 13C12.410766 12.189 13.215859 11.507 14.130859 11L9 11 z M 18 12C14.698136 12 12 14.698136 12 18C12 21.301864 14.698136 24 18 24C21.301864 24 24 21.301864 24 18C24 14.698136 21.301864 12 18 12 z M 18 14C20.220984 14 22 15.779016 22 18C22 18.743688 21.786236 19.429056 21.4375 20.023438L15.976562 14.5625C16.570944 14.213764 17.256312 14 18 14 z M 14.5625 15.976562L20.023438 21.4375C19.429056 21.786236 18.743688 22 18 22C15.779016 22 14 20.220984 14 18C14 17.256312 14.213764 16.570944 14.5625 15.976562 z"
                                fill="#856404"></path>
                        </svg>
                        <span class="px-2">
                            {{ translate('Out of Stock') }}
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#option-choice-form input').on('change', function() {
        getVariantPrice();
    });

    function updateQuantity(key, element) {
        $.post('{{ route('product.updateQuantity_2') }}', {
            _token: AIZ.data.csrf,
            id: key,
            quantity: element.value
        }, function(data) {
            $('#chosen_price').html(data);
        });
    }
</script>
