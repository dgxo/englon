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

if (!isset($_SESSION['authorised']) || $_SESSION['authorised'] == false) {
   header("Location: /tests/Google%20Auth/");
}
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

      h1 img {
         vertical-align: middle;
         margin-right: 1rem;
         border-radius: 100%;
         aspect-ratio: 1;
      }

      ul {
         margin-left: 2rem;
      }
   </style>
</head>

<body>
   <a href="/">Home</a> | <a href="/tests">Tests</a>
   <h1>
      <img height="64" src="<?= $_SESSION['user']['picture'] ?>" alt="Profile picture">
      Hello,
      <?= $_SESSION['user']['name'] ?>
   </h1>
   <h2>User Info</h2>
   <ul>
      <li>Name:
         <?= $_SESSION['user']['name'] ?>
      </li>
      <li>
         Email:
         <?= $_SESSION['user']['email'] ?>
      </li>
      <li>
         Locale:
         <?= $_SESSION['user']['locale'] ?>
      </li>
   </ul>
   <br>
   <a href="logout.php">Logout</a>
   <br>
   <br>
</body>

</html>