const config = require('./config');
const server = require('http').Server();

const Redis = require('ioredis');
const redis = new Redis();

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

server.listen(config.server.port, () => {
    console.log('listening on port 3000');
});

const usersOnline = {};


io.on("connect", (socket) => {
    console.log('connected');

    const clientsInRoom = io.in('support').allSockets()
    io.emit("get.online.users", clientsInRoom);


    var onevent = socket.onevent;
    socket.onevent = function (packet) {
        var args = packet.data || [];
        onevent.call(this, packet);
        packet.data = ["*"].concat(args);
        onevent.call(this, packet);
    };

    socket.on('disconnect', function () {
        console.log('disconnect');
        delete usersOnline[socket.id];
        socket.leave('support');
        io.emit("user.offline", socket.userId);
    });

    socket.on('*', function (event, data) {
        console.log('event: ' + event.includes('support'))
        if (event == 'user.online.save') {
            console.log('a user ' + data.userId + ' connected');
            socket.userId = data.userId;
            socket.join('support');
            io.emit("user.online", socket.user_id);

        } else {
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

            io.emit(event, data);
        }



    });
});
io.on('error', function (err) {
    console.log(err);
});


