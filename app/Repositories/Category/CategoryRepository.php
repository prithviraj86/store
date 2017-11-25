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

class CategoryRepository implements CategoryInterface
{


    public function add(string $name)
    {
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

    public function find(int $id)
    {
        return Category::find($id)->toArray();
    }

    public function update(int $id,string $name)
    {
        $category=Category::find($id);
        $category->name=$name;
        return $category->save();
    }

    public function remove(int $id)
    {

        return Category::destroy($id);

    }
}