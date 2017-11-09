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

    public function getCart()
    {
        //echo $this->sesssion_id;die;

            return static::selectRaw('carts.product_id,products.name,product_prices.price,carts.quantity,sum(carts.quantity*product_prices.price) as total_price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',auth()->user()->id)
                ->groupBy('carts.product_id','products.name','carts.quantity','product_prices.price')
                ->get()->toArray();


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
    public function updateCartQty(int $product_id,int $quantity)
    {
       // echo $cart->quanitty;die;
        //echo $cart_repository->getProductQuantity();die;
         static::query()
            ->where('product_id','=',$product_id)
            ->where('customer_id','=',auth()->user()->id)
            ->update(['quantity' => $quantity]);

        return $this->getCartProductTotal($product_id);
    }
    public function deleteProduct(int $product_id)
    {
        return static::query()
            ->where('product_id','=',$product_id)
            ->where('customer_id','=',auth()->user()->id)
            ->delete();

    }
    public function getCartProductTotal(int $product_id)
    {
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',auth()->user()->id)
            ->where('carts.product_id','=',$product_id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }
    public function getCartTotal()
    {
        return static::selectRaw('carts.product_id,sum(carts.quantity*product_prices.price) as total_price')
            ->join('product_prices','product_prices.product_id','=','carts.product_id')
            ->where('carts.customer_id','=',auth()->user()->id)
            ->groupBy('carts.product_id')
            ->get()->toArray();
    }

}
