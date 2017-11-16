<?php
namespace App\Libraries;

use App\Models\Product;
use App\Libraries\StorageInterface;
use Illuminate\Http\Request;



class Cart
{

    private $storage;


    public function __construct(StorageInterface $storage)
    {
        $this->storage=$storage;


    }

    public function add(Product $product,int $quantity)
    {
         return $this->storage->add($product,$quantity);


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


    public function decreseQuantity(Product $product)
    {

        return $this->storage->decreseQuantity($product);

    }

    public  function clearSession()
    {
        return $this->storage->clear();
    }
//    public function updateOnlogin()
//    {
//
//        if(isset($this->user_id) and $this->user_id!='')
//        {
//            $cart_data=$this->storage->getAll();
//            foreach ($cart_data as $value)
//            {
//
//                $this->model->add($value);
//
//
//
//
//            }
//            $this->storage->clear();
//            return true;
//        }
//        else
//        {
//            return false;
//        }
//
//    }

}