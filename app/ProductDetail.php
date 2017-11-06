<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    //
    protected $fillable = [
        'product_id','manufacturer', 'quantity', 'weight', 'description',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);

    }


}
