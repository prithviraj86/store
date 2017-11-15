<?php
namespace App\Libraries;

use App\Models\Cart as Model;
use App\Libraries\StorageInterface;
use Illuminate\Http\Request;



class Cart
{
    private $model;
    private $storage;
    private $user_id;
    private $product_id;


    public function __construct(Model $model,StorageInterface $storage)
    {
        $this->model=$model;
        $this->storage=$storage;

    }
    public function setUserId($uid)
    {

        $this->user_id=$uid;
        $this->model->setUserId($uid);

    }

    public function getData()
    {

        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->model->get() ;
        }
        else
        {
            return $this->storage->get();
        }

    }

    public function add(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        //$this->validate();
        $save_data=array(
            'product_id'=>$request->product_id,
            'price'=>$request->price,
            'name'=>$request->name
        );
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->model->add($save_data);

        }
        else
        {


            return $this->storage->add($save_data);
        }

    }
    public function remove(Request $request)
    {
        if(isset($this->user_id) and $this->user_id!='')
        {

            $result= $this->model->remove($request->product_id);
        }
        else
        {
            $result= $this->storage->remove($request->product_id);
        }
    }
    public function clear()
    {
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->model->clear();
        }
        else
        {
            return $this->storage->clear();
        }
    }
    public function decreseQuantity(Request $request)
    {

        $request->validate([
            'quantity'=>'required|integer',
            'product_id'=>'required|integer',
        ]);
        $product_id=$request->product_id;
        //echo $this->user_id;die;
        if(isset($this->user_id) and $this->user_id!='')
        {

            return $this->model->decreseQuntity($product_id);
        }
        else
        {
            return $this->storage->decreseQuantity($product_id);
        }
    }

    public  function clearSession()
    {
        return $this->storage->emptyCart();
    }
    public function updateOnlogin()
    {

        if(isset($this->user_id) and $this->user_id!='')
        {
            $cart_data=$this->storage->getData($this->user_id);
            foreach ($cart_data as $value)
            {

                $this->model->add($value);

                $this->storage->clear();


            }
            return true;
        }
        else
        {
            return false;
        }

    }

}