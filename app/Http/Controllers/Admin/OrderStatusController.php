<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $statuses;

    public function __construct()
    {
        $this->statuses = OrderStatus::paginate(15);
    }
    public function index()
    {
        $data['statuses'] = $this->statuses;
        return view('admin.sales.order_status.index' , $data);
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
        $data = $request->toArray();
        $validate  = FacadesValidator::make($data , ['name' => 'required|string']);
        if($validate->fails())
            return response()->json(['status' => false , 'message' => translate('Name Required')] , 400);
        OrderStatus::create($data);
        return response()->json(['status' => true , 'message' => translate('Created Successfully') ]  , 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        OrderStatus::whereId($id)->delete();
        return back()->with('deleted' , 'Deleted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->toArray();
        dd($data);
        $validate  = FacadesValidator::make($data , ['status_id' => 'required|string']);
        OrderStatus::find($id)->update($data);
        return back()->with('updated' , translate('Updated Successfully'));
    }

    public function changeStatus(Request $request)
    {
        dd($request);
        $request->validate(['status_id' => 'required']);
        $order = Order::find($request->order_id);
        $order->status_id = $request->status_id;
        $order->save();
        return redirect()->back()->with('updated' , 'Updated Successfully');
    }
}
