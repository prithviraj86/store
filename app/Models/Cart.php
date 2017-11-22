<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    private static $user_id;
    //
    protected $fillable = [
        'product_id', 'customer_id'
    ];


//    public function product()
//    {
//        return $this->belongsToMany(Product::class);
//
//    }

    public static function setUserId($user_id)
    {
        self::$user_id=$user_id;
    }
    public static function getUserId()
    {
        return self::$user_id;
    }
    public static function add(Product $product,int $quantity)
    {

        return static::updateOrCreate(
            ['product_id'=>$product->id,'customer_id'=>self::$user_id],
            ['product_id'=>$product->id,'customer_id'=>self::$user_id]
             )
            ->increment('quantity',$quantity);
    }

    public static function getAll()
    {

            return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',self::$user_id)
                ->where('quantity','>',0)
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();
    }



    //Update the quantity which user selected
    public static function decreseQuantity(int $product_id)
    {

        static::where(['product_id'=>$product_id,'customer_id'=>self::$user_id])->decrement('quantity',1);
        static::where(['product_id'=>$product_id,'customer_id'=>self::$user_id,'quantity'=>0])->delete();
        return self::getProductTotal($product_id);
    }

    public static function remove(int $product_id)
    {
        return static::where('product_id','=',$product_id)->where('customer_id','=',self::$user_id)->delete();

    }

    public static function clear()
    {
        return static::where('customer_id','=',self::$user_id)->delete();
    }

    private static function getProductTotal(int $product_id)
    {
        //This function is used for send response when user update single product quantity
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',self::$user_id)
            ->where('carts.product_id','=',$product_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }


}
