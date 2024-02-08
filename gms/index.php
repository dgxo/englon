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
	<!-- Start Matomo Code -->
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
	<main>
		<h1>Englon Gаmes</h1>
		<div class="main">
			<div class="by-englon">
				<h2>By Englon</h2>
				<input type="text" id="search-input" onkeyup="search()" placeholder="Search">
				<noscript>
					<p>JavaScript is required to use search.</p>
				</noscript>
				<ul class="desktop-ul links" id="on-eg-links">
					<?php
					$directories = glob(getcwd() . '/*', GLOB_ONLYDIR);

					// Sort the directories by creation time (most recent first)
					usort($directories, function ($a, $b) {
						return filemtime($b) - filemtime($a);
					});

					foreach ($directories as &$directory) {
						$dirname = basename($directory);
						if ($dirname != 'library') {
							echo '<li><a href="' . $dirname . '">' . $dirname . '</a></li>';
						}
					}
					?>
				</ul>
			</div>
			<div class="library">
				<h2>Visit <a href="library" class="link">The Library</a> for more</h2>
				<h3>A huge collection of popular gаmes hosted on Englon, so will never be blocked.</h3>
				<h3>Is it being flagged? Use the <a href="library-paginated" class="link">Paginated</a> version
					to still be able to browse the gаmes, and also make an <a href="/issue">issue</a> to let us know!</h3>
			</div>
			<div class="external">
				<h2>External</h2>
				<i>Super Mario 64 is now in <a href="library" class="link">The Library</a></i>
				<ul class="desktop-ul links">
					<li><a href="https://bash.gg">Bash.gg</a></li>
					<li><a href="https://v6p9d9t4.ssl.hwcdn.net/html/5922095/index.html">MC 2</a></li>
					<li><a href="https://martinmullins.github.io/ssam/">Serious Sam</a></li>
					<li><a href="https://web.libretro.com/">LibRetro</a></li>
					<!-- <li><a href="https://arkshocer.github.io/sm64/">Super Mario 64</a></li> -->
					<li><a href="https://www.freecivweb.org/">FreeCivWeb</a></li>
					<li><a href="https://browserquest.io/">BrowserQuest</a></li>
					<li><a href="https://rsc.vet">Runescape</a></li>
				</ul>
			</div>
		</div>
		<p>Want a modification made to a gаme? Join the <a class="link" href="https://discord.gg/K9Bpc9yxmR">Discord</a>
			and let me know!</p>

		<p>Disclaimer: Some external links are not verified that they don't contain inappropriate content.
			<br>By using this website, you agree to be responsible to report any suspicious or bad external links.
		</p>

	</main>
</body>

</html>