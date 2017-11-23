<?php

namespace App\Models;


use DeepCopy\f004\UnclonableItem;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    protected $fillable = [
        'product_id', 'customer_id'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);

    }


    public static function findByProduct(Product $product,User $user)
    {
        return static::where([['product_id','=',$product->id],['customer_id','=',$user->id]])->first();
    }


    public static function getAll(User $user)
    {
        return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',$user->id)//wrong
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();
    }


    public static function remove(Product $product,User $user)
    {
        return static::where([['product_id','=',$product->id],['customer_id','=',$user->id]])->delete();

    }

    public static function clear(User $user)
    {
        return static::where('customer_id','=',$user->id)->delete();
    }

//    private static function getProductTotal(int $product_id)
//    {
//        //This function is used for send response when user update single product quantity
//        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
//            ->join('product_prices','product_prices.product_id','=','carts.product_id')
//            ->where('carts.customer_id','=',self::$user_id)
//            ->where('carts.product_id','=',$product_id)
//            ->groupBy('carts.product_id')
//            ->get()->toArray();
//    }


}
