@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-11">
                <h3 class="title">Add Category</h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @if(isset($editdata) and count($editdata)>0)
                    <form class="form-horizontal" method="POST" action="/category/update" enctype="multipart/form-data">
                @else
                    <form class="form-horizontal" method="POST" action="/category/store" enctype="multipart/form-data">
                @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-row">
                            <label for="name" class="col-md-1 control-label">Name</label>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">


                                <div class="">
                                    @if(isset($editdata) and count($editdata)>0)
                                        <input id="id" type="hidden"  name="id" value="{{ $editdata['id'] }}" required autofocus>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $editdata['name'] }}" required autofocus>
                                    @else
                                        <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                                    @endif


                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <br>
                                   @if(isset($editdata) and count($editdata)>0)
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    @else
                                        <button type="submit" class="btn btn-primary">Save</button>

                                    @endif


                            </div>
                            </div>



                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col"></th>

                                </tr>
                                </thead>
                                <tbody>
                                @if(count($catdata)>0)
                                    @foreach($catdata as $data)
                                    <tr>
                                        <th scope="row">{{$data['id']}}</th>
                                        <td>{{$data['name']}}</td>
                                        <td style="width: 200px;">
                                           <a href="/category/edit/{{$data['id']}}"><button class="btn btn-success" type="button">Edit</button></a>
                                           <a href="/category/delete/{{$data['id']}}"> <button class="btn btn-danger" type="button">Delete</button></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                        </div>
                    </div>


                </form>

            </div>
        </div>
    </div>
@endsection