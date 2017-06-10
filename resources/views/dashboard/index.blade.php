@extends('layouts.public')

@section('content')

    <div class="row">

        @include('partials.task-containers')

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <a href="{{route('dashboard.export')}}" class="btn btn-primary">Export Tasks</a>
                </div>
            </div>
        </div>
        
    </div>
@endsection
