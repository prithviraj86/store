<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    //
    protected $fillable = [
        'product_id','price', 'special_price',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);

    }
}
