<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
    </head>
    <body>
        <div id="app"></div>
{{--        <script src="{{ secure_asset('js/socket.io.js') }}"></script>--}}
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

