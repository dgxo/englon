const socket = new WebSocket('ws://localhost:2249');

// Event handler for when the socket connection is established
socket.onopen = () => {
   console.log('Connected to WebSocket server');

   // Send authentication message
   const authMessage = {
      type: 'authenticate',
      token: 'your-auth-token'
   };
   socket.send(JSON.stringify(authMessage));
};

// Event handler for incoming messages from the server
socket.onmessage = (event) => {
   console.log('Received message:', event.data);

   // Handle the incoming message and update the UI
   const message = JSON.parse(event.data);
   // Update the chat UI with the message content
   // ...
};

// Event handler for when the socket connection is closed
socket.onclose = () => {
   console.log('Disconnected from WebSocket server');
};

// Event handler for errors in the socket connection
socket.onerror = (error) => {
   console.error('WebSocket error:', error);
};

// Function to send a message to the server
function sendMessage(text) {
   const message = {
      type: 'message',
      text: text
   };
   socket.send(JSON.stringify(message));
}

// Example usage: send a message to the server
sendMessage('Hello, server!');