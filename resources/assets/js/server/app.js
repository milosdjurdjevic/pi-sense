const http = require('http');
const express = require('express');
const io = require('socket.io')(http);
const port = process.env.PORT || 30020;

const Redis = require('ioredis');
const redis = new Redis();

const rpiDhtSensor = require('rpi-dht-sensor');
const dht = new rpiDhtSensor.DHT11(22);

let app = express();
let server = http.createServer(app);

redis.subscribe('temperature-channel', function (err, data) {

});

redis.on('message', function(channel, message) {

    read();

    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

function read () {
    let readout = dht.read();

    console.log('Temperature: ' + readout.temperature.toFixed(0) + '*C, ' +
        'humidity: ' + readout.humidity.toFixed(0) + '%');
    // setTimeout(read, 1000);
}

server.listen(port, () => {
    console.log(`Server is up on ${port}`);
});