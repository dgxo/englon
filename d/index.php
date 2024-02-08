<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Untitled document - Google Docs</title>
	<meta name="description" content="Work In Progress">

	<meta property="og:title" content="Englon Downloads Page">
	<meta property="og:description" content="Download various Gmes, utilities and apps.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://englon.biz/d">

	<script src="index.js"></script>
	<script src="/common.js"></script>
	<link rel="icon" href="/favicon.ico">
	<link rel="icon" href="/favicon.ico" type="image/svg+xml">
	<link rel="apple-touch-icon" href="../favicon.ico">
	<script src="https://kit.fontawesome.com/7f61d9ffae.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="stylesheet.css?v1.1.2">
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
	<?php
	include("/var/www/html/englon/header.php");
	?>
	<main>
		<h1>Englon Downloads</h1>

		<h2>
			.exe and .bat downloads are prevented on the PCs, so use the renamed column to download, then
			rename the file to remove the '.renamethis' after.
		</h2>
		<h2>V2 - WIP</h2>
		<div class="main">

			<?php
			$files = glob(getcwd() . '/files/*');

			// Sort the directories by creation time (most recent first)
			usort($files, function ($a, $b) {
				return filemtime($b) - filemtime($a);
			});

			foreach ($files as &$file) {
				$filename = basename($file);
				if ($filename[0] != '_') {
					echo "<article class='card'>
								<h2><a class='link' href='./files/$filename'>$filename</a></h2>

								<button onclick='altDownload(`$filename`, this)'>
								<i class='fa-solid fa-download'></i>
									Alt
								</button>
							</article>";
				}
			}
			?>
		</div>
	</main>

</body>

</html>
