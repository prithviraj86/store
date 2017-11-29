<?php
/**
 * Created by PhpStorm.
 * User: Saini
 * Date: 25-11-2017
 * Time: 02:25
 */

namespace App\Repositories\Category;

use App\Repositories\Category\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryInterface
{


    public function add(Request $request)
    {
        $name=strtolower($request->name);
        $category=Category::Where('name','=',$name)->get()->toArray();
        if(count($category)>0){
            return false;
        }
        else{
            $category=new Category();
            $category->name=$name;
            return $category->save();
        }

    }

    public function all()
    {
        return Category::all()->toArray();
    }

    public function find(Request $request)
    {
        return Category::find($request->id)->toArray();
    }

    public function update(Request $request)
    {
        $category=Category::find($request->id);
        $category->name=strtolower($request->name);
        return $category->save();
    }

    public function remove(Request $request)
    {

        return Category::destroy($request->id);

    }
}