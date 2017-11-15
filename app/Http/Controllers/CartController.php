<?php

namespace App\Http\Controllers;

use App\Libraries\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;




class CartController extends Controller
{

    private $cart;




    public function __construct(Cart $cart)
    {

        $this->cart=$cart;


        $this->middleware(function ($request, $next) {
            //echo Auth::id();die;
            $this->user_id=Auth::id();
            $this->cart->setUserId($this->user_id);

            return $next($request);
        });

    }

    public function index()
    {

        return View::make('cart')->with('cartdata',$this->cart->getAll());
    }


    public function store(Request $request)
    {

        $result=$this->cart->add($request);
        if($result)
        {
          return redirect('/cart');
        }
        else
        {
           return Redirect::back()->withErrors(['Product not added in cart']);
        }



    }
    public function destroy(Request $request)
    {


        $result=$this->cart->remove($request);

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
        $this->cart->clear();
    }

    public function update(Request $request)
    {
        //
        return $this->cart->decreseQuantity($request);
    }






    //This function  is used ,when user login and say no to add current(without login) cart product in his cart
    public function emptySession()
    {
       $result= $this->cart->clearSession();

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
        $result=$this->cart->updateOnlogin();
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
