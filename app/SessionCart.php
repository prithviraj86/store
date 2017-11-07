<?php
namespace App;

use App\Repositories\CartRepository;

class SessionCart
{
    protected $cart;
    protected $cart_data=array();




    public function setCart()
    {
        if(count(seesion('cart'))>0)
        {
            $this->cart=seesion('cart');
        }
        else
        {
            $this->cart=array();
        }
    }
    public function getCart()
    {
        return $this->cart;

    }
    public function getCartCount()
    {
        return count($this->cart);

    }
    public function addToCart(CartRepository $cartRepository)
    {
        $cart=array();
        $cart_data=array();
        $product_id = $cartRepository->getProductid();
        $product_price = $cartRepository->getProductPrice();
        $product_qty = $cartRepository->getProductQuantity();

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

                $cart_data['price'] = $product_price;

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

                $cart_data['product_id']  = $product_id;
                $cart_data['quantity'] += $old_qty;

                if(session()->has('cart'))
                {
                    if(session()->has('cart.'.$product_id))
                    {
                       session()->forget('cart.'.$product_id);
                       session()->put('cart.'.$product_id,$cart_data);
                    }
                    else
                    {
                        session()->put('cart.'.$product_id,$cart_data);
                    }

                }else{
                    session()->put('cart.'.$product_id,$cart_data);
                }
                return true;
            }
        }

    }

    public function updateCart()
    {

    }
    public function remove()
    {

    }
//    public function productExist($product_id)
//    {
//        $sessioncart=session()->get('cart');
//        return array_key_exists($product_id,$sessioncart);
//    }
//    public function getProductQty($product_id)
//    {
//        $sessioncart=session()->get('cart');
//        return $sessioncart[$product_id]['quantity'];
//    }


}

?>