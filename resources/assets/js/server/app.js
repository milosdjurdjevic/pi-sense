const http = require('http');
const express = require('express');
const socketIO = require('socket.io');
const Redis = require('ioredis');
const redis = new Redis();

const { exec } = require('child_process');
const port = process.env.PORT || 3000;

const app = express();
const server = http.createServer(app);

const io = socketIO.listen(server);

redis.subscribe('temperature-channel', function (err, data) {
    console.log('redis subscribed')

    io.sockets.on( 'connection', function( socket ) {
        console.log('Socket connected')
    });

    redis.on('message', (channel, message) => {
        exec('cd /home/pi/Code/resources/assets/python && ./readings.py', (err, stdout, stderr) => {
            if (err) {
                io.emit('err', err);
            } else if (stderr) {
                io.emit('stderr', stderr);
            } else {
                io.emit('reading', stdout);
            }
        });
    });

});

app.get('/reading', (req, res) => {
    exec('cd /home/pi/Code/resources/assets/python && ./readings.py', (err, stdout, stderr) => {
        if (err) {
            res.send('err', err);
            console.log(err);
        } else if (stderr) {
            res.send('stderr', stderr);
            console.log(stderr);
        } else {
            res.send(stdout)
            console.log(stdout);
        }
    });
});

server.listen(port, () => {
    console.log(`Server is up on ${port}`);
});