<?php
session_start();
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
   <meta property="og:url" content="https://englon.biz/login">

   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="stylesheet.css?1.7.7">
   <script>
      var _paq = window._paq = window._paq || [];

      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= isset($_SESSION['username']) ? $_SESSION['username'] : 'null' ?>']);
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

   // When form submitted, check and create user session.
   if (isset($_POST['username'])) {
      $username = stripslashes($_REQUEST['username']); // removes backslashes
      $username = mysqli_real_escape_string($con, $username);
      $password = stripslashes($_REQUEST['password']);
      $password = mysqli_real_escape_string($con, $password);
      // Check user is exist in the database
      $query = "SELECT admin, messages, create_datetime, notes, id, avatar, suspended, suspension_reason FROM `users` WHERE username=?";
      $stmt = mysqli_prepare($con, $query);
      if (!$stmt) {
         $error = 'Prepared statement failed: ' . mysqli_error($con);
         error_log("Gave SWR error: " . $error);
         header("Location: /swr?id=" . base64_encode($error));
         die();
      }
      mysqli_stmt_bind_param($stmt, 's', $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $rows = mysqli_num_rows($result);
      if ($rows == 1) {
         $row = $result->fetch_array(MYSQLI_ASSOC);
         // Verify password using password_verify
         $password_valid = password_verify($password, $row['password_hash']);
         if (!$password_valid) {
            echo "<main><div class='form'>
                     <h3>Incorrect Username/password.</h3><br/>
                     <p class='link'>Click here to <a class='link' href='login'>Login</a> again.</p>
                     </div></main>";
            mysqli_stmt_close($stmt);
            die();
         }

         if ($row["id"] == 80) { // guest
            ?>
            <main>
               <div id="main-card">
                  <h2>The Guest account has been disabled.</h2>

                  <p>If you would like to use Englon, please create an account.</p>
                  <p>To learn more about why this change was made, wait until I make a blog post lol.</p>
                  <p><a class='link' href='login'>Login</a> | <a class='link' href='register'>Register</a></p>
               </div>
            </main>
            <?php
            die();
         }

         if ($row["suspended"] == 1) {
            ?>
            <main>
               <div id="main-card">
                  <h2>Your account has been suspended, and is pending deletion.</h2>
                  <p>Reason:
                     <?= !empty($row["suspension_reason"]) ? htmlspecialchars($row["suspension_reason"]) : "Unknown" ?>
                  </p>
                  <p>If you believe this was in error, submit an <a class="link" href="/issue">issue</a>
                     and we will consider removing the suspension.
                     <br><br>
                     Remember you should only have <b>one</b> account, two at max.
                     <br><br>
                     <a class='link' href='login'>Click here to login into another account.</a>
                  </p>
               </div>
            </main>
            <?php
            die();
         }

         if ($row["admin"] == 1) {
            $_SESSION['admin'] = true;
         }

         if ($username == "") {
            $_SESSION['username'] = "Guest";
         } else {
            $_SESSION['username'] = $username;
         }
         $_SESSION['messages'] = $row["messages"];
         $_SESSION['creation'] = date_create($row["create_datetime"]);
         $_SESSION['creation'] = date_format($_SESSION['creation'], "d/m/Y");
         $_SESSION['notes'] = $row["notes"];
         $_SESSION['id'] = $row["id"];
         $_SESSION['avatar'] = $row["avatar"];

         $avatar = htmlspecialchars($row["avatar"] ?? 'default.png', ENT_QUOTES, 'UTF-8');
         $username = htmlspecialchars($row["username"] ?? $_SESSION['username'], ENT_QUOTES, 'UTF-8');
         $tz = 'Europe/London';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argu>
$dt->setTimestamp($timestamp); //adjust the object to correct >
$time = $dt->format('l jS, g:i a');

         $login_message = "<div class='msgln'><img class='avatar' src='/images/avatars/" . htmlspecialchars($row["avatar"] ?? 'default.png', ENT_QUOTES, 'UTF-8') . "'><div class='user'>" . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . " <span class='chat-time'>$time</span></div><div class='text'><b class='joined'>has logged in.</b></div><br></div>\n";

         file_put_contents("../chat/log.html", $login_message, FILE_APPEND);

         // Redirect to user dashboard page
         if (isset($_GET['to']) && str_starts_with($_GET['to'], '/')) {
            header("Location: https://" . htmlspecialchars($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($_GET['to'], ENT_QUOTES, 'UTF-8'));
         } else {
            header("Location: dashboard");
         }
         mysqli_stmt_close($stmt);
      } elseif ($rows > 1) {
         $error = "More than one user with username '" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "' on login";
         error_log("Gave SWR error: " . $error);
         mysqli_stmt_close($stmt);
         header("Location: /swr?id=" . base64_encode($error));
      } else {
         echo "<main><div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a class='link' href='login'>Login</a> again.</p>
                  </div></main>";
         mysqli_stmt_close($stmt);
      }
   } else {
      ?>
      <main>
         <form id="loginform" method="post" name="login">
            <p class="title">Login to Englon</p>
            <?php if (isset($_GET['reason'])) { ?>
               <p class="error">You need to sign in to access
                  <?= htmlspecialchars(urldecode($_GET['reason'])) ?>
               </p>
            <?php } ?>
            <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true">
            <input type="password" class="login-input" name="password" placeholder="Password">
            <input type="submit" value="Login" name="submit" class="login-button">
            <p class="link">Don't have an account? <a class="link" href="register">Register</a></p>
         </form>
      </main>
      <?php
   }
   ?>
</body>

</html>
