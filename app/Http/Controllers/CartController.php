<?php

namespace App\Http\Controllers;

use App\Cart;
use App\SessionCart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Mockery\Exception;



class CartController extends Controller
{
    private $cart_model;
    private $cart_session;
    private $user_id;
    private $product_id;



    public function __construct(Cart $cart,SessionCart $sessionCart)
    {

        $this->cart_model=$cart;
        $this->cart_session=$sessionCart;

        $this->middleware(function ($request, $next) {
            //echo Auth::id();die;
            $this->user_id=Auth::id();
            $this->cart_model->setUserId(Auth::id());

            return $next($request);
        });

    }

    public function index()
    {
        if(isset($this->user_id) and $this->user_id!='')
        {
            $cart_data= $this->cart_model->get() ;
        }
        else
        {
            $cart_data=$this->cart_session->get();
        }
        return View::make('cart')->with('cartdata',$cart_data);
    }


    public function store(Request $request)
    {

        $this->validate(request(),[
            'name'=>'required',
            'price'=>'required|integer',
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        //$this->validate();
        if(isset($this->user_id) and $this->user_id!='')
        {


            $get_product_data=$this->cart_model->getProduct($request->product_id);
            //print_r($get_product_data->id);die;
            if(isset($get_product_data->id) and $get_product_data->id!='')
            {
                //echo "Product Exiasted";die;
                $newoty=$get_product_data->quantity+$request->quantity;
                //echo $newoty;die;
                $product_id=$request->product_id;


                $result= $this->cart_model->updatec($product_id,$newoty);
            }
            else
            {

                $result= $this->save($request);
            }


        }
        else
        {

            $save_data=array(
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'price'=>$request->price,
                'name'=>$request->name
            );

//

            $result= $this->cart_session->addToCart($save_data);
        }
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
        $this->validate(request(),[
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        $product_id=$request->product_id;
        $quantity=$request->quantity;
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->updatec($product_id,$quantity);
        }
        else
        {
            return $this->cart_session->updateQuantity($product_id,$quantity);
        }
    }


    public function destroy(Request $request)
    {

        //
        if(isset($this->user_id) and $this->user_id!='')
        {

            $result= $this->cart_model->deletec($request->product_id);
        }
        else
        {
            $result= $this->cart_session->removeProduct($request->product_id);
        }
        if($result)
        {
            return redirect('/');
        }

    }

    public function emptyCart()
    {
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->emptyCart();
        }
        else
        {
            return $this->cart_session->emptyCart();
        }
    }

    public function emptySession()
    {
        if($this->cart_session->emptySession())
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
        if(isset($this->user_id) and $this->user_id!='')
        {
            $cart_data=$this->cart_session->getData($this->user_id);
            foreach ($cart_data as $value)
            {
                $value=(object)$value;

                $get_product_data=$this->cart_model->getProduct($value->product_id);
                //echo
                //print_r($get_product_data);die;
                if(isset($get_product_data->id))
                {

                    $newoty=$get_product_data->quantity+$value->quantity;
                    //print_r($value);die;
                    $this->cart_model->updatec($value->product_id,$newoty);


                }
                else
                {
                    //print_r($value);die;
                    $this->save($value);
                    $this->cart_session->emptyCart();

                }

            }
            return redirect('/');
        }
        else
        {
            throw new Exception('Access Denied,Invalid Access');
        }

    }
    public function save($item)
    {
        $this->cart_model->product_id=$item->product_id;
        if(isset($item->quantity) and $item->quantity!='')
            $this->cart_model->quantity=$item->quantity;
        else
            $this->cart_model->incrementing('quntity');
        $this->cart_model->customer_id=$this->user_id;
        return $this->cart_model->save();

    }
}
