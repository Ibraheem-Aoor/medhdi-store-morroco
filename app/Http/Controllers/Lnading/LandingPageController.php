<?php

namespace App\Http\Controllers\Lnading;

use App\Http\Controllers\Controller;
use App\Mail\DemoRequestMail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Validator;

class LandingPageController extends Controller
{
    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all() , [
                                    'email' => 'required|email' , 'name' => 'required|string'
                                    , 'contact_number' => 'required' , 'shop_type' => Rule::in(['Vendor' , 'Mulit Vendor'])
                                    ]
                                );
        if($validator->fails())
        {
            flash(translate('Please Enter Valid Informaion'))->error();
            return back();
        }

        $client = $request->all();

        Mail::to('support@apex.ps')->send(new DemoRequestMail($client));
        session()->flash('success' , 'success');
        return back();
    }
}
