<?php
namespace App\Repositories\Category;


use Illuminate\Http\Request;

interface CategoryInterface
{
    public function add(Request $request);
    public function all();
    public function find(Request $request);
    public function update(Request $request);
    public function remove(Request $request);

}