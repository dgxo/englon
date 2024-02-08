<?php
// session_start();
// if (!isset($_SESSION["username"])) {
//    header("Location: /account/login?reason=chat&to=" . $_SERVER['REQUEST_URI']);
//    die();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
   <link rel="stylesheet" href="stylesheet.css?v1.1.5">

   <script>
      var _paq = window._paq = window._paq || [];

      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= $_SESSION['username'] ?>']);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function () {
         var u = "//stats.englon.biz/";
         _paq.push(['setTrackerUrl', u + 'e']);
         _paq.push(['setSiteId', '1']);
         var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
         g.async = true; g.src = u + 'js/'; s.parentNode.insertBefore(g, s);
      })();
   </script>
   <!-- End Matomo Code -->
</head>

<body>
   <?php
   include('/var/www/html/englon/header.php');
   ?>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.1.2/socket.io.min.js"></script>
   <script src="index.js?v1.1.4"></script>

   <main>

      <div class="chat-wrapper">
         <div id="info">
            <p class="welcome">Welcome, <span class="name">
                  <?= htmlspecialchars($_SESSION['username']) ?>
               </span>.</p>
            <p class="dev"><a class="link" href="/discord">Join the NEW Discord!</a></p>
         </div>

         <div class="message-box">
            <div id="chat">
               <h3 style="text-align: center; align-self: center;">
                  Chat v2 is still a massive work in progress! Right now it's going through the design process but that
                  along with the functional code will be implemented soon.
                  <br>
                  <br>
                  Also I have no clue why the spacing here messed up lol.
               </h3>
            </div>
         </div>

         <div class="typing" style="display: none;">
            <svg height="40" width="40" class="typing-dots">
               <circle class="dot" cx="10" cy="20" r="3" style="fill:grey;"></circle>
               <circle class="dot" cx="19" cy="20" r="3" style="fill:grey;"></circle>
               <circle class="dot" cx="27" cy="20" r="3" style="fill:grey;"></circle>
            </svg>
            <div id="typing-name">
               <strong>User</strong> is typing...
            </div>
         </div>

         <form>
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
      </div>
      <div class="active-users-panel">
         <h3>Active Users</h3>
         <ul id="active-users">
            <li><img src="/images/avatars/<?= $_SESSION['avatar'] ?>">
               <?= $_SESSION['username'] ?>
            </li>
         </ul>
      </div>
   </main>
</body>

</html>