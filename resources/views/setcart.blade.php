@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            @if($errors->any())
                <h4 style="color:red;">{{$errors->first()}}</h4>
            @endif
            <div class="row">
                <div class="col-lg-12">
                        <h3>You have  products in cart, Are you want to add in your account</h3>
                        <a href="/cart/updatelogin"><button type="button" class="btn btn-success">Yes</button></a>
                        <a href="/cart/emptys"><button type="button" class="btn btn-danger">No</button></a>
                </div>

            </div>
        </div>





    </div>

@endsection