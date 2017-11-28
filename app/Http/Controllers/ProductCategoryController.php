<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Product;



class ProductCategoryController extends Controller
{
    //
    public function index()
    {

        $productdata=ProductCategory::with('product','product.productprice','product.productdetail')->get();

        //dd($productdata);
        return view('index',compact('productdata'));
    }

    public function productByCategory(Request $request)
    {
        $category=decrypt($request->id);
        $productdata=ProductCategory::with('product', 'product.productprice','product.productdetail')
            ->where('category_id','=', $category )->get();

        return view('index', compact('productdata','category'));

    }
}
