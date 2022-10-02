<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\City;
use App\Models\State;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Country;
use DB;

use function PHPUnit\Framework\isEmpty;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = new Address;
        if($request->has('customer_id')){
            $address->user_id   = $request->customer_id;
        }
        else{
            $address->user_id   = Auth::user()?->id;
        }
        $address->name =    $request->name;
        $address->address       = $request->address;
        $address->country_id    = $request->country_id;
        // $address->state_id      = $request->state_id;
        $address->city_id       = $request->city_id;
        $address->longitude     = $request->longitude;
        $address->latitude      = $request->latitude;
        // $address->postal_code   = $request->postal_code;
        $address->phone         = $request->phone;
        $address->save();
        return back()->with('address' , $address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //The primary country is SA
    public function edit($id)
    {
        $data['address_data'] = Address::findOrFail($id);
        // $country = Country::where('code' , 'SA')->first();
        // $data['states'] = State::where('status', 1)->where('country_id' , $country->id)->get();
        $data['cities'] = City::where('is_active', 1)->where('country_id', $data['address_data']->country_id)->get();
        $returnHTML = view('frontend.partials.address_edit_modal', $data)->render();
        return response()->json(array('data' => $data, 'html'=>$returnHTML));
//        return ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        $address->address       = $request->address;
        $address->country_id    = $request->country_id;
        // $address->state_id      = $request->state_id;
        $address->city_id       = $request->city_id;
        $address->longitude     = $request->longitude;
        $address->latitude      = $request->latitude;
        // $address->postal_code   = $request->postal_code;
        $address->phone         = $request->phone;
        $address->name         = $request->name;

        $address->save();

        flash(translate('Address info updated successfully'))->success();
        return back()->with('address' , $address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        if(!$address->set_default){
            $address->delete();
            return back();
        }
        flash(translate('Default address can not be deleted'))->warning();
        return back();
    }

    public function getStates(Request $request) {
        $states = State::where('status', 1)->where('country_id', $request->country_id)->get();
        $html = '<option value="">'.translate("Select State").'</option>';

        foreach ($states as $state) {
            $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }

        echo json_encode($html);
    }

    public function getCities(Request $request) {
        // $cities = City::where('status', 1)->where('state_id', $request->state_id)->get();
        $citiesChunks = City::whereCountryId($request->state_id)->get()->chunk(200,function($e){return $e;});
        $html = '<option value="">'.translate("Select City").'</option>';

        foreach ($citiesChunks as $chnk => $rows) {
            foreach($rows as $row){
                if(!$row->getTranslation('name'))
                    continue;
                $html .= '<option value="' . $row->id . '">' . $row->getTranslation('name') . '</option>';
            }
        }

        echo json_encode($html);
    }

    public function set_default($id){
        foreach (Auth::user()->addresses as $key => $address) {
            $address->set_default = 0;
            $address->save();
        }
        $address = Address::findOrFail($id);
        $address->set_default = 1;
        $address->save();

        return back();
    }

    /**
     * Show All user registerd addresses.
     */
    public function all_address()
    {
        return view('frontend.user.addresses');
    }


}