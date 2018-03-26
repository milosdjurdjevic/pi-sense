@extends('master')

@section('content')
    <p id="power">0</p>
@stop

@section('footer')
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://localhost:3000');
        socket.on("test-channel:App\\Events\\ReadTemperatureEvent", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
    </script>
@stop