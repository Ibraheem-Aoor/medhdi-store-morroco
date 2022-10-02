@extends('admin.layouts.app')
@section('title', translate('All Orders'))

@section('content')

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('All Order Status') }}</h5>
            </div>

            <!-- Change Status Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="sotre_status_form" action="{{ route('order-status.store') }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    {{ translate('Create New Order Status') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control" name="name"
                                    placeholder="{{ translate('Enter Status Name') }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="sotre_status_form" action="" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    {{ translate('Edit Status') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control" name="name"
                                    placeholder="{{ translate('Enter Status Name') }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <div class="col-lg-2">
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="button" data-toggle="modal" data-target="#exampleModal"
                        class="btn btn-primary mt-lg-0 mt-3">{{ translate('New') }}</button>
                </div>
            </div>
        </div>

        <div class="card-body" id="card_content">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th data-breakpoints="md">{{ translate('Status Name') }}</th>
                        <th class="text-right" width="15%">{{ translate('options') }}</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($statuses as $status)
                        <tr>

                            <td>
                                {{ $status->name }}
                            </td>
                            <td class="text-right">
                                    <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm" data-toggle="modal" data-target="#editModal"
                                        data-href="{{ route('order-status.update', $status->id) }}" data-name="{{$status->name}}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @if ($status->id != 1)


                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('order-status.destroy', $status->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $statuses->appends(request()->input())->links() }}
            </div>

        </div>
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

        $('#sotre_status_form').submit(function(e) {
            e.preventDefault();
            console.log('Submittedd');
            var form = $(this);
            var name_input = form.find('input[name="name"]');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#exampleModal').modal('hide');
                        AIZ.plugins.notify('success', response.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('error', response.message);
                    }
                },
                error: function(response) {
                    if (!response.status) {
                        $('#exampleModal').modal('hide');
                        AIZ.plugins.notify('error', response.message);
                    } else {
                        $('#exampleModal').modal('hide');
                        AIZ.plugins.notify('error', "{{ translate('Something Went Wrong') }}");
                    }

                }
            });
        });

        @if (Session::has('deleted'))
            AIZ.plugins.notify('success', "{{ Session::get('deleted') }}");
        @endif
        @if (Session::has('updated'))
            AIZ.plugins.notify('success', "{{ Session::get('updated') }}");
        @endif
        $('#editModal').on('show.bs.modal' ,  function(e){
            var src = e.relatedTarget;
            var url = src.getAttribute('data-href');
            var name = src.getAttribute('data-name');
            $(this).find('input[name="name"]').val(name);
            $(this).find('form').attr('action' , url);

        });
    </script>
@endsection
