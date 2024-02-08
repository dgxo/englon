<style type="text/css">
	@font-face {
		font-family: 'Poppins';
		font-style: normal;
		font-weight: 500;
		font-display: swap;
		src: url(https://fonts.gstatic.com/s/poppins/v20/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2) format('woff2');
		unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329,
			U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
	}

	html body {
		margin-top: 7.1rem !important;
	}

	#eg_top_form {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;

		margin: 0;

		z-index: 2100000000;
		user-select: none;
		-moz-user-select: none;
		-khtml-user-select: none;
		-webkit-user-select: none;
		-o-user-select: none;

		border-bottom: 1px solid #151515;

		background-color: #0a1544;

		height: 7.1rem;
		line-height: 25px;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}

	#eg_form {
		display: grid;
		grid-template-columns: 13% 76.5% 10.5%;
		grid-gap: 0px;
		width: 90%;
		margin: auto;
		margin-top: 10px;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}

	@media only screen and (max-width: 700px) {
		form {
			grid-template-columns: 23% 54% 23%;
		}
	}

	#eg_url {
		background: rgba(255, 255, 255, 0.1);
		border: none;
		font-size: 20px;
		color: #fff;
		box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
		cursor: text;
		padding-left: 20px;
		margin: 0 16px;
		border-radius: 1000px;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}

	#eg_submit {
		all: unset;
		display: inline-block;
		max-width: 100%;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		background-color: #0000007d;
		/* backdrop-filter: brightness(60%) blur(35px); */
		/* background-color: #0c4557; */
		color: #fff;
		font-size: 30px;
		border-radius: 95px;
		padding: 0 37px;
		height: 70px;
		cursor: pointer;
		line-height: 50px;
		text-align: center;
		margin: 0;
		text-decoration: none;
		box-shadow: 2px 2px 2px 0px #00000017;
		transition: backdrop-filter 0.2s;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}



	#eg_home {
		all: unset;
		display: inline-block;
		max-width: 100%;
		white-space: nowrap;
		overflow: hidden;
		background-color: #0000007d;
		/* backdrop-filter: brightness(60%) blur(35px); */
		/* background-color: #0c4557; */
		color: #fff;
		font-size: 30px;
		border-radius: 95px;
		padding: 0 37px;
		height: 70px;
		cursor: pointer;
		line-height: 50px;
		text-align: center;
		margin: 0;
		text-decoration: none;
		box-shadow: 2px 2px 2px 0px #00000017;
		transition: backdrop-filter 0.2s;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}

	#eg_search {
		height: auto;
		color: #FFF;
		font-size: 18px;
		text-align: center;
		font-style: normal;
		border: 1px solid #777;
		border-width: 1px 1px 3px;
		box-shadow: 0 -1px 0 rgba(255, 255, 255, 0.1) inset;
		cursor: pointer;
		width: auto;
		margin-left: 1vw;
		font-family: 'Poppins', Geneva, Verdana, sans-serif;
	}
</style>

<script>
	var url_text_selected = false;

	function smart_select(ele) {

		ele.onblur = function () {
			url_text_selected = false;
		};

		ele.onclick = function () {
			if (url_text_selected == false) {
				this.focus();
				this.select();
				url_text_selected = true;
			}
		};
	}
</script>

<div id="eg_top_form">

	<form id="eg_form" method="post" action="index.php" target="_top">
		<input id="eg_home" type="button" value="Home" onclick="window.location.href='index.php'">
		<input id="eg_url" type="text" name="url" value="<?php echo $url; ?>" autocomplete="off">
		<input id="eg_hidden" type="hidden" name="form" value="1">
		<input id="eg_submit" type="submit" value="Go">
	</form>

</div>

<script type="text/javascript">
	smart_select(document.getElementsByName("url")[0]);
</script>