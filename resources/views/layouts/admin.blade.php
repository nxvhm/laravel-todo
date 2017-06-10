<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">    

    <title>Task Manager Admin</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Administrator</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li><a href="{{route('admin.users')}}">Users</a></li>
            <li><a href="{{route('admin.deleteRequests.show')}}">Delete Requests</a></li>            
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li class="active"><a href="#">{{Auth::user()->name}}</a></li>
            <li><a href="{{route('dashboard')}}"><i class="fa fa-arrow-right"></i> TaskManager</a></li>            
          </ul>          
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="main">

        {{-- Display Flash Messages if any --}}
        @foreach(['info', 'success', 'danger', 'warning'] as $msgType)
            @if(Session::has($msgType))
            <div class="col-xs-12 mt20">
            <p class="alert alert-{{$msgType}}">{{Session::get($msgType)}}</p>
            </div>
            @endif
        @endforeach

      <div class="starter-template">
        @yield('content')
      </div>

    </div><!-- /.container -->

    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://use.fontawesome.com/c010433348.js"></script>
  </body>
</html>