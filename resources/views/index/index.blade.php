@extends('layouts.public')

@section('content')
<div class="row">
    <div class="col-xs-12">
        
    <div class="jumbotron">
        <h1>Hello, Taskmanager!</h1>
        <a href="{{route('register') }}" class="btn btn-success"> Create Account </a>
    </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4">
      <h2>Create Tasks</h2>
      <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
    </div>

    <div class="col-md-4">
      <h2>Track Progress</h2>
      <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
    </div>

    <div class="col-md-4">
      <h2>Export in EXCEL</h2>
      <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
      <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
    </div>    

</div>
@endsection