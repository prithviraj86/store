<?php
namespace App\Repositories\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProCatRepository implements ProductCategoryInterface
{
    public function all()
    {
        return ProductCategory::with('product','product.productprice','product.productdetail')->paginate(10);
    }

    public function productByCategory(Request $request)
    {
        $category=decrypt($request->id);
        return ProductCategory::with('product', 'product.productprice','product.productdetail')->where('category_id','=', $category )->paginate(10);
    }
}
