<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Cart extends Model
{
    private $sesssion_id;
    //
    protected $fillable = [
        'product_id', 'customer_id', 'session_id',
    ];


    public function __construct()
    {
        $this->sesssion_id=session()->getId();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }

    public function addToCart(Request $request)
    {
        if(isset(auth()->user()->id) and auth()->user()->id!='')
        {
            $this->product_id=$request->pid;
            $this->customer_id=auth()->user()->id;
            $this->session_id=$this->sesssion_id;
            $this->save();
        }
        else
        {

            $this->product_id=$request->pid;
            $this->session_id=$this->sesssion_id;
            $this->save();
        }
        return $this->id;
    }
    public function getCart()
    {
        //echo $this->sesssion_id;die;
        if(isset(auth()->user()->id))
        {
            return static::selectRaw('name,price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('customer_id','=',auth()->user()->id)
                ->get();
        }
        else
        {
            return static::selectRaw('name,price')
                ->join('products','carts.product_id','=','products.id')
                ->join('product_prices','product_prices.product_id','=','products.id')
                ->where('session_id','=',$this->sesssion_id)
                ->get();
        }

    }
    public static function UpdateCartOnLogin()
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

}
