<?php
namespace App\Http\Controllers\Admin\Product;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\ProductsImport;
use App\Models\ProductsExport;
use PDF;
use Excel;
use Auth;
use App\Http\Controllers\Controller;

class ProductBulkUploadController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            if(Auth::user()->shop->verification_status){
                return view('seller.product_bulk_upload.index');
            }
            else{
                flash('Your shop is not verified yet!')->warning();
                return back();
            }
        }
        elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('admin.product.bulk_upload.index');
        }
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.csv');
    }

    public function pdf_download_category()
    {
        $categories = Category::all();

        return PDF::loadview('admin.downloads.category',[
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadview('admin.downloads.brand',[
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type','seller')->get();

        return PDF::loadview('admin.downloads.user',[
            'users' => $users,
        ], [], [])->download('user.pdf');

    }

    public function bulk_upload(Request $request)
    {
        if($request->hasFile('bulk_file')){
            $import = new ProductsImport;
            Excel::import($import, request()->file('bulk_file'));
        }

        return back();
    }

}
