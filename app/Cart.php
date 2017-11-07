<?php

namespace App;

use App\Repositories\CartRepository;
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

    public function addToCart(Cart $cart)
    {

        return $cart->save();

    }
    public function getCart()
    {
        //echo $this->sesssion_id;die;

            return static::selectRaw('name,price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',auth()->user()->id)
                ->get();


    }
    public static function updateCartOnLogin()
    {

        //echo $old_session_id;
        if(isset(auth()->user()->id))
        {
        $old_session_id=session('old_id');
        return static::query()
                        ->where('session_id','=',$old_session_id)
                        ->update(['customer_id' => auth()->user()->id]);

        }

    }
    public function getCartProductById($id)
    {

        return static::selectRaw('id,quantity')
            ->where('product_id','=',$id)
            ->where('customer_id','=',auth()->user()->id)
            ->get()->first();


    }
    public function updateCartQty(Cart $cart)
    {
       // echo $cart->quanitty;die;
        return static::query()
            ->where('product_id','=',$cart->product_id)
            ->where('customer_id','=',auth()->user()->id)
            ->update(['quantity' => $cart->quanitty]);
    }

}
