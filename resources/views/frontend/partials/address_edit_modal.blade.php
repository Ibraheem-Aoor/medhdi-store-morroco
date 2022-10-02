<form class="form-default" role="form" action="{{ route('addresses.update', $address_data->id) }}" method="POST">
    @csrf
    <div class="p-3">

        {{-- <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Country')}}</label>
            </div>
            <div class="col-md-10">
                <div class="mb-3">
                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country')}}" name="country_id" id="edit_country" required>
                        <option value="">{{ translate('Select your country') }}</option>
                        @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
                        <option value="{{ $country->id }}" @if ($address_data->country_id == $country->id) selected @endif>
                            {{ $country->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Name') }}</label>
            </div>
            <div class="col-md-10">
                <div class="mb-3">
                    <input type="text" required class="form-control" name="name" value="{{ $address_data->name }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('City') }}</label>
            </div>
            @php
                $cities = \App\Models\City::where('country_id', 20)->get();
            @endphp
            <div class="col-md-10">
                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city_id" required>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" @if ($city->id == $address_data->city_id) selected @endif>
                            {{ $city->getTranslation('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Address') }}</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control mb-3" placeholder="{{ translate('Your Address') }}" rows="2" name="address"
                    required>{{ $address_data->address }}</textarea>
            </div>
        </div>

        @if (get_setting('google_map') == 1)
            <div class="row">
                <input id="edit_searchInput" class="controls" type="text" placeholder="Enter a location">
                <div id="edit_map"></div>
                <ul id="geoData">
                    <li style="display: none;">Full Address: <span id="location"></span></li>
                    <li style="display: none;">Latitude: <span id="lat"></span></li>
                    <li style="display: none;">Longitude: <span id="lon"></span></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-2" id="">
                    <label for="exampleInputuname">Longitude</label>
                </div>
                <div class="col-md-10" id="">
                    <input type="text" class="form-control mb-3" id="edit_longitude" name="longitude"
                        value="{{ $address_data->longitude }}" readonly="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2" id="">
                    <label for="exampleInputuname">Latitude</label>
                </div>
                <div class="col-md-10" id="">
                    <input type="text" class="form-control mb-3" id="edit_latitude" name="latitude"
                        value="{{ $address_data->latitude }}" readonly="">
                </div>
            </div>
        @endif

        {{-- <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Postal code')}}</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control mb-3" placeholder="{{ translate('Your Postal Code')}}" value="{{ $address_data->postal_code }}" name="postal_code" value="" required>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-2">
                <label>{{ translate('Phone') }}</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control mb-3" placeholder="" value="{{ $address_data->phone }}"
                    name="phone" value="" required>
            </div>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
        </div>
    </div>
</form>
