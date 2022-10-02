<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function allCustomers(Request $request)
    {
        $sort_search = null;
        $users = User::whereHas('orders' , function($q){
            $q->where('seller_id' , Auth::id());
        });
        if ($request->has('search')){
            $sort_search = $request->search;
            $users->where(function ($q) use ($sort_search){
                $q->where('name', 'like', '%'.$sort_search.'%')->orWhere('phone', 'like', '%'.$sort_search.'%');
            });
        }

        $users = $users->paginate(15);
        
        return view('seller.customers.index', compact('users', 'sort_search'));

    }
}
