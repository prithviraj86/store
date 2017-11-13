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

            return $this->cart_model->addOrUpdate($request->product_id);

        }
        else
        {

            $save_data=array(
                'product_id'=>$request->product_id,
                'price'=>$request->price,
                'name'=>$request->name
            );
            return $this->cart_session->addToCart($save_data);
        }

    }
    public function decreseQuantity(Request $request)
    {

        $request->validate([
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        $product_id=$request->product_id;
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->decreseQuntity($product_id);
        }
        else
        {
            return $this->cart_session->decreseQuantity($product_id);
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


                $this->cart_model->addOrUpdate($value->product_id);

                $this->cart_session->emptyCart();


            }
            return true;
        }
        else
        {
            return false;
        }

    }

}