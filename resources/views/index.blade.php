<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        {{--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">

        <!-- Styles -->
{{--        <link rel="stylesheet" href="{{ asset('assets/materialize/css/materialize.min.css') }}">--}}
{{--        <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">--}}
{{--        <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
    </head>
    <body>
        <div id="app"></div>
        {{--<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>--}}
        {{--<script src="{{ asset('assets/materialize/js/materialize.min.js') }}"></script>--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js.map"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

