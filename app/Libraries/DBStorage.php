<?php
namespace App\Libraries;


use App\Models\Cart;
use App\Models\User;
use App\Libraries\StorageInterface;
use App\Models\Product;
//Interaction two

class DBStorage implements StorageInterface
{

    private $user;//static

    public function setUser(User $user)
    {

        $this->user=$user;

    }
    public function getUser()
    {
        return $this->user;
    }

    public function getQuantity(Product $product)
    {
        $cart=Cart::findByProduct($product,$this->user);

        if(isset($cart))
        {
            return $cart->quantity;
        }
        else
        {
            return false;
        }


    }


    public function set(Product $product,int $quantity=0)
    {

        $cart = Cart::findByProduct($product,$this->user);
        if(!$cart){
            $cart = new Cart();
            $cart->product_id = $product->id;
            $cart->customer_id = $this->user->id;
        }
        $cart->quantity = $quantity;
        $cart->save();
        return true;

    }

    public function remove(Product $product)
    {
        return Cart::remove($product,$this->user);
    }

    public function clear()
    {

        return Cart::clear($this->user);
    }

    public function getAll()
    {

        return Cart::getAll($this->user);
//        return Cart::with('product' ,'product.productprice')
//                    ->where('customer_id', '=', $this->user->id)
//                    ->get()->toArray();
    }
}