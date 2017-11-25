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
        return view('products.show',compact('productdata'));
    }
}
