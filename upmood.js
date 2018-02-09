var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis({

    host: 'localhost',
    port: 6379,
    password: null,
    db: 5

});

redis.subscribe('private-notification');

redis.on('message', function (channel, data) {

    message = JSON.parse(data);
    io.emit(message.data.channel, message.data); 

});


server.listen(6379);