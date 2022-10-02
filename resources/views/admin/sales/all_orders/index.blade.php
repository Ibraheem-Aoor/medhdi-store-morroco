@extends('admin.layouts.app')
@section('title', translate('All Orders'))

@section('content')

    <div class="card">
        <form class=""  id="sort_orders" method="POST" action="{{route('bulk-order-export')}}">
            @csrf
            <div class="card-header row gutters-5">

                <div class="col">
                    <h5 class="mb-md-0 h6">
                        {{ $request_segment == 'all_orders' ? translate('All  Orders') : translate('All  Today Orders') }}
                    </h5>
                </div>

                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ translate('Bulk Action') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="bulk_delete();">
                            {{ translate('Delete selection') }}</a>
                    </div>
                </div>


                @if ($request_segment == 'all_orders')
                    <div class="col-lg-2">
                        <div class="form-group mb-0">
                            <input type="text" class="aiz-date-range form-control" value="{{ $date }}"
                                name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y"
                                data-separator=" to " data-advanced-range="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" id="search"
                                name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type Order code & hit Enter') }}">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary mt-lg-0 mt-3">{{ translate('Filter') }}</button>
                        </div>
                    </div>
                @endif
                <a class="btn btn-info mt-lg-0 mt-3" href="#" onclick="$('#sort_orders').submit();">
                    {{ translate('Export selection') }}</a>
            </div>





            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <!--<th>#</th>-->
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th>{{ translate('Order Code') }}</th>
                            <th data-breakpoints="md">{{ translate('Num. of Products') }}</th>
                            <th data-breakpoints="md">{{ translate('Product') }}</th>
                            <th data-breakpoints="md">{{ translate('Amount') }}</th>
                            <th data-breakpoints="md">{{ translate('Status') }}</th>
                            @if (addon_is_activated('refund_request'))
                                <th>{{ translate('Refund') }}</th>
                            @endif
                            <th class="text-right" width="15%">{{ translate('options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                {{-- <td>
                                    {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                                </td> --}}
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]"
                                                value="{{ $order->id }}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    {{ $order->code }}
                                </td>

                                <td>
                                    {{ count($order->orderDetails) }}
                                </td>
                                <td>
                                    {{ $order->orderDetails[0]?->product?->getTranslation('name') }}
                                </td>
                                <td>
                                    {{ single_price($order->combined_order_id != null ? $order->grand_total : $order->orderDetails->sum('price') + $order->orderDetails->sum('quantity')) }}
                                </td>
                                <td>
                                    {{ $order->status?->name }}
                                </td>
                                @if (addon_is_activated('refund_request'))
                                    <td>
                                        @if (count($order->refund_requests) > 0)
                                            {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                        @else
                                            {{ translate('No Refund') }}
                                        @endif
                                    </td>
                                @endif
                                <td class="text-right">
                                    {{-- <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        data-order-id="{{ $order->id }}" data-toggle="modal"
                                        data-target="#exampleModal" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a> --}}
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('all_orders.show', encrypt($order->id)) }}"
                                        title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="{{ route('invoice.download', $order->id) }}"
                                        title="{{ translate('Download Invoice') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('orders.destroy', $order->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="aiz-pagination">
                    {{ $orders->appends(request()->input())->links() }}
                </div>

            </div>
        </form>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });



        function bulk_delete() {
            var data = new FormData($('#sort_orders')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-order-delete') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }

        function bulk_export() {
            var data = new FormData($('#sort_orders')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-order-export') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Sample.pdf";
                    link.click();
                },
                error: function(blob) {
                    console.log(blob);

                }
            });
        }
    </script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(e) {
            var src = e.relatedTarget;
            var order_id = src.getAttribute('data-order-id');
            console.log(order_id);
            $(this).find('input[name="order_id"]').val(order_id);

        });

        @if (Session::has('updated'))
            AIZ.plugins.notify('success', "{{ Session::get('updated') }}");
        @endif
    </script>
@endsection
