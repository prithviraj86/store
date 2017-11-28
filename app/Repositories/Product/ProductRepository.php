<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductInterface;
use App\Libraries\FileStorage;

class ProductRepository implements ProductInterface
{
    public function add(Request $request,User $user)
    {
        $product=new Product();
        $product->name=request('name');
        $product->admin_id=$user->id;
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
        FileStorage::uploadProduct($product,$request);


        return $product->id;

    }

    public function all()
    {
        return Product::with('productprice','productdetail')->get()->toArray();
    }

    public function find(Request $request)
    {
        return Product::with('productprice','productdetail','cart','productcategory.category')->find($request->id);
    }

    public function update(Request $request)
    {
        $product=Product::find(request('id'));
        $product->name=request('name');
        $product->productdetail->manufacturer=request('manufacturer');
        $product->productdetail->quantity=request('quantity');
        $product->productdetail->weight=request('weight');
        $product->productdetail->description=request('description');
        $product->productdetail->save();
        $product->productprice->price=request('price');
        $product->productprice->special_price=request('sprice');
        $product->productprice->save();
        FileStorage::uploadProduct($product,$request);
        return $product->save();
    }

    public function remove(Request $request)
    {

        return Product::destroy(request('id'));

    }
}
