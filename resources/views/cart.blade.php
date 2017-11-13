@extends('layouts.app')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <?php //dd($cartdata);die;//echo count($cartdata); ?>

        @if((isset($cartdata) and count($cartdata)==0) or (!isset($cartdata)))
            <h3>Cart Empty</h3>
            <a href="/"  >
                <button style="cursor: pointer;" class="btn btn-primary">Continue Shopping</button>
            </a>
        @else
        @foreach($cartdata as $value)




        <div class="row" id="product_{{$value['product_id']}}">
            <div class="col-md-2">
                <img src="images/" style="width: 180px; height: 200px;">
            </div>
            <div class="col-md-7">
                <h3>{{$value['name']}}</h3>


            </div>
            <div class="col-md-1">
                <select id="quantity" name="quantity" class="form-control" onchange="return updatecart({{$value['product_id']}},this.value);">
                    <option selected>{{$value['quantity']}}</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>


            </div>
            <div class="col-md-1">
                <p>{{$value['total_price']}}</p>
                <form action="/cart/delete" method="post">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$value['product_id']}}" name="product_id">
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>

            </div>

        </div>

        @endforeach

        <div class="row">
            <div class="col-md-9 text-right"><strong>Total:-</strong></div>
            <div class="col-md-3 text-left"><strong>{{array_sum(array_column($cartdata,'total_price'))}}</strong></div>
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