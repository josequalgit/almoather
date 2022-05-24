const server = require('http').Server();

const Redis = require('ioredis');
const redis = new Redis();

// Create a new Socket.io instance
const io = require('socket.io')(server, {
    cors: {
        origin: "http://1270.0.0.1:8000",
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

    var onevent = socket.onevent;
    socket.onevent = function (packet) {
        var args = packet.data || [];
        onevent.call (this, packet);    // original call
        packet.data = ["*"].concat(args);
        onevent.call(this, packet);      // additional call to catch-all
    };

    
    console.log('connect');
    // redis.psubscribe('*',() => {
    //     console.log('Subscribe')
    // });

    socket.on('disconnect', function () {
        console.log('disconnect');
    });

    socket.on('*', function(event,data){
        console.log(event);
        console.log(data.message);
    });

    // redis.on('message', function (pattern, channel, message) {
    //     console.log(channel)
    //     console.log('p message: ' + message);
    //     message = JSON.parse(message);
    //     io.emit(channel, message);
    // });
});
io.on('error', function (err) {
    console.log(err);
});


