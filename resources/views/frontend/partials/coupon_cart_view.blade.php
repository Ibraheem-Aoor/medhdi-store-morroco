<div class="card border-0 shadow-sm rounded">
    <div class="card-body p-0">
        @if (Auth::check() && get_setting('coupon_system') == 1)
            @php
                $coupon_discount = $carts->sum('discount');
                $coupon_code = null;
            @endphp
            @foreach ($carts as $key => $cartItem)
                @if ($cartItem->coupon_applied == 1 && $cartItem->discount > 0)
                    @php
                        $coupon_code = $cartItem->coupon_code;
                        break;
                    @endphp
                @endif
            @endforeach
            @if ($coupon_discount > 0 && $coupon_code)
                <div class="mt-3">
                    <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden name="flag">
                        <div class="input-group">
                            <div class="form-control">{{ $coupon_code }}</div>
                            <div class="input-group-append">
                                <button type="button" id="coupon-remove"
                                    class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                        @csrf
                        <input type="text" hidden name="flag">
                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="code"
                                onkeydown="return event.key != 'Enter';"
                                placeholder="{{ translate('Have coupon code? Enter here') }}" required>
                            <div class="input-group-append">
                                <button type="button" id="coupon-apply"
                                    class="btn btn-primary">{{ translate('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>
