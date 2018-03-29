const http = require('http');
const express = require('express');
const socketIO = require('socket.io');
const { exec } = require('child_process');
const axios = require('axios');

const Redis = require('ioredis');
const redis = new Redis();

const rpiDhtSensor = require('rpi-dht-sensor');
const dht = new rpiDhtSensor.DHT11(22);

const port = process.env.PORT || 3000;

let app = express();
let server = http.createServer(app);
let io = socketIO(server);

io.on('connection', (socket) => {
    console.log('socket')
});

redis.subscribe('temperature-channel', function (err, data) {
    console.log('redis subscribed')
});

redis.on('message', (channel, message) => {
    exec('cd /home/pi/Code/resources/assets/python && ./readings.py', (err, stdout, stderr) => {
        if (err) {
            // node couldn't execute the command
            console.log(err);
        }

        // the *entire* stdout and stderr (buffered)
        console.log(`stdout: ${stdout}`);
        console.log(`stderr: ${stderr}`);
    });
});

function read () {
    let readout = dht.read();

    return {
        temperature: readout.temperature.toFixed(0),
        humidity: readout.humidity.toFixed(0),
    };
    // setTimeout(read, 1000);
}

server.listen(port, () => {
    console.log(`Server is up on ${port}`);
});