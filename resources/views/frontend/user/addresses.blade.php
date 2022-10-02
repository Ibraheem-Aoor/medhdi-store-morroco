@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Manage Addresses') }}</h1>
            </div>
        </div>

        <!-- Address -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Address') }}</h5>
                <button class="btn btn-outline-primary btn-sm " type="button" onclick="add_new_address()">
                    {{ translate('Add New Address') }}
                </button>
                {{-- <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                    <i class="la la-plus la-2x"></i>
                    <div class="alpha-7">{{ translate('Add New Address') }}</div>
                </div>
            </div> --}}

            </div>
            <div class="card-body">
                <div class="row gutters-10">
                    @forelse (Auth::user()->addresses as $key => $address)
                        <div class="col-lg-6">
                            <div class="border p-3 pr-5 rounded mb-3 position-relative address-list">
                                <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                                    <span class="ml-2">{{ optional($address->country)->getTranslation('name') }}</span>
                                </div>
                                <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('City') }}:</span>
                                    <span class="ml-2">{{ optional($address->city)->getTranslation('name') }}</span>
                                </div>
                                <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                                    <span class="ml-2">{{ $address->address }}</span>
                                </div>
                                <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                                    <span class="ml-2">{{ $address->phone }}</span>
                                </div>
                                {{-- <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                                    <span class="ml-2">{{ $address->postal_code }}</span>
                                </div> --}}

                                {{-- <div class="address-list-item">
                                    <span class="w-50 fw-600">{{ translate('State') }}:</span>
                                    <span class="ml-2">{{ optional($address->state)->name }}</span>
                                </div> --}}

                                @if ($address->set_default)
                                    <div class="position-absolute right-0 bottom-0 pr-2 pb-3">
                                        <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                                    </div>
                                @endif
                                <div class="dropdown dropdown-address">
                                    <button class="btn bg-gray px-2" type="button" data-toggle="dropdown"
                                        style="font-size:22px;">
                                        <i class="la la-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" onclick="edit_address('{{ $address->id }}')">
                                            {{ translate('Edit') }}
                                        </a>
                                        @if (!$address->set_default)
                                            <a class="dropdown-item"
                                                href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                        @endif
                                        <a class="dropdown-item"
                                            href="{{ route('addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="text-center bg-white p-4 rounded shadow">
                                <img class="mw-100 h-200px" src="{{ asset('assets/img/nothing.svg') }}" alt="Image">
                                <h5 class="mb-0 h5 mt-3">{{ translate("There isn't any address yet!") }}</h5>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <br>




    <!-- Change Email -->
@endsection

@section('modal')
    @include('frontend.partials.address_modal')
@endsection

@section('script')
    <script type="text/javascript">
        $('.new-email-verification').on('click', function() {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var email = $("input[name=email]").val();

            $.post('{{ route('user.new.verify') }}', {
                _token: '{{ csrf_token() }}',
                email: email
            }, function(data) {
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if (data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if (data.status == 1)
                    AIZ.plugins.notify('success', data.message);
                else
                    AIZ.plugins.notify('danger', data.message);
            });
        });
    </script>

    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
