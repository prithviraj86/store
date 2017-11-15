<?php
namespace App\Libraries;

use App\Libraries\StorageInterface;
use App\Helpers;


class SessionStorage implements StorageInterface
{

    private $cart_name='cart';

    public function getAll()
    {
        return gets($this->cart_name);

    }

    public function add(array $save_data)
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
        //$new_qty=$old_qty+$product_qty;
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
    public function remove(int $product_id)
    {

        remove($this->cart_name.".".$product_id);
        return true;

    }
    public function clear()
    {

        return remove($this->cart_name);
    }
    public function decreseQuantity(int $product_id)
    {

        if(has($this->cart_name.'.'.$product_id))
        {

            $old_qty = gets($this->cart_name.'.'.$product_id.'.quantity');
            $old_qty-=1;
        }
       if($old_qty==0)
       {
           return $this->remove($product_id);


       }
       else
       {

        $cart_data=$this->get();
        data_set($cart_data,$product_id.'.quantity',$old_qty);
        data_set($cart_data,$product_id.'.total_price',$old_qty*data_get($cart_data,$product_id.'.price'));

        put($this->cart_name,$cart_data);

        return $this->getProductTotal($product_id);
       }

    }



    private function getProductTotal(int $product_id)
    {
        //echo $product_id;die;
        $cart_data=$this->get();
        //print_r($cart_data);die;
        return responseFormat($product_id,$cart_data);

    }



}

?>