# NodeJS
Examples to the NodeJS framework


How to use:

```
$ cd NodeJS/examples/{exampleName}
$ npm install
$ node server.js
```



## Sockets IO

Setup with NodeJS server
```js
var server = require('http').createServer();
var io = require('socket.io')(server);	// create IO
io.on('connection', function(socket){
  socket.on('event', function(data){});
  socket.on('disconnect', function(){});
});
server.listen(3000);
```
### Events

```js
var io = require('socket.io')();
io.sockets.emit('an event sent to all connected clients');
io.emit('an event sent to all connected clients');	// the same
```

### Messages

**Sending**

```html
<script src="/socket.io/socket.io.js"></script>
<script>
  var socket = io();
  // emit etc
</script>
```

**Static/Instance call**
```js
// static call with current `socket` as input argument
io.sockets.on('connection', function (currentSocket) {
	currentSocket.emit('chat message', "my value goes in there");
});
io.sockets.emit('chat message', "my value goes in there");
```
```js
// call with IO instance
var socket = io();	// make connection
socket.emit('chat message', "my value goes in there");
```


**Selecting sockets to broadcast to**


```js
// everyone
socket.emit('chat message', "my value goes in there");
socket.emit('chat message', "my value goes in there");


// send to all
io.sockets.emit('this', { receivers: 'everyone'});
// equal
io.sockets.emit('this', { receivers: 'everyone'});
// equal

socket.broadcast.emit('this', { receivers: 'everyone but socket'}); //emits to everyone but socket
socket.emit('this', { receivers: 'socket'}); //emits to socket

io.sockets.emit('hi', 'everyone');
io.emit('hi', 'everyone'); // short form
```

**Sending to specific sockets**
```js
var socketio = require('socket.io');
var clients = {};	// only object can be passed over .emit, not arrays!

var io = socketio.listen(app);

io.sockets.on('connection', function (socket) {
  clients[socket.id] = socket;
  
   socket.on('disconnect', function() {
      console.log('Got disconnect!');

      if (socket.id in clients ) {
      	delete clients[i];
	  }
   });
});
```

then you can later do something like this:
```
var socket = clients[sId];
socket.emit('show', {});
```

**"Global" emits (without specific socket , outside connection loop**
```js
io.sockets.emit('user connected');
// with a room
io.sockets.in('m1').emit('user message', 'from', 'msg');
```

**Receiving**



```js
io.on('connection', function(socket){
  console.log('a user connected');
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
});
```

```js
socket.on('chat message', function(msg){
console.log('message: ' + msg);
});
```
or
```js
io.on('connection', function(socket){
  socket.on('chat message', function(msg){
    console.log('message: ' + msg);
  });
});
```






