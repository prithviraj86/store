<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    private $user_id;
    //
    protected $fillable = [
        'product_id', 'customer_id', 'session_id',
    ];


    public function product()
    {
        return $this->belongsToMany(Product::class);

    }

    public function setUserId($user_id)
    {
        $this->user_id=$user_id;
    }

    public function add(array $data)
    {

        // Quantity is here because if user select more than 1 product


        return static::query()->updateOrCreate(
            ['product_id'=>$data['product_id'],'customer_id'=>$this->user_id],
            ['product_id'=>$data['product_id'],'customer_id'=>$this->user_id]
             )
            ->increment('quantity',$data['quantity']);



    }

    public function getAll()
    {


            return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',$this->user_id)
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();


    }



    //Update the quantity which user selected
    public function decreseQuntity(int $product_id)
    {
        //echo $product_id;die;
        static::query()->decrement('quantity',1,['product_id'=>$product_id,'customer_id'=>$this->user_id]);
        return $this->getProductTotal($product_id);
    }

    public function remove(int $product_id)
    {
        return static::query()->where('product_id','=',$product_id)->where('customer_id','=',$this->user_id)->delete();

    }

    private function getProductTotal(int $product_id)
    {
        //This function is used for send response when user update single product quantity
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',$this->user_id)
            ->where('carts.product_id','=',$product_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }


}
