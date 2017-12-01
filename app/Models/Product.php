<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    protected $fillable = [
        'admin_id', 'name',
    ];


    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }
    public function productPrice()
    {
        return $this->hasOne(ProductPrice::class)->select(['product_id', 'price','special_price']);
    }
    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }





}
