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

            <div class="row">
                @foreach($products as $value)

                <div class="card">
                    <img src="images/{{$value->image_link}} " alt="Product image cap" class="img-thumbnail rounded mx-auto d-block" >
                    <h4></h4>{{ $value->name }}</h4>
                    <br>
                    <p class="card-text">Price:-{{ $value->price }}</p>
                    <a href="singlep.php?id={{$value->id}}"  ><button style="cursor: pointer;"  class="btn btn-primary">Buy</button></a>
                </div>

               @endforeach

            </div>

        </div>
    </div>

</main>

@endsection