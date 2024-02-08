<?php
session_status() === PHP_SESSION_NONE ?: session_start();
$url = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="/tests/bootstrap">Englon - Bootstrap Test</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a <?= $url == '/tests/bootstrap' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>
						href="/tests/bootstrap">Home</a>
				</li>
				<li class="nav-item">
					<a <?= $url == '/p' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>
						href="/p">Prox</a>
				</li>
				<li class="nav-item">
					<a <?= $url == '/chat' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>
						href="/chat">Chat</a>
				</li>
				<li class="nav-item">
					<a <?= $url == '/d' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>
						href="/d">Downloads</a>
				</li>
				<li class="nav-item">
					<a <?= $url == '/place' ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>
						href="/place">Place</a>
				</li>
				<li class="nav-item">
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">
						Games
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a <?= $url == '/gms' ? 'class="dropdown-item active" aria-current="page"' : 'class="dropdown-item"' ?>
								href="/gms">Index</a></li>
						<li><a <?= $url == '/gms/library' ? 'class="dropdown-item active" aria-current="page"' : 'class="dropdown-item"' ?>
								href="/gms/library">Library</a></li>
						<li><a <?= $url == '/gms/library-paginated' ? 'class="dropdown-item active" aria-current="page"' : 'class="dropdown-item"' ?>
								href="/gms/library-paginated">Paginated Library</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>