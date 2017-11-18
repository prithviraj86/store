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
    private $user;



    public function __construct()
    {

        $this->middleware(function ($request, $next) {

            $this->user=Auth::user();
            $storage=CartStorageFactory::getStorage($this->user);
            $this->cart=new Cart($storage);

            return $next($request);
        });


//


    }

    public function index()
    {

        return View::make('cart')->with('cartdata',$this->cart->getAll());
    }


    public function store(Request $request)
    {


      //  var_dump($request);die;
        $product=$this->isProduct($request->product_id);

        $result=$this->cart->add($product,$request->quantity);

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

        $product=$this->isProduct($request->product_id);
        $result=$this->cart->remove($product);

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

        $product=$this->isProduct($request->product_id);
        return $this->cart->decreseQuantity($product);
    }


    private function isProduct($id)
    {
        try
        {
            $product=new Product();
            return $product->findById($id);

        }
        catch (Exception $e)
        {
            throwException($e->getMessage());
        }
    }

    public function setCart()
    {
        return view('setcart');
    }
    public function updateOnlogin()
    {
        //dd($this->cart);
        $sessionData=session('cart');//This Wrong code it's temporary~
        foreach($sessionData as $value)
        {
            $product=$this->isProduct($value['product_id']);
            //echo $value['quantity'];die;

            $result=$this->cart->add($product,$value['quantity']);
        }

        if($result)
        {
            return redirect('/');
        }


    }

}
