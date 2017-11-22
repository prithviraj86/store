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
        return $this->hasOne(ProductPrice::class);
    }
//    public function productImage()
//    {
//        return $this->hasOne(ProductImage::class);
//    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

//    public function addProduct(Product $product)
//    {
//
//        //Wrong code will change soon
//
//
//        $product->save();
//        $productdetail=new ProductDetail();
//        //$productdetail->manufacturer=
//        $productdetail->manufacturer=request('manufacturer');
//        $productdetail->quantity=request('quantity');
//        $productdetail->weight=request('weight');
//        $productdetail->description=request('description');
//
//        $product->productdetail()->save($productdetail);
//        $productprice=new ProductPrice();
//        $productprice->price=request('price');
//        $productprice->special_price=request('sprice');
//        $product->productprice()->save($productprice);
//
//
//    }


}
