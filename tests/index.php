<?php
session_start();
$directories = glob(getcwd() . '/*', GLOB_ONLYDIR);

// Sort the directories by creation time (most recent first)
usort($directories, function ($a, $b) {
   return filemtime($b) - filemtime($a);
});

$tests = array();

foreach ($directories as &$directory) {
   $dirname = basename($directory);
   $tests[] = $dirname;
}
?>

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <meta name="darkreader" content="this stops darkreader cos it looks bad" />

   <title>Englon Testing</title>
   <meta name="description" content="Tools & Utilities">

   <meta property="og:title" content="Englon Testing">
   <meta property="og:image" content="/images/logo.png">
   <meta property="og:description"
      content="Access exclusive tests for Englon. Current tests: <?= implode(', ', $tests) ?>.">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>">

   <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="/stylesheet.css?v1.1.2">
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
</head>

<body>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <main>
      <div class="main">
         <h1>Englon Tests</h1>
         <h3>Hey! Welcome to Englon's testing page.<br>You can have a look at the experiments going on behind the scenes
            here,<br>
            just to take a peek at possible future features.
         </h3>
         <p>
            Keep in mind that these pages are only unstable tests of <i>possible</i> ideas, and are unlikely to be
            implemented. However, if you would like one of these tests further investigated or want to give feedback,
            feel free to let us know on the <a class="link" href="/issue">issue</a> page. Have fun!
         </p>
         <ul class="desktop-ul links">
            <?php
            foreach ($directories as &$directory) {
               $dirname = basename($directory);
               if ($dirname != 'library') {
                  echo '<li><a href="' . $dirname . '">' . $dirname . '</a></li>';
               }
            }
            ?>
         </ul>
      </div>
   </main>
</body>

</html>