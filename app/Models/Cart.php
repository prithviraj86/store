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
        return $this->belongsTo(Product::class);

    }


    public static function findByProduct(Product $product,User $user)
    {
        return static::where([['product_id','=',$product->id],['customer_id','=',$user->id]])->first();
    }


    public static function getAll(User $user)
    {


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




//    private $rules = array(
//        'product_id' => 'required',
//        'customer_id'  => 'required',
//        'quantity'  => 'required',
//        // .. more rules here ..
//    );



//    public function validate($data)
//    {
//        // make a new validator object
//        $v = Validator::make($data, $this->rules);
//
//        // check for failure
//        if ($v->fails())
//        {
//            // set errors and return false
//            $this->errors = $v->errors;
//            return false;
//        }
//
//        // validation pass
//        return true;
//    }
//
//    public function errors()
//    {
//        return $this->errors;
//    }
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
