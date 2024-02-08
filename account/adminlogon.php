<?php session_start(); ?>

<head>
   <!-- alright PLEASE get out now -->
   <title>Admin Logon</title>
   <link rel="stylesheet" href="stylesheet.css">
   </link>
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
   include("/var/www/html/englon/header.php");
   ?>

   <?php
   $pass = isset($_POST['pass']) ? $_POST['pass'] : false;
   error_log('Address ' . $_SERVER['REMOTE_ADDR'] . ' gave password ' . $pass);
   $correct = $pass == "joe2LMAO";

   if ($correct) {
      $_SESSION['admin'] = true;
      ?>
      <main>
         <p>you got it right.</p>
         <p>have fun:</p>
         <a href="/account/adminer" class="button">Adminer</a>
         <a href="/account/admin" class="button">Admin Panel</a>
         <a href="/chat" class="button">Chat</a>
         <a href="/account/dashboard" class="button">Dashboard</a>
      </main>
      <?php
   } else { ?>
      <main>
         <h1>Admin Logon</h1>
         <?php
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<p class="error">INCORRECT!</p>';
         }
         ?>
         <form method="POST" action="admin_logon.php" class="admin-logon">
            <input type="password" name="pass" placeholder="Password"></input>
            <input type="submit" name="submit" value="Submit"></input>
         </form>
      </main>
      <?php
   }
   ?>
</body>