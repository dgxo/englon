<?php
session_start();

//die("lol no");

try {
   ?>
   <!DOCTYPE html>
   <html>

   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html">

      <title>Untitled document - Google Docs</title>
      <meta name="description" content="Tools & Utilities">

      <meta property="og:title" content="Login - Englon">
      <meta property="og:description" content="Tools & Utilities">
      <meta property="og:type" content="website">
      <meta property="og:url" content="https://englon.biz/register">

      <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
      <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
      <link rel="stylesheet" href="stylesheet.css?1.7.4">
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
      require('../db.php');

      // If user is already logged in send to dashboard
      if (isset($_SESSION['username'])) {
         header("Location: dashboard");
      }

      // When form submitted, insert values into the database.
      if (isset($_REQUEST['username'])) {
         if (empty($_REQUEST['password'])) {
            echo "<main><div id='dashboard'>
            <h3>Password cannot be empty.</h3
<a class='link' href='register'>Try again</a>
</div></main>";
            die();
         }
         // removes backslashes
         $username = stripslashes($_REQUEST['username']);
         //escapes special characters in a string
         $username = mysqli_real_escape_string($con, $username);

         // check if username is taken
         $query = "SELECT * FROM users 
                  WHERE username = '$username'";
         $result = mysqli_query($con, $query);

         if ($result->num_rows >= 1) {
            echo "<main><div id='dashboard'>
            <h3>That username is taken.</h3><br/>
            <a class='link' href='register'>Click here to retry</a>
            </div></main>";
            die();
         }

         $password = stripslashes($_REQUEST['password']);
         $password = mysqli_real_escape_string($con, $password);
         $create_datetime = date("Y-m-d H:i:s");
         $query = "INSERT into `users` (username, password, create_datetime)
                  VALUES ('$username', '" . md5($password) . "', '$create_datetime')";
         $result = mysqli_query($con, $query);
         if ($result) {

            $webhookurl = 'https://discord.com/api/webhooks/1157682267821457519/x4sSjMmPHIllE7l9UK3OPkNiPv6Tx7ATgVjOkf2re7GlfigNth_PLJnD0nPzw31E9E45';

            $json_data = json_encode([
               "content" => $username . ' signed up with ID ' . mysqli_insert_id($con),
               "username" => $username,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


            $ch = curl_init($webhookurl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
               $error = 'cURL error in chat post, with error ' . $err;
               error_log("Gave SWR error: " . $error);
               header("Location: /swr?id=" . base64_encode($error));
            }

            echo "<main><div id='dashboard'>
                  <h3>You have been registered successfully.</h3><br/>
                  <a class='link' href='login'>Click here to Login</a>
                  </div></main>";
         } elseif (mysqli_error($con)) {
            $error = 'Query failed on register with error ' . mysqli_error($con);
            error_log("Gave SWR error: " . $error);
            header("Location: /swr?id=" . base64_encode($error));
         } else {
            echo "<main><div id='dashboard'>
                  <h3>Required fields are missing.</h3><br/>
                  <a href='register' class='link'>Click here to register again.</a>
                  </div></main>";
            die();
         }
      } else {
         ?>
         <main>
            <form id="loginform" method="" name="">
               <p class="title">Register on Englon (sorry lol)</p>
               <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true">
               <input type="password" class="login-input" pattern="(?=.*\d)(?!.*[</>]).{6,}" name="password"
                  placeholder="Password - number and min 6 chars">
               <input type="submit" value="Register" name="submit" class="login-button">
               <p class="link">Already have an account? <a class="link" href="login.php">Login</a></p>
            </form>
         </main>
         <?php
      }
      ?>

   </body>

   </html>
   <?php
} catch (Exception $e) {
   $error = "Caught exception in registering: " . $e->getMessage();
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
   die("<h1>An error occurred! Report it on <a href='https://discord.gg/4GtRz4W'>Discord</a> or the <a href='/issue'>issue page</a>, providing this ID: " . base64_encode($error) . "</h1>");
}
?>
