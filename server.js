var server = require('http').Server();

var Redis = require('ioredis');
var redis = new Redis();

// Create a new Socket.io instance
var io = require('socket.io')(server, {
    cors: {
        origin: "http://192.168.1.143:8000",
        methods: ["GET", "POST"]
    }
});



server.listen(3000, () => {
    console.log('listening on port 3000');
});

io.on("connect", (socket) => {
    redis.psubscribe('*', () => {
        console.log('hellllllll')
    });

    redis.on('pmessage', function (pattern, channel, message) {
        console.log(pattern);
        console.log(channel);
        console.log(message);
        message = JSON.parse(message);
        io.emit(channel, message);
    });
});
io.on('error', function (err) {
    console.log(err);
});

