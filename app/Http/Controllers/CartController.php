<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    private $repository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(CartRepository $cartrepository)
    {
        $this->repository=$cartrepository;
    }

    public function index()
    {
        //
        $cartdata=$this->repository->getData();
        return view('cart',compact('cartdata'));
        //return View::make('cart')->with('cartdata',$this->repository->getData());
    }


    public function store(Request $request)
    {
        //
        //echo "Hello";die;
            $result=$this->repository->addToCart($request);
            //print_r($result);die;
           if($result)
           {
              return redirect('/cart');
           }
           else
           {
               return Redirect::back()->withErrors(['msg', 'Product not added in cart']);
           }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
