<?php
namespace App\Repositories\ProductCategory;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProCatRepository implements ProductCategoryInterface
{
    public function add(Product $product,array $category)
    {
        $arr=set_same_key('category_id',$category);
        $dataInserted=merge_array_sets(array('product_id'=>$product->id),$arr);
       // print_r($dataInserted);die;
        $procate=ProductCategory::insert($dataInserted);

        return $procate;

    }
    public function all()
    {
        return ProductCategory::with('product','product.productprice','product.productdetail')->groupBy('product_id')->paginate(8);

    }

    public function productByCategory(Request $request)
    {
        $category=decrypt($request->id);
        return ProductCategory::with('product', 'product.productprice','product.productdetail')->where('category_id','=', $category )->paginate(10);
    }
}
