<?php
require_once 'vendor/autoload.php';
session_start();

// init configuration
$clientID = '615555138768-1o3t6ucvc6e02is2d3bel68o9jj1jsh0.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://englon.biz/tests/Google%20Auth/';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

if (isset($_SESSION['authorised']) && $_SESSION['authorised'] == true) {
   header("Location: dashboard");
}

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
   $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
   $client->setAccessToken($token['access_token']);

   // get profile info
   $google_oauth = new Google_Service_Oauth2($client);
   $google_account_info = $google_oauth->userinfo->get();
   $email = $google_account_info->email;
   $name = $google_account_info->name;

   $_SESSION['authorised'] = true;
   $_SESSION['user'] = $google_account_info;

   header("Location: dashboard");
} else {
   ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Google Auth Testing</title>
      <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');

         * {
            margin: 0;
            padding: 0;
            font-family: inherit;
            box-sizing: border-box;
            min-width: 0;
         }

         html {
            color-scheme: dark;
         }

         body {
            font-family: Poppins;
            margin-block: 2rem;
            margin-inline: 2rem;
            font-size: 1.75rem;
         }

         .login-btn {
            width: fit-content;
         }
      </style>
   </head>

   <body>
      <h1>Not logged in</h1>
      <br>
      <a href='<?= $client->createAuthUrl() ?>'>Sign in with Google</a>

   </body>

   </html>
   <?php
}
?>