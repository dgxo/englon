<!DOCTYPE html>

<html lang="en" id="html">

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <meta name="darkreader" content="this stops darkreader cos it looks bad" />

   <title>test2</title>
   <meta name="description" content="Tools & Utilities">

   <meta property="og:title" content="Englon">
   <meta property="og:image" content="/images/logo.png">
   <meta property="og:description" content="Tools & Utilities">
   <meta property="og:type" content="website">
   <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>">

   <script src="https://cdn.jsdelivr.net/npm/@barba/core"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
   <link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">
   <link rel="stylesheet" href="/stylesheet.css?1.6.3">
   <script async src="/tests/anim/index.js?hownewquitenew"></script>
   <script async src="/common.js"></script>
</head>

<body data-barba="wrapper">
   <div id="particles-js"></div>
   <?php
   include("/var/www/html/englon/header.php");
   ?>
   <div data-barba="container" data-barba-namespace="main">
      <main>
         <div class="main">
            <h1>Englon - Tools & Utilities</h1>
            <h3>WILL PROBABLY NEVER BE IMPLEMENTED DUE TO OTHER ISSUES (separate css files for each dir won't load in)
               :(</h3>
            <p>However, with the <a class="link" href="/tests/bootstrap">Boostrap test</a>, it could be possible since
               there likely won't be any need to load a stylesheet per page. (not a guarantee)</p>
            <h2>test2</h2>
            <ul class="desktop-ul links">
               <li><a href="/tests/anim/test1/">test1</a></li>
               <li><a href="/tests/anim/test2/">test2</a></li>
               <li><a href="/tests/anim/test3/">test3</a></li>
            </ul>
         </div>
      </main>
   </div>
   <script>
      barba.init({
         transitions: [
            {
               name: 'opacity-transition',
               leave(data) {
                  return gsap.to(data.current.container, {
                     rotate: 180,
                     ease: 'none',
                     display: 'none'
                  });
               },
               enter(data) {
                  return gsap.from(data.next.container, {
                     rotate: -180,
                     ease: 'none',
                     display: 'none'
                  });
               }
            }
         ]
      });
   </script>
</body>

</html>