<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Repositories\ProductCategory\ProductCategoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;



class ProductCategoryController extends Controller
{
    private $productCategory;

    //
    public function __construct(ProductCategoryInterface $productCategory)
    {
        $this->productCategory=$productCategory;
    }


    public function index()
    {

        $productData=$this->productCategory->all();

        //dd($productdata);
        return view('index',compact('productData'));
    }

    public function productByCategory(Request $request)
    {
        $category=decrypt($request->id);
        $productData=$this->productCategory->productByCategory($request);
        //dd($productdata);
        return view('index', compact('productData','category'));

    }
}
