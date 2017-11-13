<?php
namespace App\Libraries;

use App\Cart;
use App\SessionCart;
use Illuminate\Http\Request;
use Mockery\Exception;


class CartLib
{
    private $cart_model;
    private $cart_session;
    private $user_id;
    private $product_id;


    public function __construct(Cart $cart,SessionCart $sessionCart)
    {
        $this->cart_model=$cart;
        $this->cart_session=$sessionCart;

    }
    public function setUserId($uid)
    {

        $this->user_id=$uid;
        $this->cart_model->setUserId($uid);

    }

    public function getData()
    {
        if(isset($this->user_id) and $this->user_id!='')
        {
            return $this->cart_model->get() ;
        }
        else
        {
            return $this->cart_session->get();
        }

    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|integer',
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        //$this->validate();
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->updatec($request->product_id,$request->quantity);

        }
        else
        {

            $save_data=array(
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'price'=>$request->price,
                'name'=>$request->name
            );
            return $this->cart_session->addToCart($save_data);
        }

    }
    public function update(Request $request)
    {

        $request->validate([
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        $product_id=$request->product_id;
        $quantity=$request->quantity;
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->updateQuantity($product_id,$quantity);
        }
        else
        {
            return $this->cart_session->updateQuantity($product_id,$quantity);
        }
    }
    public function removeProduct(Request $request)
    {
        if(isset($this->user_id) and $this->user_id!='')
        {

            $result= $this->cart_model->deletec($request->product_id);
        }
        else
        {
            $result= $this->cart_session->removeProduct($request->product_id);
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
    public  function emptySession()
    {
        return $this->cart_session->emptyCart();
    }
    public function updateOnlogin()
    {
        if(isset($this->user_id) and $this->user_id!='')
        {
            $cart_data=$this->cart_session->getData($this->user_id);
            foreach ($cart_data as $value)
            {
                $value=(object)$value;


                $this->cart_model->updatec($value->product_id,$value->quantity);

                $this->cart_session->emptyCart();


            }
            return redirect('/');
        }
        else
        {
            throw new Exception('Access Denied,Invalid Access');
        }

    }

}