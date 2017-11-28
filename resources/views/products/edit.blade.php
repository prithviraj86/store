@extends('layouts.app')

@section('content')
@if(isset($product->name))
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <form class="form-horizontal" method="POST" action="/product/update" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label text-left">Name</label>

                                <div class="col-md-9">
                                    <input id="name" type="hidden" class="form-control" name="id" value="{{ $product->id}}" >
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $product->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-3 control-label">Price</label>

                                <div class="col-md-9">
                                    <input id="price" type="text" value="{{ $product->productprice->price }}" class="form-control" name="price" required>
                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sprice') ? ' has-error' : '' }}">
                                <label for="sprice" class="col-md-3 control-label">Special Price</label>

                                <div class="col-md-9">
                                    <input id="sprice" type="text" class="form-control" value="{{ $product->productprice->special_price }}" name="sprice" required>
                                    @if ($errors->has('sprice'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('sprice') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="manufacturer" class="col-md-3 control-label">Upload Image</label>

                                <div class="col-md-9">
                                    <input id="photo" type="file" class="form-control" name="photo" value="{{ old('photo') }}" >


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group{{ $errors->has('manufacturer') ? ' has-error' : '' }}">
                                <label for="manufacturer" class="col-md-3 control-label">Manufacturer</label>

                                <div class="col-md-9">
                                    <input id="manufacturer" type="text" class="form-control" name="manufacturer" value="{{ $product->productdetail->manufacturer }}" required>


                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('quntity') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-3 control-label">Quantity</label>

                                <div class="col-md-9">
                                    <input id="quntity" type="text" class="form-control" value="{{ $product->productdetail->quantity }}" name="quantity" required>

                                    @if ($errors->has('quntity'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('quntity') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="weight" class="col-md-3 control-label">Weight</label>

                                <div class="col-md-9">
                                    <input id="weight" type="text" class="form-control" value="{{ $product->productdetail->weight }}" name="weight" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-3 control-label">Description</label>

                                <div class="col-md-9">
                                    <textarea class="form-control" name="description" >{{ $product->productdetail->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endif
@endsection