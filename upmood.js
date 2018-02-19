var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis({

    host: 'localhost',
    port: 6379,
    password: 'c0mm0NR3d!sP@s$w0rDPl3@$ed0n++rYT#!s@t#0m3m0n!+0rl@nGd!p@m@b!IeD3ym!+#0mYg0$#',
    db: 5

});

redis.subscribe('private-notification');

redis.on('message', function (channel, data) {

    message = JSON.parse(data);
    io.emit(message.data.channel, message.data); 

});


server.listen(8011);