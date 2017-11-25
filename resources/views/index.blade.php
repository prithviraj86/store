@extends('layouts.app')

@section('content')

<main role="main">
    <!--
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Store Products</h1>

        </div>
    </section>
    -->
    <div class="album text-muted">
        <div class="container">
            <h2 class="title ">Product List</h2>
            <hr>
            <div class="row panel panel-default">
                @foreach($products as $value)

                    <div class="card" style="border-radius: 5px;border: 1px solid silver;padding: 10px;width: 30%;margin: 15px;height: 230px; ">
                        <img src="images/{{$value->image_link}} " alt="Product image cap" class="img-thumbnail rounded mx-auto d-block" >
                        <h4></h4>{{ $value->name }}</h4>
                        <br>

                        <p class="card-text">Price:-<s>{{ $value->productprice->price }}</s></p>
                        <p class="card-text">Special Price:-{{ $value->productprice->special_price }}</p>
                        <a href="/product/show/{{$value->id}}"  ><button style="cursor: pointer;"  class="btn btn-primary">Buy</button></a>
                    </div>


               @endforeach

            </div>

        </div>
    </div>

</main>

@endsection