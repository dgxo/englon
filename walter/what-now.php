<?php
session_start();
if (!isset($_SESSION["username"])) {
   header("Location: /account/login?reason=???");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>hmmm</title>
   <link rel="stylesheet" href="/stylesheet.css">

   <meta property="og:title" content="the test">
   <meta property="og:image" content="/images/logo.png">
   <meta property="og:description" content="i wouldn't try if you don't know the key">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>">

   <link rel="shortcut icon" href="/images/logo.png">
   <link rel="icon" type="image/x-icon" href="/images/logo.png">
</head>

<body>
   <main>
      <h2>
         <?php
         $nice_mode = true;
         $time = $_SESSION['secret-cooldown-time'] ?? 0;
         $time_diff = floor((600 - (time() - $time)) / 60);

         if (isset($_GET['iamfromenteringthatcodeintotheissuepage'])) { // putting secret code into issue page
            echo "You're almost there but it's one more step <br> until the reward! See if you can find it!";
            die();
         }

         if (!isset($_GET['key'])) {
            echo "What? How did you get here? <br> You failed. You're now logged out just for fun.";
            session_destroy();
            die();
         }

         if (time() >= $time + 600) { // if it's been 10 mins since cooldown started
            if ($_GET['key'] == 'hmmm') { // correct
               echo "You now have admin <b>for this session</b>. Not much you can do with it, but DM me @dgox2 on Discord and I might give you special
         access to something else though.";
               $_SESSION['admin'] = true;
               webhook();
            } else {
               echo "Nope. And also, you can't brute force this. Take a 10m cooldown!";
               $_SESSION['secret-cooldown-time'] = time();
            }
         } else {
            echo "You're on cooldown, " . ($nice_mode ? "and nice mode is on,<br>so you can know there are $time_diff minutes left!" : "but I'm not saying how long is left.");
         }

         function webhook()
         {
            // Send message to Discord webhook
            $webhookurl = 'https://discord.com/api/webhooks/1196979017467830423/ZfFgykRos-QAHDFoUfofP4btYiLDHlOtKkL-ifblB7MAU94_lI4eP0aHwCeJFocIbkbp';

            $json_data = json_encode([
               "content" => "SOMEONE FUCKING DID IT. username is {$_SESSION['username']} and IP is {$_SERVER['REMOTE_ADDR']}",
               "username" => $_SESSION['username'] ?? 'Guest',
               "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar'] ?? null
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
         }
         ?>
      </h2>
   </main>
</body>

</html>