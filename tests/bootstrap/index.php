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

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script> -->

   <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <!-- <link rel="stylesheet" href="stylesheet.css?v1.1.2"> -->
   <script async src="/index.js"></script>
   <script async src="/common.js"></script>
   <!-- Matomo -->
   <script>
      var _paq = window._paq = window._paq || [];


      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= $_SESSION['username'] ?>']);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      _paq.push(['enableJSErrorTracking']);
      (function () {
         var u = "//stats.englon.biz/";
         _paq.push(['setTrackerUrl', u + 'e']);
         _paq.push(['setSiteId', '1']);

         var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
         g.async = true; g.src = u + 'js/'; s.parentNode.insertBefore(g, s);
      })();
   </script>
   <!-- End Matomo Code -->
   <template id="toast-template">
      <div style="translate: 125% 0;" class="toast">
         <i class="fa-solid fa-check"></i>
         <div class="content">
            <p class="title"></p>
            <p class="description"></p>
            <button onclick="closeToast()" class="close"><i class="fa-solid fa-x"></i></button>
         </div>
      </div>
   </template>
</head>

<body>
   <?php
   include("/var/www/html/englon/tests/bootstrap/header.php");
   ?>
   <div id="particles-js"></div>
   <main>
      <div class="main">
         <h1>Englon - Tools & Utilities</h1>
         <h2>bootstrap site heavily work in progress</h2>
         <!-- <h2>Give suggestions for new gаmes and sites in the <a class="link"
                  href="/discord">Discord</a> or on chat!</h2> -->
         <a class="button" href="/account">
            <?= isset($_SESSION['username']) ? 'Login' : 'Dashboard' ?>
         </a>
         <h2>Coming Soon</h2>
         <ul>
            <li>More tests on the secret test page (try and find it!)</li>
            <li><i>Got any more ideas? Suggest it on the <a class="link" href="/issue">issue page</a>
                  or in <a class="link" href="/chat">chat</a>!</i></li>
         </ul>
         <h2>Changelog</h2>
         <ul>
            <li>Added the beginning of a new secret challenge</li>
            <li>Lightened global font weight</li>
            <li>Add<button id="cool-secret-toast">e</button>d support for new toasts (notifications)</li>
            <li>Released <a class="link" href="/issue">issue page</a>!</li>
         </ul>
         <div id="taylor">
            <h2>Taylor mode lol</h2>
         </div>
         <!-- IF YOU SEE THIS, TYPE "TAYLOR" TO UNLOCK TAYLOR MODE (might need to refresh) -->
         <br>
         <h4>v1.0.4</h4>
         <h5>want to crash a chromebook? click a couple times on this page</h5>
      </div>
   </main>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"></script>
</body>

</html>