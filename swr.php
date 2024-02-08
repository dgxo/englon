<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta http-equiv="Content-Type" content="text/html" />

   <title>Error</title>
   <meta name="description" content="Tools & Utilities" />

   <meta property="og:title" content="Englon" />
   <meta property="og:description" content="Something went horribly wrong!" />
   <meta property="og:type" content="website" />
   <meta property="og:url" content="https://englon.biz" />

   <link rel="icon" href="/favicon.ico" />
   <link rel="icon" href="/favicon.ico" type="image/svg+xml" />
   <link rel="apple-touch-icon" href="/favicon.ico" />
   <style type="text/css">
      @import url(/stylesheet.css);

      @font-face {
         font-family: 'Fira Code';
         font-style: normal;
         font-weight: 600;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/firacode/v21/uU9eCBsR6Z2vfE9aq3bL0fxyUs4tcw4W_ONrJVD7Ng.woff2) format('woff2');
      }

      header {
         background-color: #3F0505;
      }

      :root {
         background: #3F0505 url(/bg_red.png) no-repeat center center fixed;
         background-size: cover;
         overflow-x: hidden;
      }

      h1 {
         margin-top: 20vh;
         margin-bottom: 0;
         font-size: 14vh;
         font-family: 'Fira Code';
         line-height: 26vh;
      }

      h2 {
         font-size: 4vh;
         font-weight: 400;
         margin: 0 10vw;
      }

      h2 a.link {
         text-decoration-thickness: 2px;
         text-underline-offset: 4px;
      }

      @media (max-width: 820px) {
         header {
            display: none !important;
         }

         #menuToggle {
            display: flex !important;
         }

         h1 {
            font-size: 10vw !important;
            line-height: 40vw;
         }

         h2 {
            font-size: 8vw;
         }
      }
   </style>
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
</head>

<body>
   <?php
   include("/var/www/html/englon/header.php");
   ?>

   <main>
      <h1>
         OH ####
      </h1>
      <h2>
         There was a fatal error while processing your request.<br>
         Create an <a class="link" href="/issue">issue</a> or make a ticket on our <a class="link"
            href="/discord">Discord</a>, explaining what you were trying to do along with the error reference below.
      </h2>
      <h3>Error Reference:</h3>
         <pre><?= isset($_REQUEST['id']) ? $_REQUEST['id'] : '???' ?></pre>

         <?php if (isset($_SESSION['admin'])): ?>
               Decoded:
               <pre><?= isset($_REQUEST['id']) ? htmlspecialchars(base64_decode($_REQUEST['id'])) : '???' ?></pre>
         <?php endif ?>
   </main>

   <script type="text/javascript">
      var sc_project = 12897198;
      var sc_invisible = 1;
      var sc_security = "39beb5ae"; 
   </script>
   <script type="text/javascript" src="https://www.statcounter.com/counter/counter.js" async></script>
   <noscript>
      <div class="statcounter"><img class="statcounter" src="https://c.statcounter.com/12897198/0/39beb5ae/1/"
            referrerPolicy="no-referrer-when-downgrade"></div>
   </noscript>
   <!-- End of Statcounter Code -->
   <?php
   if (isset($_REQUEST['id'])) {
      // Send message to Discord webhook
      $webhookurl = 'https://discord.com/api/webhooks/1152913859309486120/S0-Bzy07LdhfqXHu3che01i2Un6IpzuXLU_Bd0crEmxolX_xrlcSSrt0pRXMYlZLE1er';

      $json_data = json_encode([
         "content" => "Got an SWR error: " . base64_decode(stripslashes($_REQUEST['id'])) . "\nEncoded: " . stripslashes($_REQUEST['id']),
         "username" => $_SESSION['username'] ?? 'SWR Error',
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

      if ($err) {
         $error = 'cURL error in chat post, with error ' . $err;
         error_log("Gave SWR error: " . $error);
         header("Location: /swr?id=" . base64_encode($error));
      }
   }
   ?>
</body>

</html>