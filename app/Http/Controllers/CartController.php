<?php

namespace App\Http\Controllers;

use App\Libraries\CartLib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;




class CartController extends Controller
{

    private $cart_lib;




    public function __construct(CartLib $cartlib)
    {

        $this->cart_lib=$cartlib;


        $this->middleware(function ($request, $next) {
            //echo Auth::id();die;
            $this->user_id=Auth::id();
            $this->cart_lib->setUserId($this->user_id);

            return $next($request);
        });

    }

    public function index()
    {

        return View::make('cart')->with('cartdata',$this->cart_lib->getData());
    }


    public function store(Request $request)
    {

        $result=$this->cart_lib->addToCart($request);
        if($result)
        {
          return redirect('/cart');
        }
        else
        {
           return Redirect::back()->withErrors(['Product not added in cart']);
        }



    }


    public function update(Request $request)
    {
        //
        return $this->cart_lib->decreseQuantity($request);
    }


    public function destroy(Request $request)
    {

        //
        $result=$this->cart_lib->removeProduct($request);
        if($result)
        {
            return redirect('/cart');
        }
        else
        {
            return Redirect::back()->withErrors(['Product not removed from cart']);
        }

    }

    public function emptyCart()
    {
        $this->cart_lib->emptyCart();
    }

    //This function  is used ,when user login and say no to add current(without login) cart product in his cart
    public function emptySession()
    {
       $result= $this->cart_lib->emptySession();

        if($result)
        {
            return redirect('/');
        }
        else
        {
            return Redirect::back()->withErrors(['Cart not empty']);
        }
    }


    public function setCart()
    {
        return view('setcart');
    }

    //This function  is used ,when user login and say Yes to add current(without login) cart product in his cart
    public function updateOnlogin()
    {
        $result=$this->cart_lib->updateOnlogin();
        if($result)
        {
            return redirect('/');
        }
        else
        {
            return Redirect::back()->withErrors(['Cart not updated']);
        }

    }

}
