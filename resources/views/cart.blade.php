@extends('layouts.app')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <?php //dd($cartdata);die;//echo count($cartdata); ?>

        @if(isset($cartdata) and $cartdata==false)
            <h3>Your Shopping Cart is empty.</h3>
            <p>
                Your Shopping Cart lives to serve. Give it purpose--fill it with books, CDs, videos, DVDs, electronics, and more. If you already have an account, Sign In to see your Cart.
                Continue shopping on the Amazon.in homepage, learn about today's deals, or visit your Wish List.<br>
                The price and availability of items at Amazon.in are subject to change. The shopping cart is a temporary place to store a list of your items and reflects each item's most recent price.
                Do you have a promotional code? We'll ask you to enter your claim code when it's time to pay.</p>
            <a href="/"  >
                <button style="cursor: pointer;" class="btn btn-primary">Continue Shopping</button>
            </a>
        @else
        <h3>Cart Items</h3>
            <br>
        @foreach($cartdata as $value)




        <div class="row" id="product_{{$value['product_id']}}" style="border-bottom: solid silver 1px;padding-bottom: 10px;margin-bottom: 20px;">
            <div class="col-md-2">
                <img src="<?php echo asset("images/proimages/".$value['product_id'].".jpeg")?>" style="width: 180px; height: 200px;">
            </div>
            <div class="col-md-7">
                <h3>{{$value['name']}}</h3>


            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success glyphicon-minus pull-left" style="width: 30px;" onclick="return updatecart({{$value['product_id']}},this.value,'desc');">-</button>
                <label id="quantity" class="pull-left" style="margin-left: 10px; margin-right: 10px;">{{$value['quantity']}}</label>
                <button type="button" class="btn btn-success glyphicon-plus pull-left" style="width: 30px;" onclick="return updatecart({{$value['product_id']}},this.value,'inc');">+</button>

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