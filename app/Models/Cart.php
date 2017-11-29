<?php

namespace App\Models;


use DeepCopy\f004\UnclonableItem;
use Illuminate\Database\Eloquent\Model;



class Cart extends Model
{


    private $errors;

    protected $fillable = [
        'product_id', 'customer_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->select(['id', 'name']);

    }


    public static function findByProduct(Product $product,User $user)
    {
        return static::where([['product_id','=',$product->id],['customer_id','=',$user->id]])->first();
    }


    public static function getAll(User $user)
    {

//       return static ::with('product','product.productprice')->where('customer_id','=',$user->id)
//                ->get()->toArray();
        return static::Where('customer_id','=',$user->id)
                ->selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
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





}
