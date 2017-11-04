<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        print_r($products);die;
        return view('index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(auth()->user()->is_admin != 1) return  redirect('/');
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product,Request $request)
    {
        if(auth()->user()->is_admin != 1) return  redirect('/');
        $this->validate(request(),[
            'name'=>'required',
            'price'=>'required|integer',
            'sprice'=>'required|integer',
            'quantity'=>'required|integer',
        ]);

        //$product=new Product();

        $product->name=request('name');
        $product->admin_id=auth()->user()->id;
        $product->addProduct($product);

//        $product->price=request('price');
//        $product->sprice=request('sprice');

        ;
        echo $product->id;die;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request)
    {
        $productData=$product->getProducyByid($request);

        return view('products.show',compact('productData'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
