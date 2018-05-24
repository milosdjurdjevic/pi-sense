const fs = require('fs');
const http = require('http');
const express = require('express');
const socketIO = require('socket.io');
const Redis = require('ioredis');
const redis = new Redis();

const Gpio = require('onoff').Gpio;
const LED = new Gpio(4, 'out');

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

app.get('/node/blink', (req, res) => {

    LED.writeSync(1);

    // let blinkInterval = setInterval(blinkLED, 250);
    setTimeout(function () {
        LED.writeSync(0)
        LED.unexport();
    }, 5000); //stop blinking after 5 seconds

    // function blinkLED() { //function to start blinking
    //     if (LED.readSync() === 0) { //check the pin state, if the state is 0 (or off)
    //         LED.writeSync(1); //set pin state to 1 (turn LED on)
    //     } else {
    //         LED.writeSync(0); //set pin state to 0 (turn LED off)
    //     }
    // }
    //
    // function endBlink() { //function to stop blinking
    //     clearInterval(blinkInterval); // Stop blink intervals
    //     LED.writeSync(0); // Turn LED off
    //     LED.unexport(); // Unexport GPIO to free resources
    // }
});



server.listen(port, () => {
    console.log(`Server is up on ${port}`);
});