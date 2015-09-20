# NodeJS
Examples to the NodeJS framework


How to use:

```
$ cd NodeJS/examples/{exampleName}
$ npm install
$ node server.js
```



## Sockets IO


### Server Side
Setup with NodeJS server
```js
var server = require('http').createServer();
server.listen(3000);	// port 3000

var io = require('socket.io')(server);	// create IO
io.on('connection', function(socket){
  socket.on('event', function(data){});
  socket.on('disconnect', function(){});
});

```



**Tracking connections**
```js

var connections = {};	// only object can be passed over .emit, not arrays!
var screens = {};	// save screen names

io.sockets.on('connection', function (socket) {

	/*
    socket: client that has just connected
    io.sockets: all connected clients
    */

	connections[socket.id] = socket;

    // new screen connected: add to list
    socket.on('init screen', function (screenName) {

        screens[socket.id] = screenName;

        var socket = clients[sId];
        socket.emit('show', {message: 'your have been connected'});

        // publish list to all remotes
        io.sockets.emit('refresh screens', screens);

    });

    socket.on('disconnect', function() {
      console.log('Got disconnect!');

      if (socket.id in connections ) {
        delete connections[i];
      }
    });

});
```

then you can later do something like this:
```js
var socket = clients[sId];
socket.emit('show', {});
```

### Client side

Include
```xml
<script src="/socket.io/socket.io.js"></script>
<script>
  var socket = io();
  // emit etc
</script>
```


Receiving and sending messages to server

```js
var socket = io('http://localhost');

// Listeners
socket.on('event', function(data){
	// do something with data
});

// Sending data from client to server
socket.emit('message', {'message': 'hello world'});

}

```