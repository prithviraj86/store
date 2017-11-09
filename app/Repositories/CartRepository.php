<?php
namespace App\Repositories;

use App\Cart;
use App\SessionCart;
use Illuminate\Http\Request;
use Mockery\Exception;

class CartRepository
{

    private $cart_model;
    private $cart_session;
    private $user_id;
    private $product_id;
    private $product_name;
    private $product_price;
    private $product_qty;

    public function __construct(Cart $cart,SessionCart $sessionCart)
    {
        $this->cart_model=$cart;
        $this->cart_session=$sessionCart;

        if(isset(auth()->user()->id))
        {
            $this->user_id=auth()->user()->id;
        }
        else
        {
            $this->user_id=null;
        }

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
    public function setProductName($name)
    {
        $this->product_name=$name;
    }
    public function getProductName()
    {
        return $this->product_name;
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
        if(isset($this->user_id) and $this->user_id!='')
        {
            return $this->cart_model->getCart() ;
        }
        else
        {
            return $this->cart_session->getCart();
        }

    }
    public function addToCart(Request $request)
    {
        //session()->forget('cart');die;
        if(isset($this->user_id) and $this->user_id!='')
        {




            $get_product_data=$this->cart_model->getCartProductById($request->pid);
            //print_r($get_product_data->id);die;
            if(isset($get_product_data->id) and $get_product_data->id!='')
            {
                //echo "Product Exiasted";die;
                $newoty=$get_product_data->quantity+$request->quantity;
                //echo $newoty;die;
                $this->setProductId($request->pid);
                $this->setProductQuantity($newoty);

                return $this->cart_model->updateCartQty($this);
            }
            else
            {
                $this->cart_model->product_id=$request->pid;
                $this->cart_model->quantity=$request->quantity;
                $this->cart_model->customer_id=$this->user_id;
                return $this->cart_model->save();
            }


        }
        else
        {
            $save_data=array(
                'product_id'=>$request->pid,
                'quantity'=>$request->quantity,
                'price'=>$request->price,
                'name'=>$request->name
            );

//            $this->setProductQuantity($request->quantity);
//            $this->setProductPrice($request->price);
//            $this->setProductName($request->name);

           return $this->cart_session->addToCart($save_data);
        }

        //print_r(session()->get('cart')) ;
    }
    public function updateQuantity(Request $request)
    {

        if($request->quantity=='')
        {
            throw new Exception('Please select quatity');
        }
        else
        {
            $product_id=$request->product_id;
            $quantity=$request->quantity;
        }

        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->updateCartQty($product_id,$quantity);
        }
        else
        {
            return $this->cart_session->updateCartQuantity($product_id,$quantity);
        }



    }

    public function removeProductFromCart(Request $request)
    {
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->cart_model->deleteProduct($request->product_id);
        }
        else
        {
            return $this->cart_session->removeProduct($request->product_id);
        }
    }
    public function updateCartOnLogin()
    {
        $cart_data=$this->cart_session->getCartForLogin($this->user_id);
        foreach ($cart_data as $data)
        {

        }
    }


}
