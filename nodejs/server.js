var express = require('express'),
    app = express(),
    http = require('http'),
    server = http.createServer(app)
    io = require('socket.io').listen(server),
    request = require("request");

var players = [];
var settings = require('./settings');

app.use(express.bodyParser());
server.listen(8000);

app.get('/', function (req, res) {
    res.send(404);
});

app.post('/message/:action/:gid/:uid', function (req, res) {
    player = getPlayer(req.params.uid,req.params.gid);
    if (player) {
        player.socket.emit(req.params.action, req.body);
        res.send(200);
    }
    else
        res.send(404);
});

io.sockets.on('connection', function (socket) {
    var player = addPlayer(null, null, socket);
    console.log("MG add player with socket id: " + socket.id);
    socket.on('register', function (secret,gid) {
        player.secret = secret;
        player.gid = gid;
        checkSecret(player);
    });
    socket.on('reconnect', function (secret) {
        player.secret = secret;
        checkSecret(player);
        console.log("MG Reconnect: " + secret);
    });
    socket.on('disconnect', function () {
        removePlayer(player);
        if (player.sid != null) {
            var uri = settings.mgapi + 'multiplayer/disconnect/uid/' + player.uid + '/gid/' + player.gid + '/';
            request({
                uri:uri,
                method:"GET"
            }, function (error, response, body) {
            });
        }
        console.log("MG DISCONNECT: " + player.secret);
    });
});

function checkSecret(player) {
    var uri = settings.mgapi + 'multiplayer/validateSecret/secret/' + player.secret + '/';
    request({
        uri:uri,
        method:"GET"
    }, function (error, response, body) {
        switch (response.statusCode) {
            case 200:
                var res = JSON.parse(body);
                player.sid = res.sid;
                break;
            case 404:
                player.socket.disconnect();
                console.log(body);
                break;
        }
    });
}

function addPlayer(uid, secret, socket,gid) {
    var player = {
        uid:uid,
        gid:gid,
        secret:secret,
        socket:socket
    };
    players.push(player);
    return player;
}

function removePlayer(player) {
    for (var i = 0; i < players.length; i++) {
        if (player.socket.id === players[i].socket.id) {
            players.splice(i, 1);
            return;
        }
    }
}

function getPlayer(uid,gid) {
    for (var i = 0; i < players.length; i++) {
        if (uid == players[i].uid && gid == players[i].gid) {
            return players[i];
        }
    }
    return null;
}


