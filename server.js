var server = require('http').Server();

var Redis = require('ioredis');
var redis = new Redis();

// Create a new Socket.io instance
var io = require('socket.io')(server, {
    cors: {
        origin: "http://192.168.1.143:8000",
        methods: ["GET", "POST"]
    },
    transports: ['websocket'],
    upgrade: false
});



server.listen(3000, () => {
    console.log('listening on port 3000');
});
const sockets = [];

io.on("connect", (socket) => {
    console.log(socket.handshake.query.param);
    if (sockets.length < 2) {
        sockets.push(redis);

    }



    socket.on('disconnect', function (pattern, channel, message) {
        socket.leave(channel);

        redis.punsubscribe(() => {
            console.log('unsubscribe')
        });
    })



    redis.on('pmessage', function (pattern, channel, message) {
        console.log(channel)

        console.log('p message: ' + message);
        message = JSON.parse(message);
        io.emit(channel, message);
    });
    // redis.on('moather_database_message.user-5', function (pattern, channel, message) {
    //     // console.log(pattern);
    //     // console.log(channel);
    //     console.log(message);
    //     message = JSON.parse(message);
    //     io.emit(channel, message);
    // });
});
io.on('error', function (err) {
    console.log(err);
});


