<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ignore_user_abort(true);
set_time_limit(0);

session_start();
// if (!isset($_SESSION["username"])) {
//    header("Location: /account/login?reason=issue%20reporting&to=" . $_SERVER['REQUEST_URI']);
//    exit();
// }

if (isset($_POST['message'])) {
   $message = stripslashes($_POST['message']);
   $username = empty($_SESSION["username"]) ? 'Guest' : $_SESSION["username"];
   $avatar = isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : null;

   // Send message to Discord webhook
   $webhookurl = 'https://discord.com/api/webhooks/1158895668354617364/z8ETpKWB_Da5Kn7TAIh9R6GHmCjtybv0iBAi3fVbkwHgExxNrJpCIVCWZFNRLRV-b7vN';

   $json_data = json_encode([
      "content" => "New issue submitted: \n```\n$message\n```",
      "username" => $_SESSION['username'] ?? 'No Username',
      "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar'] ?? null
   ]);

   if (trim($_POST['message']) == '7fec0d3f951a') {
      header("Location: /walter/what-now?iamfromenteringthatcodeintotheissuepage");
      die();
   } else {
      header("Location: /issue?msg=success");
   }

   // run a node script: /var/js/sendIssue.js
   fastcgi_finish_request();
   exec("/usr/bin/node /var/js/sendIssue.js '$message' '$username' '$avatar'");
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <meta name="darkreader" content="this stops darkreader cos it looks bad" />

   <title>Untitled document - Google Docs</title>
   <meta name="description" content="Tools & Utilities">

   <meta property="og:title" content="Englon">
   <meta property="og:image" content="/images/logo.png">
   <meta property="og:description" content="Tools & Utilities">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>">

   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <script src="https://kit.fontawesome.com/7f61d9ffae.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="stylesheet.css?v1.1.2">
   <script async src="/common.js"></script>
   <!-- Matomo -->
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
   <script>
      function onLoad() {
         const toasts = document.getElementsByClassName("toast");
         console.log(Array.from(toasts))
         Array.from(toasts).forEach(toast => {
            toast.style.translate = "0 0";
         });
      }
   </script>
</head>

<body onload="onLoad()">
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
      <div style="translate: 125% 0;" class="toast">
         <i class="fa-solid fa-check"></i>
         <div class="content">
            <p class="title">Succeeded</p>
            <p class="description">Issue successfully sent.</p>
            <button onclick="closeToast(this)" class="close"><i class="fa-solid fa-x"></i></button>
         </div>
      </div>
   <?php } ?>
   <main>
      <div class="main">
         <h1>Issue Submission</h1>
         <h2>Got a problem or found a bug? Send us a quick message, it doesn't have to be detailed.</h2>
         <p>You can include your Discord username or email if you would like someone to get back to you!</p>
         <?php if (!(isset($_SESSION['username']))) { ?>
            <p><b>Unless this is a ban appeal, consider <a class="link"
                     href="/account/login?reason=issue%20reporting&to=/issue">logging
                     in</a> so we know who you are.</b></p>
         <?php } ?>

         <form method="post">
            <textarea placeholder="Message" name="message" maxlength="3800" cols="50" rows="7"></textarea>
            <br>
            <input type="submit" value="Submit">
         </form>
      </div>
   </main>
</body>

</html>
