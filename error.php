<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <meta http-equiv="Content-Type" content="text/html" />

   <title>Englon</title>
   <meta name="description" content="Tools & Utilities" />

   <meta property="og:title" content="Englon" />
   <meta property="og:description" content="Error:
      <!--# echo var=" status_text" default="Something went wrong" -->
   " />
   <meta property="og:type" content="website" />
   <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>" />

   <link rel="icon" href="/favicon.ico" />
   <link rel="icon" href="/favicon.ico" type="image/svg+xml" />
   <link rel="apple-touch-icon" href="/favicon.ico" />
   <style type="text/css">
      @import url(/stylesheet.css?v1.1.2);

      @font-face {
         font-family: 'Fira Code';
         font-style: normal;
         font-weight: 600;
         font-display: swap;
         src: url(https://fonts.gstatic.com/s/firacode/v21/uU9eCBsR6Z2vfE9aq3bL0fxyUs4tcw4W_ONrJVD7Ng.woff2) format('woff2');
      }

      :root {
         overflow: hidden;
      }

      h1 {
         margin-top: 23vh;
         margin-bottom: 0;
         font-size: 33vh;
         font-family: 'Fira Code';
         line-height: 40vh;
      }

      h2 {
         font-size: 8vh;
         font-weight: 400;
         margin: 0;
      }

      @media (max-width: 820px) {
         header {
            display: none !important;
         }

         #menuToggle {
            display: flex !important;
         }

         h1 {
            font-size: 33vw !important;
            line-height: 40vw;
         }

         h2 {
            font-size: 8vw;
         }
      }
   </style>
   <script>
      var _paq = window._paq = window._paq || [];

      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Not Logged In' ?>']);
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

   <h1>
      <!--# echo var="status" default="???" -->
   </h1>
   <h2>
      <!--# echo var="status_text" default="Something went wrong" -->
   </h2>

   <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/<!--# echo var='status' default='???' -->">?</a>
</body>

</html>