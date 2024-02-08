<?php session_start(); ?>

<!DOCTYPE html>

<html lang="en">

<head>
   <meta charset="utf-8">
   <meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport">

   <title>Untitled document - Google Docs</title>
   <meta name="description" content="Tools & Utilities">

   <meta property="og:title" content="Englon Gаmes">
   <meta property="og:description" content="Tools & Utilities">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://englon.biz/gms">

   <link rel="icon" href="/favicon.ico">
   <link rel="icon" href="/favicon.ico" type="image/svg+xml">
   <link rel="apple-touch-icon" href="/favicon.ico">

   <link rel="stylesheet" href="stylesheet.css?v1.1.2">
   <script src="index.js"></script>
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
   <?php include('/var/www/html/englon/header.php'); ?>
   <!-- Home button, lotta styling but necessary (i think) -->
   <button style="       
   all: unset;
   display: inline-block;
   max-width: 100%;
   white-space: nowrap;
   overflow: hidden;
   backdrop-filter: brightness(50%);
   color: #fff;
   font-size: 1.5rem;
   border-radius: 95px;
   text-align: center;
   margin: 0;
   text-decoration: none;
   box-shadow: 2px 2px 2px 0px #00000017;
   user-select: none;
   position: fixed;
   left: 1rem;
   top: 4.5rem;
   width: 3rem;
   height: 3rem;
   padding: 0;
   cursor: pointer;
   " onClick="location.href = '/gms'">
      <svg xmlns="http://www.w3.org/2000/svg" height="0.7em" fill="white" viewBox="0 0 420 512"
         viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
         <path style="cursor: pointer;"
            d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z">
      </svg>
   </button>
   <main>
      <div class="main">
         <h1>The Library</h1>
         <h3>A huge collection of gаmes hosted on Englon,<br>so will hopefully never be blocked (again).</h3>

         <input type="text" id="search-input" onkeyup="search()" placeholder="Search">
         <noscript>
            <p>JavaScript is required to use search.</p>
         </noscript>
         <ul class="desktop-ul links" id="links">
            <?php
            $directories = glob(getcwd() . '/*', GLOB_ONLYDIR);

            foreach ($directories as &$directory) {
               $dirname = basename($directory);
               // Replaces some characters with their (almost) identical cyrillic variants to avoid blocking
               $filtered_dirname = str_replace('a', 'а', $dirname);
               $filtered_dirname = str_replace('e', 'е', $filtered_dirname);
               $filtered_dirname = str_replace('o', 'о', $filtered_dirname);
               if ($dirname != 'library') {
                  echo '<li><a href="' . $dirname . '">' . $filtered_dirname . '</a></li>';
               }
            }
            ?>
         </ul>
      </div>
   </main>
</body>

</html>