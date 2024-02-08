<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>

	<title>Untitled document - Google Docs</title>
	<link rel="icon" href="/favicon.ico" />


	<meta name="title" content="EnglonProx">
	<meta name="description" content="Englon Prox. 7 hours of my time wasted woohoo">
	<meta name="keywords" content="englon, proxy, web proxy, englon proxy, englon prox">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">
	<meta name="revisit-after" content="7 days">
	<meta name="author" content="Englon">
	<meta property="og:title" content="EnglonProx">
	<meta property="og:site_name" content="Englon">
	<meta property="og:url" content="https://englon.biz/p">
	<meta property="og:description" content="">
	<meta property="og:type" content="">
	<meta property="og:image" content="https://englon.uk/favicon.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="https://ssl.gstatic.com/docs/documents/images/kix-favicon7.ico">

	<style type="text/css">
		@import url('/stylesheet.css?v1.1.3');

		@font-face {
			font-family: 'Urbanist';
			font-style: normal;
			font-weight: 600;
			font-display: swap;
			src: url(https://fonts.gstatic.com/s/urbanist/v15/L0xjDF02iFML4hGCyOCpRdycFsGxSrqDFRkvEZmq.woff2) format('woff2');
		}

		* {
			font-family: 'Poppins', Geneva, Verdana, sans-serif;
		}

		body {
			color: white;
			margin: 0;
		}

		#container {
			position: absolute;
			top: 40%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 70vw;
			margin: 0;
		}

		#error {
			color: red;
			font-weight: bold;
		}

		#frm {
			padding: 15px;
			backdrop-filter: brightness(50%);
			font-weight: 400;
			border-radius: 1000px;
		}

		form {
			display: grid;
			grid-template-columns: 76.5% 23.5% 8.5%;
			grid-gap: 0;
			width: auto;
		}

		@media only screen and (max-width: 800px) {
			form {
				grid-template-columns: 55% 25% 20%;
			}
		}

		h1 {
			font-size: 3.5em;
			font-weight: 600;
			margin-bottom: 7vh;
			font-family: 'Urbanist';
		}

		body {
			margin: 0;
			background-position: center;
		}

		/* a {
			color: white;
			text-decoration: none;
			display: inline-block;
			position: relative;
			z-index: 1;
			padding: 0 1em;
			margin: -0.9em;
			line-height: 2.7rem;
		} */

		#url {
			background: rgba(255, 255, 255, 0.1);
			border: none;
			font-size: 20px;
			color: #fff;
			box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
			cursor: text;
			padding-left: 20px;
			margin-right: 16px;
			border-radius: 1000px;
		}

		#footer {
			font-size: .7rem;
			position: absolute;
			bottom: 10%;
			width: 100vw;
			text-align: center;
		}

		.selected {
			background-color: #000000bd !important;
			cursor: default;
		}
	</style>

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

	<div id="container">

		<div style="text-align:center;">
			<h1 id="title">
				<?php use Proxy\Config;

				print(Config::get('app_key')); ?>
			</h1>
		</div>

		<?php if (isset($error_msg)) { ?>

			<div id="error">
				<p>
					<?php echo strip_tags($error_msg); ?>
				</p>
			</div>

		<?php } ?>

		<div id="frm">

			<!-- I wouldn't touch this part /// i touched it-->

			<form action="index.php" method="post" style="margin-bottom:0;">
				<input id="url" name="url" type="text" autocomplete="off" placeholder="https://..." />
				<input id="submit" type="submit" value="Go" />
				<!-- <button id="search" type="submit" value=""><i class="fa-solid fa-magnifying-glass"></i></button> -->

			</form>

			<script type="text/javascript">
				document.getElementsByName("url")[0].focus();
			</script>

			<!-- [END] -->

		</div>

	</div>

	<div id="footer">
		<?php
		echo phpversion();
		?>
	</div>

</body>

</html>