<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
    protected $fillable = [
        'product_id','image_link', 'small_image_link', 'thumb_image_link',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);

    }
}
