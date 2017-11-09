<?php
namespace App;

use App\Repositories\CartRepository;

class SessionCart
{

    private $cart_name='cart';

    public function getCart()
    {
        return session($this->cart_name);

    }
    public function getCartCount()
    {

        return count(session($this->cart_name));


    }
    public function addToCart(array $save_data)
    {
        $cart_data=array();
        $product_id    = $save_data['product_id'];
        $product_name  = $save_data['name'];
        $product_price = $save_data['price'];
        $product_qty   = $save_data['quantity'];

        if(!isset($product_id ) OR $product_id== ''){
            return FALSE;
        }
        else
        {
            if(!isset($product_id, $product_price, $product_qty)){
                return FALSE;
            }
            else
            {



                if($product_qty == 0){
                    return FALSE;
                }

                $cart_data['quantity'] = $product_qty;


                // get quantity if it's already there and add it on
                if(session()->has('cart.'.$product_id))
                {
                $old_qty = session()->get('cart.'.$product_id.'.quantity');

                }
                else
                {
                $old_qty=0;
                }

                $cart_data['name']  = $product_name;
                $cart_data['product_id']  = $product_id;
                $cart_data['quantity'] += $old_qty;
                $cart_data['price'] = $product_price;
                $cart_data['total_price'] = $product_price*$cart_data['quantity'];

                if(session()->has($this->cart_name))
                {
                    if(session()->has($this->cart_name.'.'.$product_id))
                    {
                       session()->forget($this->cart_name.'.'.$product_id);
                       session()->put($this->cart_name.'.'.$product_id,$cart_data);
                    }
                    else
                    {
                        session()->put($this->cart_name.'.'.$product_id,$cart_data);
                    }

                }else{
                    session()->put($this->cart_name.'.'.$product_id,$cart_data);
                }
                return true;
            }
        }

    }

    public function updateCartQuantity(int $product_id,int $quantity)
    {
        $product_id=$product_id;
        $quantity=$quantity;

        $cart_data=$this->getCart();

        $cart_data[$product_id]['quantity']=$quantity;
        $cart_data[$product_id]['total_price']=$quantity*$cart_data[$product_id]['price'];
        session()->put($this->cart_name,$cart_data);
        $return_data=array('product_id'=>(int)$product_id,'total_price'=>$cart_data[$product_id]['total_price']);

        return $this->getCartProductTotal(  $product_id,$quantity);

    }
    public function updateCartAfterLogin()
    {

    }
    public function removeProduct($product_id)
    {
        //print_r(session()->get($this->cart_name.".".$product_id));
        session()->forget($this->cart_name.".".$product_id);

    }
    public function getCartProductTotal(int $product_id,int $quantity)
    {
        $cart_data=$this->getCart();
        $return_data[]=array('product_id'=>(int)$product_id,'total_price'=>$quantity*$cart_data[$product_id]['price']);
        return $return_data;

    }
    public function getCartTotal()
    {
        $cart_data=$this->getCart();
        foreach($cart_data as $arr)
        {
            $result_data['product_id']=$arr['product_id'];
            $result_data['total_name']=$arr['total_name'];
        }
        return $result_data;

    }
    public function getCartForLogin($user_id)
    {
        $cart_data=$this->getCart();
        foreach($cart_data as $arr)
        {
            $result_data['product_id']=$arr['product_id'];
            $result_data['quantity']=$arr['quantity'];
            $result_data['customer_id']=$user_id;
        }
        return $result_data;
    }



}

?>