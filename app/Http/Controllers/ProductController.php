<?php

namespace App\Http\Controllers;


use App\Models\Product;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * This controller Have wrong Code it will be fixed when CartController Completed
     *This controller Have wrong Code it will be fixed when CartController Completed
     * This controller Have wrong Code it will be fixed when CartController Completed
     * This controller Have wrong Code it will be fixed when CartController Completed
     * This controller Have wrong Code it will be fixed when CartController Completed
     * This controller Have wrong Code it will be fixed when CartController Completed
     * This controller Have wrong Code it will be fixed when CartController Completed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user=Auth::user();
            //echo $user->is_admin;die;
            if(isset($user) and $user->is_admin==0)
            {
                return redirect('/');

            }
            return $next($request);
        });
    }

    public function index()
    {

        $products=Product::all();


        return view('index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(auth()->user()->is_admin != 1) return  redirect('/');
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product,Request $request)
    {
        if(auth()->user()->is_admin != 1) return  redirect('/');
        $this->validate(request(),[
            'name'=>'required',
            'price'=>'required|integer',
            'sprice'=>'required|integer',
            'quantity'=>'required|integer',
        ]);
        //$extension=$request->file('photo')->extension();

        //$request->file('photo')->storeAs('images',$filename,'public');


        $product->name=request('name');
        $product->admin_id=auth()->user()->id;
        $product->addProduct($product);
        if($product->id=='')
        {
            redirect('product/create');
        }
        else
        {
            redirect()->home();
        }
        return $product->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Request $request)
    {
        $productdata=Product::find($request->id);
        if($productdata)
        {
            return view('products.show',compact('productdata'));
        }
        else
        {
            throw new \Exception('Product not found');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
