<?php
session_start();

if (!isset($_SESSION["username"])) {
	header("Location: /account/login?reason=Doodleship&to=" . $_SERVER['REQUEST_URI']);
} else
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Untitled document - Google Docs</title>
	<link rel="icon" href="/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="sp.css">
</head>

<body>
	<!-- Home button, lotta styling but necessary (i think) -->
	<button style="       
		all: unset;
		display: inline-block;
		max-width: 100%;
		white-space: nowrap;
		overflow: hidden;
		background-color: #33333399;
		backdrop-filter: brightness(50%);
		color: #fff;
		font-size: 1.5rem;
		border-radius: 95px;
		padding: 0 27px;
		text-align: center;
		margin: 0;
		margin-top: 0px;
		text-decoration: none;
		box-shadow: 2px 2px 2px 0px #00000017;
		transition: all 0.25s;
		user-select: none;
		position: fixed;
		top: 1vh;
		left: 1vh;
		width: 4rem;
		height: 4rem;
		padding: 0;
		cursor: pointer;
		z-index: 999999; 
		" onClick="location.href = '/gms'">
		<svg xmlns="http://www.w3.org/2000/svg" height="0.87em" viewBox="0 0 576 512" fill="white"
			style="cursor: pointer;">
			<!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
			<path style="cursor: pointer;"
				d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
		</svg>
	</button>
	<div class="info">
		<p>PLAYER-<span id="name"></span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp SCORE-<span id="score">0</span></p>
	</div>
	<div class="game-window">
		<img id="player" src="ufo.png">
		<div class="robo">
			<div style="left:3vw;"></div>
			<div style="left:11vw;"></div>
			<div style="left:19vw;"></div>
			<div style="left:27vw;"></div>
			<div style="left:35vw;"></div>
			<div style="left:43vw;"></div>
			<div style="left:51vw;"></div>
			<div style="left:59vw;"></div>
			<div style="left:67vw;"></div>
			<div style="left:75vw;"></div>
			<div style="left:83vw;"></div>
			<div style="left:91vw;"></div>
		</div>
	</div>

	<video id="video"
		style="opacity: 0; position: absolute; top: 100px; left: 5vw; width: 90vw; transition: opacity .6s ease;" controls
		src="https://cdn.discordapp.com/attachments/1125809463794864148/1127002811884908625/Screen_Recording_20230707_225605_Minecraft_-_Pocket_Edition.mp4"></video>
	<script type="text/javascript" src="jssp.js?new">
		document.querySelector('#name').innerHTML = <?= $_SESSION['username'] ?>;
	</script>
</body>

</html>