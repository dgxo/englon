<?php
$invite = 'https://discord.gg/2YmMnnNbt4';
header("Location: $invite");
session_start(); ?>


<!DOCTYPE html>

<html lang="en" id="html">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html" />

	<title>Untitled document - Google Docs</title>
	<meta name="description" content="Tools & Utilities" />

	<meta property="og:title" content="Englon Discord" />
	<meta property="og:description" content="Tools & Utilities" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://englon.biz/discord" />

	<link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico" />
	<link rel="icon" type="image/x-icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico" />
	<link rel="stylesheet" href="/stylesheet.css" />
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
</head>

<body>

	<body>
		<main>
			<div class="main">
				<!-- unreachable, php does redirect with headers most times -->
				<h1><a class="link" href="https://discord.gg/2YmMnnNbt4">Discord</a></h1>
			</div>
		</main>
	</body>

</html>
