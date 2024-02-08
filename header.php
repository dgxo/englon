<?php
if (session_id() === "")
   session_start();
$url = $_SERVER['REQUEST_URI'];
?>
<header>
   <nav class="desktop">
      <ul class="desktop-ul">
         <li <?= $url == '/' ? 'class="selected"' : '' ?>><a href="/">Home</a></li>
         <li <?= $url == '/p/' ? 'class="selected"' : '' ?>><a href="/p/">Prox</a></li>
         <li <?= $url == '/chat/' ? 'class="selected"' : '' ?>><a href="/chat/">Chat</a></li>
         <li <?= $url == '/d/' ? 'class="selected"' : '' ?>><a href="/d/">Downloads</a></li>
         <li <?= $url == '/place/' ? 'class="selected"' : '' ?>><a href="/place/">Place</a></li>
         <li <?= $url == '/issue' ? 'class="selected"' : '' ?>><a href="/issue">Issues</a></li>
         <li <?= $url == '/gms/' ? 'class="selected"' : '' ?>><a href="/gms/">Gаmes</a></li>
      </ul>
      <a aria-label="Account" class="account button<?= strpos($url, '/account/') !== false ? ' selected' : '' ?>"
         href="/account/">
         <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! From Font Awesome -->
            <path
               d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"
               fill="white"></path>
         </svg></a>
   </nav>
</header>

<nav id="mobile-nav" class="mobile closed">
   <ul>
      <li <?= $url == '/' ? 'class="selected"' : '' ?>><a href="/">Home</a></li>
      <li <?= $url == '/p/' ? 'class="selected"' : '' ?>><a href="/p/">Prox</a></li>
      <li <?= $url == '/chat/' ? 'class="selected"' : '' ?>><a href="/chat/">Chat</a></li>
      <li <?= $url == '/d/' ? 'class="selected"' : '' ?>><a href="/d/">Downloads</a></li>
      <li <?= $url == '/place/' ? 'class="selected"' : '' ?>><a href="/place/">Place</a></li>
      <li <?= $url == '/issue' ? 'class="selected"' : '' ?>><a href="/issue">Issues</a></li>
      <li <?= $url == '/gms/' ? 'class="selected"' : '' ?>><a href="/gms/">Gаmes</a></li>
      <li <?= $url == '/account/' ? 'class="selected"' : '' ?>><a href="/account/">
            <?= isset($_SESSION['username']) ? 'Dashboard' : 'Login' ?>
         </a></li>
   </ul>
</nav>
<button id="mobile-nav-toggle" class="nav-toggle">☰</button>

<script>
   const menuToggle = document.querySelector('#mobile-nav-toggle');
   const nav = document.querySelector('#mobile-nav');

   menuToggle.addEventListener('click', () => {
      nav.classList.toggle('closed') ? menuToggle.innerHTML = '☰' : menuToggle.innerHTML = '✕';
   });
</script>