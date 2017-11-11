<?php

namespace App;


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
        return $this->belongsTo(Product::class);

    }

    public function setUserId($user_id)
    {
        $this->user_id=$user_id;
    }

    public function add()
    {

    }

    public function get()
    {


            return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',$this->user_id)
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();


    }

    public function getProduct(int $id)
    {

        return static::selectRaw('id,quantity')->where('product_id','=',$id)->where('customer_id','=',$this->user_id)->get()->first();


    }
    public function updatec(int $product_id,int $quantity)
    {
        // Quantity is here because if user select more than 1 product
         static::query()->increment('quantity',$quantity,['product_id'=>$product_id,'customer_id'=>$this->user_id]);

        return $this->getProductTotal($product_id);
    }

    public function deletec(int $product_id)
    {
        return static::query()->where('product_id','=',$product_id)->where('customer_id','=',$this->user_id)->delete();

    }

    public function getProductTotal(int $product_id)
    {
        //This function is used for send response when user update single product quantity
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',$this->user_id)
            ->where('carts.product_id','=',$product_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }
    public function getTotal()
    {
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',$this->user_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }

}
