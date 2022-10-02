<table>
    <thead>
        <tr class="gry-color" style="background: lightgray !important;">
            <th>{{ translate('Client') }}</th>
            <th>{{ translate('Address') }}</th>
            <th>{{ translate('Phone') }}</th>
            <th>{{ translate('City') }}</th>
            <th>{{ translate('Price') }}</th>
            <th>{{ translate('Storage Code') }}</th>
            <th>{{ translate('Order Code') }}</th>
            <th>{{ translate('Date') }}</th>

        </tr>
    </thead>
    <tbody style="text-align: center !important; font-weight:bold !important;">
        @foreach ($orders as $order)
            <tr>
                @php
                    $address = json_decode($order->shipping_address, true);
                @endphp
                <td>
                    {{ $address['name'] }}
                </td>
                <td>
                    {{ $address['address'] }}
                </td>
                <td>
                    {{ $address['phone'] }}
                </td>
                <td>
                    {{ $address['city'] }}
                </td>
                <td>{{ single_price($order->grand_total) }}</td>

                <td class="">
                    <ol type="1">
                        @foreach ($order->orderDetails as $detailedOrder)
                            @if ($product = $detailedOrder->product)
                                <li>{{ $product->stocks[0]->sku }}
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </td>
                <td>
                    {{ $order->code }}
                </td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
