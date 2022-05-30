const config = require('./config');
if(config.environment == "https"){
    const https = require('https');
    const fs = require('fs');
    
    const options = {
      key: fs.readFileSync('/usr/local/psa/var/certificates/scfgAIOSS'),
      cert: fs.readFileSync('/usr/local/psa/var/certificates/scfgAIOSS'),  
    };

    const server = https.createServer(options).listen(config.server.port, () => {
        console.log('listening on port ' + config.server.port);
    });
}else{
    const server = require('http').Server();
    server.listen(config.server.port, () => {
        console.log('listening on port ' + config.server.port);
    });
}

const Redis = require('ioredis');

var sub = new Redis(config.redis.port, config.redis.url);

const mysql = require('mysql');
const connection = mysql.createConnection({
    host: config.db.host,
    user: config.db.user,
    password: config.db.password,
    database: config.db.database,
});

// Create a new Socket.io instance
const io = require('socket.io')(server, {
    cors: {
        origin: config.server.origin,
        methods: ["GET", "POST"]
    },
    transports: ['websocket'],
    upgrade: false
});

sub.psubscribe('*', function (data) {
    console.log('redis connected');
});

sub.on('pmessage', function (channel, message) {
    console.log(channel);
    console.log(message);
    io.emit(channel, message);
});

io.on("connect", (socket) => {
    console.log('connected');

    var onevent = socket.onevent;
    socket.onevent = function (packet) {
        var args = packet.data || [];
        onevent.call(this, packet);
        packet.data = ["*"].concat(args);
        onevent.call(this, packet);
    };

    socket.on('disconnect', function () {
        console.log('disconnect');
    });

    socket.on('*', function (event, data) {
        console.log('event: ' + event.includes('support'));
        if(event.includes('support')) {
            var CURRENT_TIMESTAMP = { toSqlString: function () { return 'CURRENT_TIMESTAMP()'; } };

            let messageData = {
                text: data.message,
                sender_id: data.sender_id,
                receiver_id: data.receiver_id,
                type: event.includes('support') ? 'support' : 'app',
                created_at: CURRENT_TIMESTAMP,
                updated_at: CURRENT_TIMESTAMP,
            };

            connection.query('INSERT INTO messages SET ?', messageData, function (error, results, fields) {
                if (error) throw error;
            });
        }

        io.emit(event, data);

    });
});
io.on('error', function (err) {
    console.log(err);
});
