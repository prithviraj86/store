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

    public function addToCart(Request $request)
    {
        if(auth()->user()->id=='')
        {
            $this->product_id=$request->product_id;
            $this->session_id=$this->sesssion_id;
            $this->save();
        }
        else
        {
            $this->product_id=$request->product_id;
            $this->customer_id=auth()->user()->id;
            $this->session_id=$this->sesssion_id;
            $this->save();
        }
    }
    public function getCart()
    {

    }

}
