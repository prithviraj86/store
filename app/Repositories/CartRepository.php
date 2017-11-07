<?php
namespace App\Repositories;

use App\Cart;
use App\SessionCart;
use Illuminate\Http\Request;

class CartRepository
{

    private $cart_model;
    private $cart_session;
    private $product_id;
    private $product_price;
    private $product_qty;

    public function __construct(Cart $cart,SessionCart $sessionCart)
    {
        $this->cart_model=$cart;
        $this->cart_session=$sessionCart;
    }
    public function setProductId($id)
    {
        $this->product_id=$id;
    }
    public function getProductid()
    {
        return $this->product_id;
    }
    public function setProductPrice($price)
    {
        $this->product_price=$price;
    }
    public function getProductPrice()
    {
        return $this->product_price;
    }
    public function setProductQuantity($quantity)
    {
        $this->product_qty=$quantity;
    }

    public function getProductQuantity()
    {
        return $this->product_qty;
    }

    public function getData()
    {
        if(isset(auth()->user()->id) and auth()->user()->id!='')
        {
            return $this->cart_model->getCart();
        }
        else
        {
            return $this->cart_session->getCart();
        }

    }
    public function addToCart(Request $request)
    {
        //session()->forget('cart');die;
        if(isset(auth()->user()->id) and auth()->user()->id!='')
        {
            $get_product_data=$this->cart_model->getCartProductById($request->pid);
            //print_r($get_product_data->id);die;
            if(isset($get_product_data->id) and $get_product_data->id!='')
            {
                //echo "Product Exiasted";die;
                $newoty=$get_product_data->quantity+$request->quantity;
                //echo $newoty;die;
                $this->cart_model->product_id=$request->pid;
                $this->cart_model->quanitty=$newoty;
                return $this->cart_model->updateCartQty($this->cart_model);
            }
            else
            {
                   $this->cart_model->product_id=$request->pid;
                   if(isset($request->quantity)and $request->quantity!='')
                   {
                   $this->cart_model->quantity=$request->quantity;
                   }
                   else
                   {
                       return false;
                   }
                   $this->cart_model->customer_id=auth()->user()->id;
                    return $this->cart_model->addToCart($this->cart_model);
            }


        }
        else
        {
            $this->setProductId($request->pid);
            $this->setProductQuantity($request->quantity);
            $this->setProductPrice($request->price);
            //dd($this);
            //$this->cart_session->
           return $this->cart_session->addToCart($this);
        }

        //print_r(session()->get('cart')) ;
    }
    public function removeFromCart()
    {

    }


}
