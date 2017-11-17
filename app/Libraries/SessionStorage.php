<?php
namespace App\Libraries;

use App\Libraries\StorageInterface;
use App\Models\Product;
use App\Helpers;


class SessionStorage implements StorageInterface
{

    private $cart_name='cart';

    public function getAll()
    {
        return gets($this->cart_name);

    }

    public function add(Product $product,int $quantity=0)
    {
        //print_r($product);die;
        $cart_data=array();
        // get quantity if it's already there and add it on
        ///get,has,remove,put are helper method for session

        if(has($this->cart_name.'.'.$product->id))
        {
            $old_qty = gets($this->cart_name.'.'.$product->id.'.quantity');
        }
        else
        {
            $old_qty=0;
        }
        $product_price = $product->productprice->price;
        $new_qty=$old_qty+$quantity;
        data_set($cart_data,'name',$product->name);
        data_set($cart_data,'product_id',$product->id);
        data_set($cart_data,'quantity',$new_qty);
        data_set($cart_data,'price',$product_price);
        data_set($cart_data,'total_price',$product_price*data_get($cart_data,'quantity'));

        ///get,has,remove,put are helper method for session
        if(has($this->cart_name))
        {
            if(has($this->cart_name.'.'.$product->id))
            {
               remove($this->cart_name.'.'.$product->id);
               put($this->cart_name.'.'.$product->id,$cart_data);
            }
            else
            {
                put($this->cart_name.'.'.$product->id,$cart_data);
            }

        }else{
            put($this->cart_name.'.'.$product->id,$cart_data);
        }
        return true;



    }
    public function remove(Product $product)
    {

        remove($this->cart_name.".".$product->product_id);
        return true;

    }
    public function clear()
    {

        return remove($this->cart_name);
    }
    public function decreseQuantity(Product $product)
    {
        //print_r(session($this->cart_name.'.'.$product->id));die;
        if(has($this->cart_name.'.'.$product->id))
        {

            $old_qty = gets($this->cart_name.'.'.$product->id.'.quantity');
            $old_qty-=1;
        }

       if($old_qty==0)
       {
           return remove($this->cart_name.'.'.$product->id);


       }
       else
       {

        $cart_data=$this->getAll();
        data_set($cart_data,$product->id.'.quantity',$old_qty);
        data_set($cart_data,$product->id.'.total_price',$old_qty*data_get($cart_data,$product->id.'.price'));

        put($this->cart_name,$cart_data);

        return $this->getProductTotal($product->id);
       }

    }



    private function getProductTotal(int $product_id)
    {
        //echo $product_id;die;
        $cart_data=$this->getAll();
        //print_r($cart_data);die;
        return responseFormat($product_id,$cart_data);

    }



}

?>