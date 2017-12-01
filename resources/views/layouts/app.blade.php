<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'STORE') }}</title>





    <!--JS-->
    <!-- jQuery library -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/album.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

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
        <nav class="navbar navbar-toggleable-md navbar-light  navbar-static-top">
                <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01" >

                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Store') }}
                    </a>

                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav justify-content-end conte">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                            <li class="nav-item"><a href="/cart" class="nav-link">Cart</a></li>
                        @else

                            @if(Auth::user()->is_admin==1)
                                <li class="nav-item"><a href="/category" class="nav-link">Category</a></li>
                                <li class="nav-item"><a href="/product" class="nav-link">Product</a></li>
                            @endif
                            <li class="nav-item"><a href="/cart" class="nav-link">Cart</a></li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

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
