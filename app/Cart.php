<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{

    //
    protected $fillable = [
        'product_id', 'customer_id', 'session_id',
    ];




    public function product()
    {
        return $this->belongsTo(Product::class);

    }

    public function get(int $user_id)
    {


            return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',$user_id)
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();


    }

    public function getProduct(int $id,int $user_id)
    {

        return static::selectRaw('id,quantity')
            ->where('product_id','=',$id)
            ->where('customer_id','=',$user_id)
            ->get()->first();


    }
    public function updateQuantity(int $product_id,int $quantity,int $user_id)
    {

         static::query()
            ->where('product_id','=',$product_id)
            ->where('customer_id','=',$user_id)
            ->update(['quantity' => $quantity]);

        return $this->getProductTotal($product_id,$user_id);
    }
    public function deleteProduct(int $product_id,int $user_id)
    {
        return static::query()
            ->where('product_id','=',$product_id)
            ->where('customer_id','=',$user_id)
            ->delete();

    }
    public function getProductTotal(int $product_id,int $user_id)
    {
        //This function is used for send response when user update single product quantity
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',$user_id)
            ->where('carts.product_id','=',$product_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }
    public function getTotal(int $user_id)
    {
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',$user_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }

}
