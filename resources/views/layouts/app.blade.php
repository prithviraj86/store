<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'STORE') }}</title>

    <!-- Styles

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    -->
    <link rel="stylesheet" href="/css/album.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--JS-->
    <!-- jQuery library -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
        function change_total(data)
        {
            $p_block="product_"+pid;
        }
       function  updatecart(pid,quantity,type)
        {


            var token = $('meta[name="csrf-token"]').attr('content');
            if(type=="desc")
            {
                $.ajax({

                    type:'POST',
                    url:"/cart/update",
                    dataType: 'JSON',
                    data: {
                        "_method": 'POST',
                        "_token": token,
                        "product_id": pid,
                        "quantity": 1,
                    },
                    success:function(data){
                        console.log('sucess');
                        console.log(data);

                        $("#table").load("data");
                    },
                    error:function(data){
                        console.log('error');
                        console.log(data);
                        console.log(data.length);
                        $("#table").load("data");
                    },
                });
                $("#quantity").html(parseInt($("#quantity").html())-1)
            }
            else if(type=="inc")
            {

                $.ajax({

                    type:'POST',
                    url:"/cart/store",
                    dataType: 'JSON',
                    data: {
                        "_method": 'POST',
                        "_token": token,
                        "product_id": pid,
                        "quantity": 1 ,
                    },
                    success:function(data){
                        console.log('sucess');
                        console.log(data);

                        $("#table").load("data");
                    },
                    error:function(data){
                        console.log('error');
                        console.log(data);
                        console.log(data.length);
                        $("#table").load("data");
                    },
                });
                $("#quantity").html(parseInt($("#quantity").html())+1)
            }


        }
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Store') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            <li><a href="/cart">Cart</a></li>
                        @else

                            @if(Auth::user()->is_admin==1)
                                <li><a href="/product/create">Add Product</a></li>
                            @endif
                            <li><a href="/cart">Cart</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->





</body>
</html>
