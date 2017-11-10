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


    public function __construct(Cart $cart,SessionCart $sessionCart)
    {
        $this->cart_model=$cart;
        $this->cart_session=$sessionCart;

    }
    public function setUserId($uid)
    {

        $this->user_id=$uid;

    }


    public function getData()
    {
        if(setOrNotBlank($this->user_id))
        {
            return $this->cart_model->get($this->user_id) ;
        }
        else
        {
            return $this->cart_session->get();
        }

    }
    public function addToCart(Request $request)
    {
        //session()->forget('cart');die;

        if(setOrBlank($request->quantity))
        {

            return false;
        }
        //dd($request);die;
        if(setOrNotBlank($this->user_id))
        {





            $get_product_data=$this->cart_model->getProduct($request->pid,$this->user_id);
            //print_r($get_product_data->id);die;
            if(setOrNotBlank($get_product_data))
            {
                //echo "Product Exiasted";die;
                $newoty=$get_product_data->quantity+$request->quantity;
                //echo $newoty;die;
                $product_id=$request->pid;


                return $this->cart_model->updateQuantity($product_id,$newoty,$this->user_id);
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

//

           return $this->cart_session->addToCart($save_data);
        }

        //print_r(session()->get('cart')) ;
    }
    public function updateQuantity(Request $request)
    {
        ///This method is used for ajax quantity update
        if(setOrblank($request->quantity))
        {
            throw new Exception('Please select quatity');
        }
        else
        {
            $product_id=$request->product_id;
            $quantity=$request->quantity;
        }

        if(setOrNotBlank($this->user_id))
        {

            return $this->cart_model->updateQuantity($product_id,$quantity,$this->user_id);
        }
        else
        {
            return $this->cart_session->updateQuantity($product_id,$quantity);
        }



    }

    public function removeProduct(Request $request)
    {
        if(setOrNotBlank($this->user_id))
        {

            return $this->cart_model->deleteProduct($request->product_id,$this->user_id);
        }
        else
        {
            return $this->cart_session->removeProduct($request->product_id);
        }
    }


    public function updateCartOnLogin($user_id)
    {
        $cart_data=$this->cart_session->getData($user_id);
        foreach ($cart_data as $value)
        {
            $get_product_data=$this->cart_model->getProduct($value['product_id'],$user_id);

            if(setOrNotBlank($get_product_data->id))
            {

                $newoty=$get_product_data->quantity+$value['quantity'];
                return $this->cart_model->updateQuantity($value['product_id'],$newoty,$user_id);


            }
            else
            {
                $this->cart_model->product_id=$value['product_id'];
                $this->cart_model->quantity=$value['quantity'];
                $this->cart_model->customer_id=$this->user_id;
                $this->cart_model->save();
                $this->cart_session->emptyCart();
                return true;
            }

        }


    }



}
