<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', '1153760785265336340');
define('OAUTH2_CLIENT_SECRET', 'fZOsSD4Udk9zTze5doGq-hYkqEpDnSu_');

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';
$revokeURL = 'https://discord.com/api/oauth2/token/revoke';

session_start();

// Start the login process by sending the user to Discord's authorization page
if (get('action') == 'login') {

   $params = array(
      'client_id' => OAUTH2_CLIENT_ID,
      'redirect_uri' => 'https://englon.uk/test/discord/',
      'response_type' => 'code',
      'scope' => 'identify guilds' // hopefully activities.read is released for apps at some point but not rn
   );

   // Redirect the user to Discord's authorization page
   header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
   die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if (get('code')) {

   // Exchange the auth code for a token
   $token = apiRequest(
      $tokenURL,
      array(
         "grant_type" => "authorization_code",
         'client_id' => OAUTH2_CLIENT_ID,
         'client_secret' => OAUTH2_CLIENT_SECRET,
         'redirect_uri' => 'https://englon.uk/test/discord/',
         'code' => get('code')
      )
   );
   $logout_token = $token->access_token;
   $_SESSION['access_token'] = $token->access_token;


   header('Location: ' . $_SERVER['PHP_SELF']);
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

   <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="/account/stylesheet.css?0.7.8">
   <script async src="/index.js"></script>
   <script async src="/common.js"></script>
</head>

<body>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <main>
      <div class="main">
         <div id="dashboard">
            <?php

            if (get('error')) {

               // Exchange the auth code for a token
               echo '<h3>Error</h3>';
               echo '<p>' . get('error_description') . '</p>';
               echo '<p style="font-style: italic">' . get('error') . '</p>';
            }

            if (session('access_token')) {
               $user = apiRequest($apiURLBase);

               echo '<h3>Logged In</h3>';
               echo '<h4>Welcome, ' . $user->username . '</h4>';
               echo '<pre>';
               print_r($user);
               echo '</pre>';

            } else {
               echo '<h3>Not logged in</h3>';
               echo '<p><a href="?action=login">Log In</a></p>';
            }


            if (get('action') == 'logout') {
               // This should log you out
               logout(
                  $revokeURL,
                  array(
                     'token' => session('access_token'),
                     'token_type_hint' => 'access_token',
                     'client_id' => OAUTH2_CLIENT_ID,
                     'client_secret' => OAUTH2_CLIENT_SECRET,
                  )
               );
               unset($_SESSION['access_token']);
               header('Location: ' . $_SERVER['PHP_SELF']);
               die();
            }

            function apiRequest($url, $post = [], $headers = array())
            {
               $ch = curl_init($url);
               curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

               $response = curl_exec($ch);


               if ($post)
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

               $headers[] = 'Accept: application/json';

               if (session('access_token'))
                  $headers[] = 'Authorization: Bearer ' . session('access_token');

               curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

               $response = curl_exec($ch);
               return json_decode($response);
            }

            function logout($url, $data = array())
            {
               $ch = curl_init($url);
               curl_setopt_array(
                  $ch,
                  array(
                     CURLOPT_POST => TRUE,
                     CURLOPT_RETURNTRANSFER => TRUE,
                     CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                     CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                     CURLOPT_POSTFIELDS => http_build_query($data),
                  )
               );
               $response = curl_exec($ch);
               return json_decode($response);
            }

            function get($key, $default = NULL)
            {
               return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
            }

            function session($key, $default = NULL)
            {
               return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
            }

            ?>
         </div>
      </div>
   </main>

</body>

</html>