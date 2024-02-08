const mysql = require('mysql');
const AES = require('crypto-js/aes');
const io = require('socket.io')(2249, {
   path: '/'
});
console.log('Listening on 2249');

const connection = mysql.createConnection({
   host: 'localhost',
   user: 'phpmysql',
   password: "j%XNr&P'j!#~89@",
   database: 'englon'
});
 
let users = {};
let messages = [];

// Connect to MySQL database
connection.connect((err) => {
   if (err) {
      console.error('Error connecting to MySQL database:', err);
      return;
   }
   console.log('Connected to MySQL database');
});

// Fetch messages from mysql chat table
function getMessages() {
   const query = 'SELECT * FROM chat LIMIT 50';
   connection.query(query, (error, results) => {
      if (error) {
         console.error('Error fetching messages:', error);
         return;
      }

      console.log('Fetched messages successfully');

      results.forEach(message => {
         messages.push(new Message(
            message.author,
            message.messageid,
            message.timestamp,
            message.contents,
            message.attachment,
            message.embed,
            message.type
         ));
      });
   });
};

console.log('Messages:', getMessages())

// Defining classes

class Message {
   constructor(author, messageid, timestamp, contents, attachment, embed, type) {
      this.author = author;
      this.messageid = messageid;
      this.timestamp = timestamp;
      this.contents = contents;
      // attachment and embed are optional
      this.attachment = attachment;
      this.embed = embed;
      // type: 0 is default, 1 is join message, 2 is discord message, 3 is system message
      this.type = type;
   }
}

// Socket.io connection event
io.on('connection', (socket) => {
   console.log('New client connected:', socket.id);

   // Handle user authentication
   socket.on('authenticate', (data) => {
      const { id, password_hash } = data;

      let username = null;

      // check the hash with the database and get username
      connection.query('SELECT username FROM users WHERE id = ? AND password = ?', [id, password_hash], (error, results) => {
         if (error || results.length > 1) {
            console.error('Error authenticating user:', error);
            socket.emit('authenticationFailed');
            return;
         }

         if (results.length === 0) {
            console.log('Authentication failed');
            socket.emit('authenticationFailed');
            return;
         }

         // Authentication successful
         console.log('Authentication successful');
         username = results[0].username
      })

      // Auth successful
      users[socket.id] = {
         id,
         username
      };
      socket.emit('authenticated');
   });

   // Handle chat messages
   socket.on('chatMessage', (message) => {
      console.log('Received chat message:', message);

      // Broadcast the message to all connected clients
      io.emit('chatMessage', {
         author: users[socket.id],
         message: message
      });
   });

   // Handle disconnections
   socket.on('disconnect', () => {
      console.log('Client disconnected:', socket.id);
      delete users[socket.id];
   });
});