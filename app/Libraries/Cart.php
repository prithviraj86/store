<?php
namespace App\Libraries;

use App\Models\Product;
use App\Libraries\StorageInterface;
use Illuminate\Http\Request;


//all cart logic.
class Cart
{

    private $storage;


    public function __construct(StorageInterface $storage)
    {
        $this->storage=$storage;


    }

    public function add(Product $product,int $quantity)
    {
         $currentQuantity = $this->storage->getQuantity($product);

         if(!$currentQuantity)
         {
             $currentQuantity=0;
         }

         $currentQuantity+=$quantity;

         return $this->storage->set($product,$currentQuantity);

    }

    public function sub(Product $product)
    {
        $currentQauntity = $this->storage->getQuantity($product);
        $currentQauntity--;

        if($currentQauntity <= 0){
            $this->storage->remove($product);
        }
        else
        {
            $this->storage->set($product, $currentQauntity);
        }

    }
    public function remove(Product $product)
    {


        $this->storage->remove($product);

    }
    public function clear()
    {

            return $this->storage->clear();

    }
    public function getAll()
    {

       return $this->storage->getAll();

    }


    public function isProduct($id)
    {

        $product= Product::find($id);

        if($product)
        {
            return $product;
        }
        else
        {
            throw new \Exception('Product not found');
        }


    }
//    public  function clearSession()
//    {
//        return $this->storage->clear();
//    }
    //    public function updateOnlogin()
    //    {
    //
    //
    //            $cart_data=session('cart');
    //            foreach ($cart_data as $value)
    //            {
    //
    //
    //
    //            }
    //            $this->storage->add();
    //            $this->storage->clear();
    //            return true;
    //
    //
    //    }

}