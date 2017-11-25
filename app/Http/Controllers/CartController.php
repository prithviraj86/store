<?php

namespace App\Http\Controllers;

use App\Libraries\Cart;

use App\Libraries\CartStorageFactory;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Mockery\Exception;


class CartController extends Controller
{

    private $cart;


    public function __construct()
    {
        //parent::__construct();
        $this->middleware(function ($request, $next) {

            $user=Auth::user();
            $storage=CartStorageFactory::getStorage($user);
            $this->cart=new Cart($storage);

            return $next($request);
        });

    }

    public function index()
    {

        return View::make('cart')->with('cartdata',$this->cart->getAll());
    }


    public function store(Request $request)
    {



        $product=$this->cart->isProduct($request->product_id);

        $result=$this->cart->add($product,$request->quantity);
        // this condition is for web only
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

        $product=$this->cart->isProduct($request->product_id);

        $result=$this->cart->remove($product);
        // this condition is for web only
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

        $product=$this->cart->isProduct($request->product_id);

        return $this->cart->sub($product);
    }



//These two functions after this line will be changed but currently we used them in or web pages

    public function setCart()
    {
        return view('setcart');
    }
    public function updateOnlogin()
    {
        //dd($this->cart);
        $sessionData=session('cart');//This is a Wrong code and it is  temporary~
        foreach($sessionData as $value)
        {
            $product=$this->cart->isProduct($value['product_id']);
            //echo $value['quantity'];die;

            $result=$this->cart->add($product,$value['quantity']);
        }

        if($result)
        {
            return redirect('/');
        }


    }

}
