/*
var socket = require('socket.io-client')('http://localhost');
socket.on('connect', function(){
	console.log('a user connected');
});
socket.on('event', function(data){});
socket.on('disconnect', function(){});

var server = require('http').createServer();
var io = require('socket.io')(server);
io.on('connection', function(client){
  console.log('a user connected');
  client.on('event', function(data){});
  client.on('disconnect', function(){});
});
server.listen(3000, function(){
  console.log('listening on *:3000');
});

//create websocket protocol via socket.io
var io = require('socket.io').listen(8080);
//send data to client
io.sockets.on('connection', function(socket) {
  socket.on('message_to_server', function(data) {
    io.sockets.emit("message_to_client",{ message: data["message"] });
  });
});
*/

var server = require('http');
var io = require('socket.io')(server);

var hostname = '127.0.0.1';
var port = 8080;

io.on('connection', function(socket){
  console.log('a user connected');
    socket.on('login', function(username) {
        console.log('[login]', username);
    });
});

var server = server.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain');
  res.end('Hello to the World\n');
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});
