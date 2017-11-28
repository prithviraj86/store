<?php

namespace App\Http\Controllers;


use App\Models\ProductCategory;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{

    private $user;
    private $product;

    public function __construct(ProductInterface $product)
    {
        $this->middleware('auth')->except('show');
        $this->middleware(function ($request, $next) {
            $this->user=Auth::user();

            if(isset($this->user) and $this->user->is_admin==0 and Route::current()->uri!="product/show/{id}")
            {
                return redirect('/');

            }
            return $next($request);
        });
        $this->product=$product;
    }


    public function index()
    {
        $productdata=$this->product->all();
        return view('products.list', compact('productdata'));
    }

    public function create()
    {

        return view('products.create');
    }

    public function store(Request $request)
    {
        $product=$this->product->add($request,$this->user);
        if(!$product)
        {
            return redirect('product');
        }
        else
        {
            return redirect()->home();
        }


    }


    public function show(Request $request)
    {
        $productdata=$this->product->find($request);
        if($productdata)
        {
            return view('products.show',compact('productdata'));
        }
        else
        {
            throw new \Exception('Product not found');
        }

    }


    public function edit(Request $request)
    {
        //
        $product=$this->product->find($request);

        return view('products.edit',compact('product'));
    }


    public function update(Request $request)
    {
        //
        $product=$this->product->update($request);
        if($product)
        {
            return redirect('product');
        }
    }


    public function destroy(Request $request)
    {
        //
        $result=$this->product->remove($request);
        if($result)
        {
            return redirect('product');
        }
        else
        {
            return Redirect::back()->withErrors(['Product not removed']);
        }
    }


}
