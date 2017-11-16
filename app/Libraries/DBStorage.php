<?php
namespace App\Libraries;


use App\Models\Cart;
use App\Models\User;
use App\Libraries\StorageInterface;
use App\Models\Product;


class DBStorage implements StorageInterface
{

    private $model;

    public function __construct()
    {

    }
    public function setModel(Cart $cart,User $user)
    {

        $this->model=$cart;
        $this->model->setUserId($user->id);


    }

    public function add(Product $product,int $quntity=0)
    {
        return $this->model->add($product,$quntity);
    }
    public function decreseQuantity(Product $product)
    {
        return $this->model->decreseQuantity($product->id);
    }

    public function remove(Product $product)
    {


        return $this->model->remove($product->id);

    }
    public function clear()
    {
        return $this->model->clear();
    }
    public function getAll()
    {
        return $this->model->getAll();
    }
}