@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Purchase History') }}</h5>
        </div>
        @if (count($orders) > 0)
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ translate('Code') }}</th>
                            <th data-breakpoints="md">{{ translate('Date') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th data-breakpoints="md">{{ translate('Delivery Status') }}</th>
                            <th data-breakpoints="md">{{ translate('Payment Status') }}</th>
                            <th class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            @if (count($order->orderDetails) > 0)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('purchase_history.details', encrypt($order->id)) }}">{{ $order->code }}</a>
                                    </td>
                                    <td>{{ date('d-m-Y', $order->date) }}</td>
                                    <td>
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                    <td>
                                        {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}
                                        @if ($order->delivery_viewed == 0)
                                            <span class="ml-2" style="color:green"></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                        @else
                                            <span
                                                class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                        @endif
                                        @if ($order->payment_status_viewed == 0)
                                            <span class="ml-2" style="color:green"></span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($order->delivery_status == 'pending' && $order->payment_status == 'unpaid')
                                            <a href="javascript:void(0)"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete p-0 d-inline-flex justify-content-center align-items-center  m-1"
                                                data-href="{{ route('purchase_history.destroy', $order->id) }}"
                                                title="{{ translate('Cancel') }}">
                                                <i class="las la-lg la-trash"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('purchase_history.details', encrypt($order->id)) }}"
                                            class="btn btn-soft-info btn-icon btn-circle btn-sm p-0 d-inline-flex justify-content-center align-items-center m-1"
                                            title="{{ translate('Order Details') }}">
                                            <i class="las la-lg la-eye"></i>
                                        </a>
                                        <a class="btn btn-soft-warning btn-icon btn-circle btn-sm p-0 d-inline-flex justify-content-center align-items-center  m-1"
                                            href="{{ route('invoice.download', $order->id) }}"
                                            title="{{ translate('Download Invoice') }}">
                                            <i class="las la-lg la-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="col">
                    <div class="text-center bg-white p-4 rounded shadow">
                        <img class="mw-100 h-200px" src="{{ asset('assets/img/nothing.svg') }}" alt="Image">
                        <h5 class="mb-0 h5 mt-3">{{ translate("There isn't any order yet!") }}</h5>
                    </div>
                </div>
        @endif
    </div>


    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function() {
            location.reload();
        })
    </script>
@endsection
