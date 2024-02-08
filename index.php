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

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/solid.min.js"
   integrity="sha512-s6yNeC6faUgveCQocceGXVia7ciAebyTH7hRNazwZa2FHhnxX22qaGeb9d3a8PUKdnoHo3T3bYI/0ZOjmgWkNg=="
   crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="stylesheet.css?v1.1.8">
   <script async src="/common.js?"></script>
   <!-- Matomo -->
   <script>
      var _paq = window._paq = window._paq || [];

      _paq.push(['setCustomDimension', customDimensionId = 1, customDimensionValue = '<?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Not Logged In' ?>']);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      _paq.push(['enableJSErrorTracking']);
      (function () {
         var u = "//stats.englon.biz/";
         _paq.push(['setTrackerUrl', u + 'e'])
         _paq.push(['setSiteId', '1']);

         var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
         g.async = true;
         g.src = u + 'js/';
         s.parentNode.insertBefore(g, s);
      })();
   </script>
   <!-- End Matomo Code -->
   <template id="toast-template">
      <div style="translate: 125% 0;" class="toast">
         <i class="fa-solid fa-check"></i>
         <div class="content">
            <p class="title"></p>
            <p class="description"></p>
            <button onclick="closeToast()" class="close">✕</button>
         </div>
      </div>
   </template>
</head>

<body>
   <script defer src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
   <script defer src="/index.js?"></script>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <div id="particles-js"></div>
   <main>
      <div class="main">
         <h1>Englon - Tools & Utilities</h1>
         <div id="taylor">
            <h2>Taylor mode lol</h2>
         </div>
         <h3>Give suggestions for new gаmes and sites in the <a class="link" href="/discord">Discord</a> or on chat!
         </h3>
         <p>Did you know Englon has been DDoSed 4 times in the past 2 weeks?</p>
         <a class="button" href="/account">
            <?= isset($_SESSION['username']) ? 'Dashboard' : 'Login' ?>
         </a>
         <h2>Coming Soon</h2>
         <ul class="list">
            <li>Chat v2!</li>
            <li><i>Got any ideas? Suggest it on the <a class="link" href="/issue">issue page</a>
                  or in the <b>NEW</b> <a class="link" href="/discord">Discord</a>!</i></li>
         </ul>
         <h2>Changelog</h2>
         <ul class="list">
            <li>Added a few more statistics</li>
            <li>Removed particles for mobile</li>
            <li>Added increased error logging (report on <a class="link" href="/issue">issues</a> if you see one)</li>
            <li>Added Cloudflare for additional performance and security (ddos protection!)</li>
            <li>Improved mobile chat layout so send button is on another row</li>
            <li>Fixed Discord -> Chat pfps</li>
            <li>Enhanced chat bar at the bottom (aligned and fills whole width now)</li>
            <li>Revamped mobile navigation</li>
            <li>Another test on the secret tests page (try and find it!)</li>
            <li>New secret challenge</li>
            <li>Lightened global font weight</li>
            <li><button id="cool-secret-toast">Added support for new toasts (notifications)</button></li>
            <li>Released <a class="link" href="/issue">issue page</a>!</li>
         </ul>
         <!-- IF YOU SEE THIS, TYPE "TAYLOR" TO UNLOCK TAYLOR MODE -->
         <h3>v1.1.4</h3>
         <h4>want to crash a chromebook? go <a class="link" href="/crash">here</a></h4>
      </div>
   </main>
   <footer>
      <b>&copy; 2024 Englon Ltd. All Rights Reserved.</b>
      <br>Redistribution is prohibited and will result in legal action.
   </footer>
</body>

</html>