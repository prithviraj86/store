<?php
namespace App;
use App\Helpers;

class SessionCart
{

    private $cart_name='cart';

    public function get()
    {
        return gets($this->cart_name);

    }
    public function getCount()
    {

        return count( ($this->cart_name));


    }
    public function addToCart(array $save_data)
    {

        $cart_data=array();
        $product_id    = data_get($save_data,'product_id');
        $product_name  = data_get($save_data,'name');
        $product_price = data_get($save_data,'price');
        //$product_qty   = data_get($save_data,'quantity');

        // get quantity if it's already there and add it on
        ///get,has,remove,put are helper method for session

        if(has($this->cart_name.'.'.$product_id))
        {

             $old_qty = gets($this->cart_name.'.'.$product_id.'.quantity');

        }
        else
        {
            $old_qty=0;
        }
        data_set($cart_data,'name',$product_name);
        data_set($cart_data,'product_id',$product_id);
        data_set($cart_data,'quantity',$old_qty+1);
        data_set($cart_data,'price',$product_price);
        data_set($cart_data,'total_price',$product_price*data_get($cart_data,'quantity'));

        ///get,has,remove,put are helper method for session
        if(has($this->cart_name))
        {
            if(has($this->cart_name.'.'.$product_id))
            {
               remove($this->cart_name.'.'.$product_id);
               put($this->cart_name.'.'.$product_id,$cart_data);
            }
            else
            {
                put($this->cart_name.'.'.$product_id,$cart_data);
            }

        }else{
            put($this->cart_name.'.'.$product_id,$cart_data);
        }
        return true;



    }

    public function decreseQuantity(int $product_id)
    {

        if(has($this->cart_name.'.'.$product_id))
        {

            $old_qty = gets($this->cart_name.'.'.$product_id.'.quantity');
            $old_qty-=1;
        }
        else
        {
            $old_qty=0;
        }

        $cart_data=$this->get();
        data_set($cart_data,$product_id.'.quantity',$old_qty);
        data_set($cart_data,$product_id.'.total_price',$old_qty*data_get($cart_data,$product_id.'.price'));

        put($this->cart_name,$cart_data);

        return $this->getProductTotal($product_id);

    }



    public function removeProduct($product_id)
    {

        remove($this->cart_name.".".$product_id);
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
            data_set($result_data,'updated_id',date('Y-m-d H:i:s'));

            $return_data[]=$result_data;
        }
        return $return_data;
    }


    public function emptyCart()
    {

       return remove($this->cart_name);
    }

//    public function remove($key)
//    {
//        session()->forget($key);
//    }




}

?>