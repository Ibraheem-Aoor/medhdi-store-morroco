<?php
namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\CustomerProduct;
use App\Models\CustomerProductTranslation;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\SubSubCategory;
use Auth;
use ImageOptimizer;
use Illuminate\Support\Str;
use App\Utility\CategoryUtility;
use App\Http\Controllers\Controller;
use App\Models\Product;

class CustomerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = CustomerProduct::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.customer.products', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        if(Auth::user()->user_type == "customer" && Auth::user()->remaining_uploads > 0){
            return view('frontend.user.customer.product_upload', compact('categories'));
        }
        elseif (Auth::user()->user_type == "seller" && Auth::user()->remaining_uploads > 0) {
            return view('frontend.user.customer.product_upload', compact('categories'));
        }
        else{
            flash(translate('Your classified product upload limit has been reached. Please buy a package.'))->error();
            return redirect()->route('customer_packages_list_show');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_product                       = new CustomerProduct;
        $customer_product->name                 = $request->name;
        $customer_product->added_by             = $request->added_by;
        $customer_product->user_id              = Auth::user()->id;
        $customer_product->category_id          = $request->category_id;
        $customer_product->brand_id             = $request->brand_id;
        $customer_product->conditon             = $request->conditon;
        $customer_product->location             = $request->location;
        $customer_product->photos               = $request->photos;
        $customer_product->thumbnail_img        = $request->thumbnail_img;
        $customer_product->unit                 = $request->unit;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }

        $customer_product->tags                 = implode(',', $tags);
        $customer_product->description          = $request->description;
        $customer_product->video_provider       = $request->video_provider;
        $customer_product->video_link           = $request->video_link;
        $customer_product->unit_price           = $request->unit_price;
        $customer_product->meta_title           = $request->meta_title;
        $customer_product->meta_description     = $request->meta_description;
        $customer_product->meta_img             = $request->meta_img;
        $customer_product->pdf                  = $request->pdf;
        $customer_product->slug                 = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5));
        if($customer_product->save()){
            $user = Auth::user();
            $user->remaining_uploads -= 1;
            $user->save();

            $customer_product_translation               = CustomerProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'customer_product_id' => $customer_product->id]);
            $customer_product_translation->name         = $request->name;
            $customer_product_translation->unit         = $request->unit;
            $customer_product_translation->description  = $request->description;
            $customer_product_translation->save();

            flash(translate('Product has been inserted successfully'))->success();
            return redirect()->route('customer_products.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
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
    public function edit(Request $request, $id)
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        $product    = CustomerProduct::find($id);
        $lang       = $request->lang;
        return view('frontend.user.customer.product_edit', compact('categories', 'product','lang'));
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
        $customer_product                       = CustomerProduct::find($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $customer_product->name             = $request->name;
            $customer_product->unit             = $request->unit;
            $customer_product->description      = $request->description;
        }
        $customer_product->status               = '1';
        $customer_product->user_id              = Auth::user()->id;
        $customer_product->category_id          = $request->category_id;
        $customer_product->brand_id             = $request->brand_id;
        $customer_product->conditon             = $request->conditon;
        $customer_product->location             = $request->location;
        $customer_product->photos               = $request->photos;
        $customer_product->thumbnail_img        = $request->thumbnail_img;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }

        $customer_product->tags                 = implode(',', $tags);
        $customer_product->video_provider       = $request->video_provider;
        $customer_product->video_link           = $request->video_link;
        $customer_product->unit_price           = $request->unit_price;
        $customer_product->meta_title           = $request->meta_title;
        $customer_product->meta_description     = $request->meta_description;
        $customer_product->meta_img             = $request->meta_img;
        $customer_product->pdf                  = $request->pdf;
        $customer_product->slug                 = strtolower($request->slug);
        if($customer_product->save()){

            $customer_product_translation               = CustomerProductTranslation::firstOrNew(['lang' => $request->lang, 'customer_product_id' => $customer_product->id]);
            $customer_product_translation->name         = $request->name;
            $customer_product_translation->unit         = $request->unit;
            $customer_product_translation->description  = $request->description;
            $customer_product_translation->save();

            flash(translate('Product has been inserted successfully'))->success();
            return back();
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = CustomerProduct::findOrFail($id);

        foreach ($product->customer_product_translations as $key => $customer_product_translations) {
            $customer_product_translations->delete();
        }

        if (CustomerProduct::destroy($id)) {
            if(Auth::user()->user_type == "customer" || Auth::user()->user_type == "seller"){
                flash(translate('Product has been deleted successfully'))->success();
                return redirect()->route('customer_products.index');
            }
            else {
                return back();
            }
        }
    }

    public function updateStatus(Request $request)
    {
        $product = CustomerProduct::findOrFail($request->id);
        $product->status = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = CustomerProduct::findOrFail($request->id);
        $product->published = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function customer_products_listing(Request $request)
    {
        return $this->search($request);
    }

    public function customer_product($slug)
    {
        $customer_product  = CustomerProduct::where('slug', $slug)->first();
        if($customer_product!=null){
            return view('frontend.customer_product_details', compact('customer_product'));
        }
        abort(404);
    }

    public function search(Request $request)
    {
        // $query = $request->q;
        $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $sort_by = $request->sort_by;
        $condition = $request->condition;

        $conditions = ['published' => 1, 'status' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $customer_products = CustomerProduct::where($conditions);

        if($category_id != null){
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $customer_products = $customer_products->whereIn('category_id', $category_ids);
        }

        // if($query != null){
        //     $customer_products = $customer_products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
        // }

        if($sort_by != null){
            switch ($sort_by) {
                case '1':
                    $customer_products->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $customer_products->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $customer_products->orderBy('unit_price', 'asc');
                    break;
                case '4':
                    $customer_products->orderBy('unit_price', 'desc');
                    break;
                case '5':
                    $customer_products->where('conditon', 'new');
                    break;
                case '6':
                    $customer_products->where('conditon', 'used');
                    break;
                default:
                    // code...
                    break;
            }
        }

        if($condition != null){
            $customer_products->where('conditon', $condition);
        }

        $customer_products = $customer_products->paginate(12)->appends(request()->query());

        return view('frontend.customer_product_listing', compact('customer_products', 'category_id', 'brand_id', 'sort_by', 'condition'));
    }

    public function updateQty(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $tax = 0;
        $max_limit = 0;

        if($request->has('color')){
            $str = $request['color'];
        }

        if(json_decode($product->choice_options) != null){
            foreach (json_decode($product->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

        $product_stock = $product->stocks->where('variant', $str)->first();

        $price = $product_stock->price;


        if($product->wholesale_product){
            $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $request->quantity)->where('max_qty', '>=', $request->quantity)->first();
            if($wholesalePrice){
                $price = $wholesalePrice->price;
            }
        }

        $quantity = $product_stock->qty;
        $max_limit = $product_stock->qty;

        if($quantity >= 1 && $product->min_qty <= $quantity){
            $in_stock = 1;
        }else{
            $in_stock = 0;
        }

        //Product Stock Visibility
        if($product->stock_visibility_state == 'text') {
            if($quantity >= 1 && $product->min_qty < $quantity){
                $quantity = translate('In Stock');
            }else{
                $quantity = translate('Out Of Stock');
            }
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        // taxes
        foreach ($product->taxes as $product_tax) {
            if($product_tax->tax_type == 'percent'){
                $tax += ($price * $product_tax->tax) / 100;
            }
            elseif($product_tax->tax_type == 'amount'){
                $tax += $product_tax->tax;
            }
        }

        $price += $tax;

        return single_price($price*$request->quantity);
    }


    public function updateQty_2(Request $request)
    {
        $product = Product::find($request->id);
        return single_price($product->unit_price * $request->quantity);
    }
}
