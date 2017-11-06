@extends('layouts.app')

@section('content')
    <div class="container">

        @if($cartdata->isEmpty())
            <h3>Cart Empty</h3>
            <a href="/"  >
                <button style="cursor: pointer;" class="btn btn-primary">Continue Shopping</button>
            </a>
        @else
        @foreach($cartdata as $value)




        <div class="row">
            <div class="col-md-2">
                <img src="images/" style="width: 180px; height: 200px;">
            </div>
            <div class="col-md-7">
                <h3>{{$value->name}}</h3>


            </div>
            <div class="col-md-1">
                <p>{{$value->price}}</p>
            </div>

        </div>
        @endforeach

        <div class="row">
            <div class="col-md-9 text-right"><strong>Total:-</strong></div>
            <div class="col-md-3 text-left"><strong>{{$cartdata->sum('price') }}</strong></div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-10 text-right">
                <a href="/"  >
                    <button style="cursor: pointer;" class="btn btn-primary">Continue Shopping</button>
                </a>
                <a href="checkout.php"  >
                    <button style="cursor: pointer;" class="btn btn-primary">CheckOut</button>
                </a>
            </div>
        </div>

    @endif
    </div>
@endsection