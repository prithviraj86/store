@extends('layouts.app')

@section('content')
<?php //dd($productdata);die; ?>
        <div class="container">

            <div class="row">

                @if($errors->any())
                    <h4 style="color:red;">{{$errors->first()}}</h4>
                @endif
                @if(count($productdata) ==0)


                <h4 style="color:red;"> Not product found</h4>

                @else
                <div class="col-md-5">
                    <a href="/{{encrypt($productdata->productcategory->category->id)}}"> {{$productdata->productcategory->category->name}}></a>
                    <br>
                    <img src="{{ asset("images/proimages/".$productdata->id.".jpeg")}}">
                </div>
                <div class="col-lg-1">

                </div>
                <div class="col-md-6">

                    <h2>{{$productdata->name}}</h2>

                    <p>
                    <h4>Description</h4>
                    <p>{{$productdata->productdetail->description}}</p>
                    <ul>
                        <li>{{$productdata->productdetail->manufacturer}}</li>
                        <li>{{$productdata->productdetail->weight}}</li>
                    </ul>
                    <label>Price:-</label><s>{{$productdata->productprice->price}}</s>
                    <label>Special Price:-</label>{{$productdata->productprice->special_price}}

                    </p>

                        <form action="/cart/store" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$productdata->id}}" name="product_id"/>
                            <input type="hidden" value="{{$productdata->name}}" name="name"/>
                            <input type="hidden" value="{{$productdata->productprice->price}}" name="price"/>
                            <input type="hidden" value="1" name="quantity"/>
                            <input type="submit" value="Add to cart" class="btn btn-primary" name="addcart"/>
                        </form>


                </div>
                @endif
            </div>





        </div>

@endsection