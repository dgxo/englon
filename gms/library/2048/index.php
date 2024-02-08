<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="css/keyframes.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/media.css">
   <link rel="shortcut icon" href="/favicon.ico">

   <title>Untitled document - Google Docs</title>
   <link rel="icon" href="/favicon.ico" />
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
   <div class="container">
      <div class="heading">
         <h1 class="title">
            <a href="">2048</a>
         </h1>
         <div class="scores-container">
            <div class="score-container">
               <p class="title">SCORE</p>
               <p class="score">0</p>
               <div class="score-addition">
                  +4
               </div>
            </div>
            <div class="best-container">
               <p class="title">BEST</p>
               <p class="score">66666</p>
            </div>
         </div>
      </div>
      <div class="game-intro">
         <a href="" class="restart-btn">New Game</a>
         <h2 class="subtitle">
            Englon 2048 - Get to 4096 for a reward!
         </h2>
         <p class="above-game">
            Merge the numbers and reach the <strong>2048</strong> tile.
         </p>
      </div>
      <div class="game-container">
         <div class="grid-container">
            <div class="grid-row">
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
               <div class="grid-cell"></div>
            </div>
         </div>
         <div class="tile-container">

         </div>
         <div class="failure-container pop-container">
            <p>:(</p>
            <p>L YOU LOST</p>
         </div>
         <div class="winning-container pop-container">
            <?php $pass = substr(md5(uniqid(mt_rand(), true)), 0, 16);
            error_log($pass . ' trying 2048 from ' . $_SERVER['REMOTE_ADDR']); ?>

            <script>
               function winSend() {
                  if (won == true) {
                     location.href = 'https://englon.uk/chat/index.php?pass=<?= $pass ?>';
                  }
               }
            </script>

            <p>:O</p>
            <p>YOU WON</p>
            <p>Click <a onclick="winSend()">here</a> to claim your reward!</p>
         </div>
      </div>
      <div class="footer">
         <span>
            Originally made by
            <a href="https://github.com/gd4Ark/2048">4Ark</a> (some chinese man)
         </span>
      </div>
   </div>
   <script src="js/config.js"></script>
   <script src="js/data.js"></script>
   <script src="js/utils.js"></script>
   <script src="js/event.js"></script>
   <script src="js/view.js"></script>
   <script src="js/game.js"></script>
   <script src="js/main.js"></script>
</body>

</html>