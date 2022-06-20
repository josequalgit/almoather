const config = require('./config');
let server = null;
if (config.environment == "https") {
    const https = require('https');
    const fs = require('fs');

    const options = {
        key: fs.readFileSync('scfgAIOSS'),
        cert: fs.readFileSync('scfgAIOSS'),
    };

    server = https.createServer(options).listen(config.server.port, () => {
        console.log('listening on port ' + config.server.port);
    });
} else {
    console.log('test env:')
    server = require('http').Server();

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

sub.psubscribe('*', function(data) {
    console.log('redis connected');
});

sub.on('pmessage', function(event, channel, message) {
    console.log('channel: ' + channel);
    console.log('message: ' + message);

    io.emit(channel, message);
});

io.on("connect", (socket) => {
    console.log('connected');

    var onevent = socket.onevent;
    socket.onevent = function(packet) {
        var args = packet.data || [];
        onevent.call(this, packet);
        packet.data = ["*"].concat(args);
        onevent.call(this, packet);
    };

    socket.on('disconnect', function() {
        console.log('disconnect');
    });

    socket.on('*', async function(event, data) {
        console.log('event: ' + event.includes('support'));
        console.log('event2: ' + event);
        if (event.includes('support') || event.includes('user-')) {
            var CURRENT_TIMESTAMP = { toSqlString: function() { return 'CURRENT_TIMESTAMP()'; } };
            console.log(data.contentType)
            let messageData = {
                text: data.message,
                sender_id: data.sender_id,
                receiver_id: data.receiver_id,
                type: event.includes('support') ? 'support' : 'app',
                contentType: data.contentType || 'text',
                created_at: CURRENT_TIMESTAMP,
                updated_at: CURRENT_TIMESTAMP,
            };

            console.log(messageData);

            connection.query('INSERT INTO messages SET ?', messageData, function(error, results, fields) {
                if (error) throw error;
            });
        }
        let numberOfMessages = 0;
        connection.query("SELECT COUNT(id) As number FROM messages WHERE is_read = 0 and type='support';", function(err, result) {
            numberOfMessages = result ? result[0].number : 0;
            io.emit('supportMessages', numberOfMessages);
            io.emit(event, data);
        });

    });
});
io.on('error', function(err) {
    console.log(err);
});