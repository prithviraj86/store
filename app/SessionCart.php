<?php
namespace App;



class SessionCart
{

    private $cart_name='cart';

    public function get()
    {
        return session($this->cart_name);

    }
    public function getCount()
    {

        return count(session($this->cart_name));


    }
    public function addToCart(array $save_data)
    {
        //print_r($save_data);die;
        $cart_data=array();
        $product_id    = data_get($save_data,'product_id');//$save_data['product_id'];
        $product_name  = data_get($save_data,'name');//$save_data['name'];
        $product_price = data_get($save_data,'price');//$save_data['price'];
        $product_qty   = data_get($save_data,'quantity');//$save_data['quantity'];

        //$cart_data['quantity'] = $product_qty;


        // get quantity if it's already there and add it on
        if(session()->has('cart.'.$product_id))
        {
        $old_qty = session()->get('cart.'.$product_id.'.quantity');

        }
        else
        {
        $old_qty=0;
        }
        data_set($cart_data,'name',$product_name);
        data_set($cart_data,'product_id',$product_id);
        data_set($cart_data,'quantity',$product_qty+$old_qty);
        data_set($cart_data,'price',$product_price);
        data_set($cart_data,'total_price',$product_price*data_get($cart_data,'quantity'));
//        $cart_data['name']  = $product_name;
//        $cart_data['product_id']  = $product_id;
//        $cart_data['quantity'] += $old_qty;
//        $cart_data['price'] = $product_price;
//        $cart_data['total_price'] = $product_price*$cart_data['quantity'];

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

    public function updateQuantity(int $product_id,int $quantity)
    {
        $product_id=$product_id;
        $quantity=$quantity;

        $cart_data=$this->get();
        data_set($cart_data,$product_id.'.quantity',$quantity);
        data_set($cart_data,$product_id.'.total_price',$quantity*data_get($cart_data,$product_id.'.price'));
        //$cart_data[$product_id]['quantity']=$quantity;

        //$cart_data[$product_id]['total_price']=$quantity*$cart_data[$product_id]['price'];
        session()->put($this->cart_name,$cart_data);
       // $return_data=array('product_id'=>(int)$product_id,'total_price'=>$cart_data[$product_id]['total_price']);

        return $this->getProductTotal($product_id);

    }


    /**
     * @param $product_id
     * @return bool
     */
    public function removeProduct($product_id)
    {

        session()->forget($this->cart_name.".".$product_id);
        return true;

    }
    public function getProductTotal(int $product_id)
    {
        //echo $product_id;die;
        $cart_data=$this->get();
        //print_r($cart_data);die;
        return responseFormat($product_id,$cart_data);

    }
    public function getCartTotal()
    {
        $cart_data=$this->get();
        return responseFormat('',$cart_data);


    }
    public function getData($user_id)
    {
        $cart_data=$this->get();

        //print_r($cart_data);die;
        $return_data=array();
        foreach($cart_data as $arr)
        {
            data_set($result_data,'product_id',data_get($arr,'product_id'));
            data_set($result_data,'quantity',data_get($arr,'quantity'));
            data_set($result_data,'customer_id',$user_id);
            data_set($result_data,'created_at',date('Y-m-d H:i:s'));
            data_set($result_data,'product_id',date('Y-m-d H:i:s'));

            $return_data[]=$result_data;
        }
        return $return_data;
    }
    public function emptyCart()
    {
        session()->forget($this->cart_name);
    }



}

?>