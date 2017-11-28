@extends('layouts.app')

@section('content')
    <?php //dd($productdata);die; ?>
<main role="main">
    <!--
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Store Products</h1>

        </div>
    </section>
    -->
    @if(count($productdata)>0)
    <div class="album text-muted">
        <div class="container">
            <h2 class="title ">Product List</h2>
            <hr>
            <div class="row panel panel-default">
                @foreach($productdata as $value)

                <div class="card" style="border-radius: 5px;border: 1px solid silver;padding: 10px; height: auto;justify-content: inherit;align-items: inherit;">
                    <img src="<?php echo asset("images/proimages/".$value->product->id.".jpeg")?>" alt="Product image cap" class="img-thumbnail rounded mx-auto d-block" style="display:block;width:100%;left: 0;right: 0;" >
                    <h4>{{ $value->product->name }}</h4>
                    <br>

                    <p class="card-text">Price:-<s>{{ $value->product->productprice->price }}</s></p>
                    <p class="card-text">Special Price:-{{ $value->product->productprice->special_price }}</p>
                    <a href="/product/show/{{$value->product->id}}"  ><button style="cursor: pointer;"  class="btn btn-primary">Buy</button></a>
                </div>


                @endforeach

            </div>

        </div>
    </div>
    @else
        <h3 style="color: red;">Not product</h3>
    @endif
</main>

@endsection