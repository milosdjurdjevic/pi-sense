const fs = require('fs');
const http = require('http');
const express = require('express');
const socketIO = require('socket.io');
const Redis = require('ioredis');
const redis = new Redis();

const { exec } = require('child_process');
const port = process.env.PORT || 8080;

const app = express();
// const options = {
//     key: fs.readFileSync('/etc/nginx/ssl/nginx.key'),
//     cert: fs.readFileSync('/etc/nginx/ssl/nginx.crt'),
//     // ca: fs.readFileSync('/etc/nginx/ssl/nginx.crt'),
//     rejectUnauthorized: false,
// };

const server = http.createServer(app);
const io = socketIO.listen(server);

redis.subscribe('temperature-channel', function (err, data) {
    console.log('redis subscribed')

    io.sockets.on( 'connection', function( socket ) {
        console.log('Socket connected')
    });

    redis.on('message', (channel, message) => {
        exec('/home/pi/Code/resources/assets/python/readings.py', (err, stdout, stderr) => {
            if (err) {
                io.emit('err', err);
                console.log(err)
            } else if (stderr) {
                io.emit('stderr', stderr);
                console.log(stderr)
            } else {
                io.emit('reading', stdout);
                console.log(stdout)
            }
        });
    });

});

app.get('/node/reading', (req, res) => {
    exec('cd /home/pi/Code/resources/assets/python && ./readings.py', (err, stdout, stderr) => {
        if (err) {
            res.send('err', err);
            console.log(err);
        } else if (stderr) {
            res.send('stderr', stderr);
            console.log(stderr);
        } else {
            res.send(stdout);
            console.log(stdout);
        }
    });
});

app.get('/node/turn-on-led', (req, res) => {

});

app.get('/node/turn-off-led', (req, res) => {

});


server.listen(port, () => {
    console.log(`Server is up on ${port}`);
});