// service file is chatactiveusers, so reload that when changes are made

const mysql = require('mysql');
const AES = require('crypto-js/aes');
const io = require('socket.io')(2683, {
   path: '/'
});
console.log('Listening on 2683');

const connection = mysql.createConnection({
   host: 'localhost',
   user: 'phpmysql',
   password: "j%XNr&P'j!#~89@",
   database: 'englon'
});

let users = {};

/**
 * Retrieves the username and avatar of a user based on their user ID.
 *
 * @param {number} userId - The user ID of the user.
 * @return {Promise<object>} A Promise that resolves to an object containing the username and avatar of the user.
 */
function getUserDetails(userId) {
   const query = `SELECT username, avatar FROM users WHERE id = ?`;
   return new Promise((resolve, reject) => {
      connection.query(query, [userId], function (error, results, fields) {
         if (error) reject(error);
         else
            resolve({
               username: results[0].username == '' || results[0].username == ' ' ? 'Guest' : results[0].username,
               avatar: results[0].avatar
            });
      });
   });
}

async function getActiveUsers() {
   try {
      const activeUsers = await Promise.all(
         Object.keys(users).map(async (userId) => {
            try {
               const details = await getUserDetails(userId);
               return details;
            } catch (error) {
               console.error('Error fetching user details:', error);
               return null;
            }
         })
      );

      const filteredUsers = activeUsers.filter((user) => user !== null);

      return filteredUsers;
   } catch (error) {
      console.error('Error getting active users:', error);
      throw error;
   }
}

// Event handler for when a client connects
io.on('connection', (socket) => {
   // Event handler for the "userConnected" event
   socket.on('userConnected', (data) => {
      console.log(`New user:          ${socket.id}, user ID: ${data.userId}`);

      users[data.userId] = socket.id;

      getActiveUsers()
         .then((activeUsers) => {
            activeUsers = AES.encrypt(JSON.stringify(activeUsers), "this ain't supposed to be secure").toString();
            io.emit('usersUpdate', activeUsers);
         })
         .catch((error) => {
            console.error('Error:', error);
         });
   });

   socket.on('logoutUser', (data) => {
      console.log(`User logout requested: ${data.userId} for ${data.reason}`);
   });

   // Event handler for when the client disconnects
   // Event handler for when the client disconnects
   socket.on('disconnect', () => {
      let disconnectedUserId = null;

      // Find the disconnected user's ID
      Object.entries(users).forEach(([userId, socketId]) => {
         console.log(`User disconnected: ${socket.id}, user ID: ${userId}`);
         if (socketId === socket.id) {
            disconnectedUserId = userId;
            return;
         }
      });

      if (disconnectedUserId) {
         delete users[disconnectedUserId];

         getActiveUsers()
            .then((activeUsers) => {
               activeUsers = AES.encrypt(JSON.stringify(activeUsers), "this ain't supposed to be secure").toString();
               io.emit('usersUpdate', activeUsers);
            })
            .catch((error) => {
               console.error('Error:', error);
            });
      }
   });
});
