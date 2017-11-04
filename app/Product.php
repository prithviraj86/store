<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function addProduct(Product $product)
    {

        $product->save();
        $productdetail=new ProductDetail();
        //$productdetail->manufacturer=
        $productdetail->manufacturer=request('manufacturer');
        $productdetail->quantity=request('quantity');
        $productdetail->weight=request('weight');
        $productdetail->description=request('description');

        $product->productdetail()->save($productdetail);
        $productprice=new ProductPrice();
        $productprice->price=request('price');
        $productprice->special_price=request('sprice');
        $product->productprice()->save($productprice);


    }

}
