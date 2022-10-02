@if ($flag == 2)
    <table class="table aiz-table mb-0">
        <thead>
            <tr>
                <!--<th>#</th>-->
                <th data-breakpoints="md">{{ translate('Status Name') }}</th>
                <th class="text-right" width="15%">{{ translate('options') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>

                    <td>
                        {{ $status->name }}
                    </td>
                    <td class="text-right">

                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                            data-href="{{ route('orders.destroy', $status->id) }}" title="{{ translate('Delete') }}">
                            <i class="las la-edit"></i>
                        </a>

                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                            data-href="{{ route('orders.destroy', $status->id) }}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <tr>

        <td>
            {{ $new_status->name }}
        </td>
        <td class="text-right">

            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                data-href="{{ route('orders.destroy', $new_status->id) }}" title="{{ translate('Delete') }}">
                <i class="las la-edit"></i>
            </a>

            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                data-href="{{ route('orders.destroy', $new_status->id) }}" title="{{ translate('Delete') }}">
                <i class="las la-trash"></i>
            </a>
        </td>
    </tr>
@endif
