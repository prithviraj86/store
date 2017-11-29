<?php
namespace App\Libraries;

use App\Libraries\StorageInterface;
use App\Models\Product;
use App\Libraries\CartSession;
//Interaction one.

class SessionStorage implements StorageInterface
{

    private $cart_name='cart';

    public function getAll()
    {
        return CartSession::findByKey($this->cart_name);

    }

    public function getQuantity(Product $product)
    {
        $quantity=CartSession::findByKey($this->cart_name.'.'.$product->id.'.quantity');

        if($quantity)
        {
            return $quantity;
        }
        else
        {
            return false;
        }

    }

    public function set(Product $product,int $quantity=0)
    {

        $cart_data=array();

        data_set($cart_data,'name',$product->name);
        data_set($cart_data,'product_id',$product->id);
        data_set($cart_data,'price',$product->productprice->price);
        data_set($cart_data,'quantity',$quantity);
        data_set($cart_data,'total_price',$product->productprice->price*$quantity);
        CartSession::add($this->cart_name.'.'.$product->id,$cart_data);
        return true;


    }

    public function remove(Product $product)
    {
        CartSession::remove($this->cart_name.".".$product->id);
        return true;

    }
    public function clear()
    {

        return CartSession::remove($this->cart_name);
    }

}
