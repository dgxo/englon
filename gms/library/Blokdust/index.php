<!DOCTYPE html>
<html>

<head>
    <title>Untitled document - Google Docs</title>
    <link rel="icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description"
        content="Interactive music-making. Build synths & sounds all in the browser, and share your creations..." />
    <meta name="robots" content="noodp,noydir" />
    <meta name="keywords" content="" />

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <style id="selectStyle">
        ::selection {
            background-color: rgba(0, 0, 0, 1);
        }
    </style>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="lib/nullstone/dist/nullstone.min.js"></script>
    <script type="text/javascript" src="lib/minerva/dist/minerva.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.24/webfontloader.js"></script>
    <script type="text/javascript" src="lib/tweenjs/src/Tween.js"></script>
    <script type="text/javascript" src="Workers/WaveWorker.js"></script>
    <script type="text/javascript" src="https://connect.soundcloud.com/sdk/sdk-3.1.2.js"></script>
    <script type="text/javascript" src="App.js" data-main="require-config"></script>

    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="image_src" type="image/png" href="https://files.blokdust.io/images/thumb.jpg">

    <meta property="og:url" content="http://blokdust.com/" />
    <meta property="og:title" content="BlokDust<?php if (isset($_GET["t"])) {
        echo ': ' . htmlentities($_GET["t"], ENT_QUOTES, 'UTF-8');
    } ?>" />
    <meta property="og:description"
        content="Interactive music-making. Build synths & sounds all in the browser, and share your creations. Chrome recommended." />
    <meta property="og:image" content="https://files.blokdust.io/images/thumb.jpg" />

</head>

<body oncontextmenu="return false">
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
    <div class="loading-spinner"></div>

    <div id="shareUrl">
        <form action="">
            <textarea name="text_area" id="shareUrlText" rows="1000" cols="1"
                onClick="this.form.text_area.focus();this.selectionStart=0; this.selectionEnd=this.value.length;"
                readonly>
            </textarea>
        </form>
    </div>

    <div id="shareTitle">
        <form action="">
            <input type="text" id="shareTitleInput" name="title" autocomplete="off" spellcheck="false" maxlength="24"
                value="">
        </form>
    </div>

    <div id="soundCloudSearch">
        <form action="">
            <input type="text" id="soundCloudSearchInput" name="title" autocomplete="off" spellcheck="false"
                maxlength="24" value="">
        </form>
    </div>

    <div id="debug" style="color: #fff; height:20px; overflow: auto; position: absolute"></div>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
                m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-79427742-1', 'auto');
        ga('send', 'pageview');

        function trackEvent(category, action, label) {
            ga('send', 'event', category, action, label);
        }

        function trackVariable(name, value) {
            ga('set', name, value);
        }
    </script>

</body>

</html>