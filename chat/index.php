<?php
session_start();
if (!isset($_SESSION["username"])) {
   header("Location: /account/login?reason=chat&to=" . $_SERVER['REQUEST_URI']);
   http_response_code(302);
   die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"
      integrity="sha256-/H4YS+7aYb9kJ5OKhFYPUjSJdrtV6AeyJOtTkw6X72o=" crossorigin="anonymous"></script>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="Content-Type" content="text/html">

   <title>Untitled document - Google Docs</title>
   <meta name="description" content="Tools & Utilities">

   <meta property="og:title" content="Englon">
   <meta property="og:description" content="Tools & Utilities">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://englon.biz/chat">

   <script async src="/common.js"></script>
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="stylesheet.css?v1.1.8">
</head>

<body>
   <?php
   include('/var/www/html/englon/header.php');
   ?>
   <main>
      <!-- Matomo -->
      <script>
         var _paq = window._paq = window._paq || [];

         _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= $_SESSION['username'] ?>']);
         _paq.push(['trackPageView']);
         _paq.push(['enableLinkTracking']);
         _paq.push(['enableJSErrorTracking']);
         (function () {
            var u = "//stats.englon.biz/";
            _paq.push(['setTrackerUrl', u + 'e']);
            _paq.push(['setSiteId', '1']);

            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true; g.src = u + 'js/'; s.parentNode.insertBefore(g, s);
         })();
      </script>
      <!-- End Matomo Code -->

      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.2/socket.io.min.js"></script>
      <script>
         const userId = <?= "" . $_SESSION['id'] . "" ?? 'null' ?>; // ID from session or null
         const socket = io('/', { path: '/chat/activecheck' });

         socket.on('connect_error', err => handleConnectionError(err))
         socket.on('connect_failed', err => handleConnectionError(err))
         socket.on('disconnect', err => handleConnectionError(err))

         function handleConnectionError(err) {
            const activeUsersList = document.getElementById('active-users');
            activeUsersList.innerHTML = '<li class="error">An error occurred with the websocket connection: "' + err + '." Report this!</li>';
            console.error(err)
         }

         // Emit an event to the server when the user accesses the chat page
         socket.emit('userConnected', { userId });

         // Handle the logout event, sent to a user when their presence is no longer wanted
         socket.on('logout', (reason) => {
            alert(`You have been logged out due to ${reason}.`);
            window.location.href = '/account/logout';
         })

         // Handle the typing event, sent to all users if someone is typing
         socket.on('typing', (username) => {
            console.log(`${username} is typing`);
            setTyping(true, username);
            // Lasts for 5 seconds, so if a user is typing the event will be sent out every 4s or similar to avoid flashing from loading times
            // A message sent by that user should really stop the typing but without a rewrite that's difficult
            setTimeout(() => {
               setTyping(false);
            }, 5000)
         })

         // Handle the updated active users list on the client side.
         socket.on('usersUpdate', (activeUsers) => {
            try {
               // encrypted array of objects
               let decrypted = CryptoJS.AES.decrypt(
                  activeUsers,
                  (function () {
                     // have fun with the obfuscation it's really not that well made
                     var Y = Array.prototype.slice.call(arguments),
                        y = Y.shift();
                     return Y.reverse()
                        .map(function (C, B) {
                           return String.fromCharCode(C - y - 6 - B);
                        })
                        .join('');
                  })(12, 144, 60, 143, 65, 135, 129, 120, 54, 136, 125, 123, 134) +
                  (66858271429).toString(36).toLowerCase() +
                  (16)
                     .toString(36)
                     .toLowerCase()
                     .split('')
                     .map(function (S) {
                        return String.fromCharCode(S.charCodeAt() + -71);
                     })
                     .join('') +
                  (29).toString(36).toLowerCase() +
                  (function () {
                     var Z = Array.prototype.slice.call(arguments),
                        A = Z.shift();
                     return Z.reverse()
                        .map(function (L, u) {
                           return String.fromCharCode(L - A - 50 - u);
                        })
                        .join('');
                  })(54, 224, 140, 208, 204, 137, 215) +
                  (669843).toString(36).toLowerCase() +
                  (function () {
                     var N = Array.prototype.slice.call(arguments),
                        M = N.shift();
                     return N.reverse()
                        .map(function (O, b) {
                           return String.fromCharCode(O - M - 14 - b);
                        })
                        .join('');
                  })(11, 126)
               ).toString(CryptoJS.enc.Utf8)
               decrypted = JSON.parse(decrypted);

               // Loop through the activeUsers array and create and append li elements for each user
               const activeUsersList = document.getElementById('active-users');
               activeUsersList.innerHTML = '';
               for (let i = 0; i < decrypted.length; i++) {
                  const user = decrypted[i];
                  const li = document.createElement('li');

                  const img = document.createElement('img');
                  img.src = '/images/avatars/' + user.avatar;
                  li.appendChild(img);
                  li.innerHTML += ' ' + user.username;

                  activeUsersList.appendChild(li);
               }
            } catch (e) {
               const activeUsersList = document.getElementById('active-users');
               activeUsersList.innerHTML += '<p class="error">Error: ' + e + '</p>';
            }
         });</script>
      <script src="index.js?v1.1.3"></script>

      <div class="chat-wrapper">
         <div id="info">
            <p class="welcome">Welcome, <span class="name">
                  <?= empty($_SESSION['username']) ? 'Guest' : htmlspecialchars($_SESSION['username']) ?>
               </span>.</p>
            <p class="dev"><a class="link" href="/discord">Join the NEW Discord!</a></p>
         </div>
         <div class="stupid-firefox">
            <div id="message-box">
               <?php
               // if (file_exists("log.html") && filesize("log.html") > 0) {
               //    $contents = file_get_contents("log.html");
               //    echo $contents;
               // }
               ?>
               <h3>Loading chat...</h3>
            </div>
         </div>
         <iframe name="hidden-iframe" style="display: none;"></iframe>
         <div class="typing" style="display: none;">
            <svg height="40" width="40" class="typing-dots">
               <circle class="dot" cx="10" cy="20" r="3" style="fill:grey;"></circle>
               <circle class="dot" cx="19" cy="20" r="3" style="fill:grey;"></circle>
               <circle class="dot" cx="27" cy="20" r="3" style="fill:grey;"></circle>
            </svg>
            <div class="typing-name">
               <strong>Mr Englon</strong> is typing...
            </div>
         </div>
         <form action="/chat/post" target="hidden-iframe" enctype="multipart/form-data" method="post"
            onsubmit="return validateForm()">
            <div class="user-panel">
               <label role="button" class="add-file" for="fileinput">
                  <svg xmlns="http://www.w3.org/2000/svg" height="0.7em" viewBox="0 0 448 512">
                     <!-- From Font Awesome-->
                     <path fill="#FFF"
                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z">
                  </svg>
               </label>
               <input type="file" name="file" id="fileinput" style="display: none">
               <input type="text" name="text" id="usermsg" maxlength="500" max="500" required autocomplete="off"
                  autofocus />
               <input type="submit" name="submit" id="send-message" value="Send">
            </div>
         </form>
         <?php if (isset($_SESSION['admin'])) { ?>
            <div class="manage">
               <label for="update">Update</label>
               <input id="update" type="checkbox" checked>
               <button id="clear-chat" onclick="sendAdminRequest('clear-chat')">Clear Chat</button>
               <button id="del-msg" onclick="sendAdminRequest('del-msg')">Delete Last Msg</button>
               <button id="del-msgs" onclick="sendAdminRequest('del-msgs')">Delete Msgs</button>
               <button id="logout-user" onclick="sendAdminRequest('logout-user')">Logout User</button>
            </div>
         <?php } ?>
      </div>
      <div class="active-users-panel">
         <h3>Active Users</h3>
         <ul id="active-users">
            <li><img src="/images/avatars/<?= $_SESSION['avatar'] ?>">
               <?= empty($_SESSION['username']) ? 'Guest' : htmlspecialchars($_SESSION['username']) ?>
            </li>
         </ul>
      </div>
   </main>
</body>

</html>