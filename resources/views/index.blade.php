@extends('layouts.app')

@section('content')
    <?php //dd($productData);die; ?>
<main role="main">
    <!--
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Store Products</h1>

        </div>
    </section>
    -->
    @if(count($productData)>0)
    <div class="album text-muted">
        <div class="container">
            <h2 class="title ">Product List</h2>
            <hr>
            <div class="row">
                @foreach($productData as $value)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card">
                        <div  class="card-img-top text-center">
                        <img src="<?php echo asset("images/proimages/".$value->product->id.".jpeg")?>" alt="Product image cap">
                        </div>
                        <div class="card-block">
                            <h6 class="card-title">{{ $value->product->name }}</h6>
                            <br>

                            <p class="card-text">Price:-<s>{{ $value->product->productprice->price }}</s></p>
                            <p class="card-text">Special Price:-{{ $value->product->productprice->special_price }}</p>

                        </div>
                        <a href="/product/show/{{ $value->product->id }}"  class="text-center"><button class="btn btn-primary">Buy</button></a>
                    </div>
                </div>


                @endforeach

            </div>
            <nav class="Page navigation text-center" >
                {{ $productData->links() }}
            </nav>

        </div>
    </div>
    @else
        <h3 style="color: red;">Not product</h3>
    @endif
</main>

@endsection