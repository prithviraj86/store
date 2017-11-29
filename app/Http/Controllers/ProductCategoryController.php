<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Repositories\ProductCategory\ProductCategoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;



class ProductCategoryController extends Controller
{
    private $productcategory;

    //
    public function __construct(ProductCategoryInterface $productcategory)
    {
        $this->productcategory=$productcategory;
    }


    public function index()
    {

        $productdata=$this->productcategory->all();

        //dd($productdata);
        return view('index',compact('productdata'));
    }

    public function productByCategory(Request $request)
    {
        $category=decrypt($request->id);
        $productdata=$this->productcategory->productByCategory($request);
        //dd($productdata);
        return view('index', compact('productdata','category'));

    }
}
