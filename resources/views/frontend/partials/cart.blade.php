@php
if(auth()->user() != null) {
    $user_id = Auth::user()->id;
    $cart = \App\Models\Cart::where('user_id', $user_id)->get();
} else {
    $temp_user_id = Session()->get('temp_user_id');
    if($temp_user_id) {
        $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
    }
}

@endphp
<a href="javascript:void(0)" class="d-flex align-items-center text-reset" data-toggle="dropdown" data-display="static">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
        <path d="M4.4140625 1.9960938L1.0039062 2.0136719L1.0136719 4.0136719L3.0839844 4.0039062L6.3789062 11.908203L5.1816406 13.824219C4.7816406 14.464219 4.7609531 15.272641 5.1269531 15.931641C5.4929531 16.590641 6.1874063 17 6.9414062 17L19 17L19 15L6.9414062 15L6.8769531 14.882812L8.0527344 13L15.521484 13C16.248484 13 16.917531 12.604703 17.269531 11.970703L20.873047 5.4863281C21.046047 5.1763281 21.041328 4.7981875 20.861328 4.4921875C20.681328 4.1871875 20.352047 4 19.998047 4L5.25 4L4.4140625 1.9960938 z M 6.0820312 6L18.298828 6L15.521484 11L8.1660156 11L6.0820312 6 z M 7 18 A 2 2 0 0 0 5 20 A 2 2 0 0 0 7 22 A 2 2 0 0 0 9 20 A 2 2 0 0 0 7 18 z M 17 18 A 2 2 0 0 0 15 20 A 2 2 0 0 0 17 22 A 2 2 0 0 0 19 20 A 2 2 0 0 0 17 18 z" fill="#5B5B5B" />
    </svg>
    <span class="flex-grow-1 ml-1">
        @if(isset($cart) && count($cart) > 0)
            <span class="badge badge-primary badge-inline badge-pill cart-count">
                {{ count($cart)}}
            </span>
        @else
            <span class="badge badge-primary badge-inline badge-pill cart-count">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{translate('Cart')}}</span>
    </span>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 stop-propagation">

    @if(isset($cart) && count($cart) > 0)
        <div class="p-3 fs-15 fw-600 p-3 border-bottom">
            {{translate('Cart Items')}}
        </div>
        <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">
            @php
                $total = 0;
            @endphp
            @foreach($cart as $key => $cartItem)
                @php
                    $product = \App\Models\Product::find($cartItem['product_id']);
                    $total = $total + ($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity'];
                @endphp
                @if ($product != null)
                    <li class="list-group-item">
                        <span class="d-flex align-items-center">
                            <a href="{{ route('product', $product->slug) }}" class="text-reset d-flex align-items-center flex-grow-1">
                                <img
                                    src="{{ asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    class="img-fit lazyload size-60px rounded"
                                    alt="{{  $product->getTranslation('name')  }}"
                                >
                                <span class="minw-0 pl-2 flex-grow-1">
                                    <span class="fw-600 mb-1 text-truncate-2">
                                            {{  $product->getTranslation('name')  }}
                                    </span>
                                    <span class="">{{ $cartItem['quantity'] }}x</span>
                                    <span class="">{{ single_price($cartItem['price'] + $cartItem['tax']) }}</span>
                                </span>
                            </a>
                            <span class="">
                                <button onclick="removeFromCart({{ $cartItem['id'] }})" class="btn btn-sm btn-icon stop-propagation">
                                    <i class="la la-close"></i>
                                </button>
                            </span>
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
            <span class="opacity-90">{{translate('Subtotal')}}</span>
            <span class="fw-600">{{ single_price($total) }}</span>
        </div>
        <div class="px-3 py-3 text-center border-top">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="{{ route('cart') }}" class="btn btn-soft-primary btn-sm">
                        {{translate('View cart')}}
                    </a>
                </li>
                @if (Auth::check())
                <li class="list-inline-item">
                    <a href="{{ route('cart')  }}" class="btn btn-primary btn-sm">
                        {{translate('Finish Order')}}
                    </a>
                </li>
                @endif
            </ul>
        </div>
    @else
        <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{translate('Your Cart is empty')}}</h3>
        </div>
    @endif

</div>
