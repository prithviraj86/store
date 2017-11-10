<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;


class CartController extends Controller
{
    private $repository;


    public function __construct(CartRepository $cartrepository)
    {

        $this->repository=$cartrepository;

        $this->middleware(function ($request, $next) {
            //echo Auth::id();die;
            $this->repository->setUserId(Auth::id());

            return $next($request);
        });

    }

    public function index()
    {
        //print_r(session()->get('cart'));die;
       /// $this->repository->updateCartOnLogin();
        return View::make('cart')->with('cartdata',$this->repository->getData());
    }


    public function store(Request $request)
    {


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


    public function update(Request $request)
    {
        //
        return $this->repository->updateQuantity($request);
    }


    public function destroy(Request $request)
    {

        //
        if($this->repository->removeProduct($request))
        {
            return redirect('/');
        }

    }
    public function emptySession()
    {
        if($this->repository->emptySession())
        {
            return redirect('/');
        }
    }

    public function setCart()
    {
        return view('setcart');
    }
    public function updateOnlogin()
    {
        if($this->repository->updateCartOnLogin())
        {
            return redirect('/');
        }
    }
}
