var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server, {
    cors: {
      origin: "http://127.0.0.1:8000",
      methods: ["GET", "POST"]
    }
});
var redis = require('redis');
 
server.listen(8890, '127.0.0.1', function() {
    console.log('Listening on your port');
});

io.on('connection', function (socket) {
 
    console.log("client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('message');
 
    redisClient.on("message", function(channel, data) {
        console.log(channel);
        console.log(data);
        socket.emit(channel, data);
    });
 
    socket.on('disconnect', function() {
        redisClient.quit();
    });
});