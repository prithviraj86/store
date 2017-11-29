<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{

    private $category;


    public function __construct(CategoryInterface $category)
    {

        $this->middleware('auth');
        //parent::__construct();
        $this->middleware(function ($request, $next) {
            $user=Auth::user();
            //echo $user->is_admin;die;
            if($user->is_admin==0)
            {
               return redirect('/login');

            }
        return $next($request);
        });

        $this->category=$category;


    }

    public function create()
    {
        return View::make('category.create')->with('catdata',$this->category->all());
    }

    public function store(Request $request)
    {
        $result=$this->category->add($request);

        if($result){
            return redirect('/category');
        }
        else
        {
            return Redirect::back()->withErrors(['Category not updated']);
        }
    }

    public  function edit(Request $request)
    {
        $catdata=$this->category->all();
        $editdata=$this->category->find($request->id);
        //print_r($editdata);die;
        return View::make('category.create')->with(array('catdata'=>$catdata,'editdata'=>$editdata));
    }

    public function update(Request $request)
    {
        //dd($request);die;
        $result=$this->category->update($request->id,$request->name);

        if($result){
            return redirect('/category');
        }
        else
        {
            return Redirect::back()->withErrors(['Category not updated']);
        }
    }

    public function destroy(Request $request)
    {
        $result=$this->category->remove($request->id);

        if($result) {
            return redirect('/category');
        }
        else
        {
            return Redirect::back()->withErrors(['Category not deleted']);
        }
    }

}
