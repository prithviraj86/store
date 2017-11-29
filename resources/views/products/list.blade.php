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
                <div class="row">
                    <div class="col-md-10"><h2 class="title ">Product List</h2></div>
                    <div class="col-md-2 text-right">
                        <a href="/product/create">
                        <button type="button" class="btn btn-success">Add New Product</button>
                        </a>
                    </div>
                </div>


                <hr>

                <div class="row panel panel-default">

                    <table class="table table-dark">
                        <thead class="thead-dark" style="background-color: #2a88bd;color: #ffffff;">
                        <tr>

                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productdata as $value)

                        <tr>

                            <td>{{ $value['name'] }}</td>
                            <td>{{ $value['productprice']['price'] }}</td>
                            <td>{{$value['productdetail']['quantity']}}</td>
                            <td style="width: 200px;">
                                <a href="/product/edit/{{ $value['id'] }}"><button class="btn btn-primary">Edit</button></a>
                                <a href="/product/delete/{{ $value['id'] }}"><button class="btn btn-danger">Delete</button></a>
                            </td>
                        </tr>



                        @endforeach


                        </tbody>
                    </table>


                </div>

            </div>
        </div>
        @else
        <h3 style="color: red;">Not product</h3>
        @endif
    </main>

    @endsection