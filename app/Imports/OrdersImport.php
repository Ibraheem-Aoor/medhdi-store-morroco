<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Throwable;

class OrdersImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $orders)
    {
        $orders = $orders->slice(1);
        try{
            $this->getProducts($orders);
            session()->flash('success' , translate('Import Done Successfully'));
            return back();
        }catch(Throwable $ex){
            if($ex instanceof ModelNotFoundException){
                session()->flash('error' , translate('Product Not Found'));
            }else{
                session()->flash('error' , translate('Something Went Wrong'));
            }
            return back();
        }
    }


    /**
         * First element of each row represents the orders
         * Products Are splited By ";"
         * each product splited of his quantity using ","
         */
    public function getProducts($orders)
    {
        foreach($orders as $order)
        {
            $total_price = 0;
            $total_qty = 0;
            $product_row = explode(';'  , $order[0]);
            $shipping_address = json_encode( [
                'city' => @$order[1],
                'address' => @$order[2],
                'name' => @$order[3],
                'phone' => @$order[4],
            ]);
            $status_id = OrderStatus::whereName(trim(@$order[5]))->first()?->id;
            foreach($product_row as $product_quantity_string)
            {
                if($product_quantity_string)
                {
                    $product_quantity_arry =  explode(',' , $product_quantity_string);
                    $product_name =  @$product_quantity_arry[0];
                    $total_qty += @$product_quantity_arry[1];
                    $product_id = ProductTranslation::whereLang('sa')->where('name' , trim($product_name))->first()?->id;
                    $product = Product::find($product_id);
                    $total_price  +=  $product->unit_price;
                }

            }
            $db_order = new Order();
            $db_order->code  = date('Ymd-His') . rand(10, 99);
            $db_order->shipping_address  = $shipping_address;
            $db_order->grand_total =  $total_price  * $total_qty;
            $db_order->date  = strtotime('now');
            $db_order->status_id = $status_id;
            $db_order->save();
            $total_price = 0;
            $total_qty = 0;
            foreach($product_row as $product_quantity_string)
            {
                if($product_quantity_string)
                {
                    $product_quantity_arry =  explode(',' , $product_quantity_string);
                    $product_name =  @$product_quantity_arry[0];
                    $product_quantity = @$product_quantity_arry[1];
                    $product_id = ProductTranslation::whereLang('sa')->where('name' , trim($product_name))->first()?->id;
                    $product = Product::findOrFail($product_id);
                    $detailedOrder = new OrderDetail();
                    $detailedOrder->order_id = $db_order->id;
                    $detailedOrder->product_id =   $product->id;
                    $detailedOrder->price = $product->unit_price;
                    $detailedOrder->quantity = $product_quantity;
                    $detailedOrder->save();
                }
            }

            $db_order->grand_total = $db_order->orderDetails->sum('price') * $db_order->orderDetails->sum('quantity');
            $db_order->save();


        }//End

    }
}
