<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    
    <link href="{{ asset('css/todo.css') }}" rel="stylesheet">


</head>
<body>
    {{-- Sidebar Navigation --}}
    @include('partials.navbar')

    <div class="container" id="main">

        {{-- Display Flash Messages if any --}}
        @foreach(['info', 'success', 'danger', 'warning'] as $msgType)
            @if(Session::has($msgType))
            <p class="alert alert-{{$msgType}}">{{Session::get($msgType)}}</p>
            @endif
        @endforeach

        {{-- Display main content --}}
        @yield('content')
    </div>

    @include('partials.modals');
    
    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://use.fontawesome.com/c010433348.js"></script>

    <script src="{{ asset('js/notify.min.js') }}"></script>

    <script src="{{ asset('js/todo.js') }}"></script>
</body>
</html>
