<?php
namespace App\Repositories\Product;

use App\Models\User;
use Illuminate\Http\Request;

interface ProductInterface
{

    public function add(Request $request,User $user);
    public function all();
    public function find(Request $request);
    public function update(Request $request);
    public function remove(Request $request);

}