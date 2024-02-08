<?php session_start(); ?>

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
   <link rel="stylesheet" href="stylesheet.css?v1.1.2">
   <script async src="/index.js"></script>
   <script async src="/multicursor.js"></script>
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

   <!--  -->
</head>

<body>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <div id="particles-js"></div>
   <main>
      <div class="main">
         <h1>Englon - Tools & Utilities</h1>
         <h2>Multi-Cursor</h2>
         <h3>Development Stage</h3>

         <h4>(multicursor not englon) v0.0.0</h4>
      </div>
   </main>
</body>

</html>