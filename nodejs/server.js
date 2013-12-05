var express = require('express'),
    app = express(),
    http = require('http'),
    server = http.createServer(app)
    io = require('socket.io').listen(server),
    request = require("request");

var players = [];
var settings = require('./settings');

server.listen(8000);

// If using HTTPS, replace above listed above with the following
// START
// var express = require('express');
// var https = require('https');
// var fs = require('fs');
//
// // This line is from the Node.js HTTPS documentation.
// var options = {
//   key: fs.readFileSync('/home/website/tf1-key.pem'),
//   cert: fs.readFileSync('/home/website/tf1-cert.pem')
// };
//
// // Create a service (the app object is just a callback).
// var app = express();
//
// // Create an HTTPS service identical to the HTTP service.
// var server = https.createServer(options, app);
// var io = require('socket.io').listen(server),
// 	request = require("request");
//
// server.listen(8000, "0.0.0.0");
//
//
// var players = [];
// var settings = require('./settings');
// END

app.use(express.bodyParser());

app.get('/', function (req, res) {
    res.send(404);
});

app.post('/message/:action/:gid/:uid', function (req, res) {
    var player = getPlayer(req.params.uid,req.params.gid);
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
    socket.on('reconnect', function (secret,gid) {
        player.secret = secret;
        player.gid = gid;
        checkSecret(player);
        console.log("MG Reconnect: " + secret);
    });
    socket.on('disconnect', function () {
        removePlayer(player);
        if (player.uid != null) {
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
                player.uid = res.uid;
                break;
            case 404:
                player.socket.emit("registerFailure", body);
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


