<?php
// use Translation\Translator\Translator;
// use Translation\Translator\Service\GoogleTranslator;

// include __DIR__ . '/vendor/autoload.php';

// $translator = new Translator();
// $translator->addTranslatorService(new GoogleTranslator('api_key'));

session_start();

if (isset($_SESSION['username']) && isset($_POST['text'])) {
   $contents = !empty($_POST['text']) ? htmlspecialchars($_POST['text']) : 'Empty message';
   $contents = mb_strimwidth($contents, 0, 46, "poo monster...");

   // $text = $translator->translate($text, 'en', 'cy');

   $username = empty($_SESSION['username']) ? 'Guest' : htmlspecialchars($_SESSION['username']);
   $avatar = $_SESSION['avatar'] ? $_SESSION['avatar'] : 'default.png';
   $tz = 'Europe/London';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
$time = $dt->format('l jS, g:i a');

   // links (only adds a preview for one for now to prevent spam)
   $matches = [];
   // puts link into anchor tag
   preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', $contents, $matches);

   $link_preview = '';
   if (isset($matches[0])) {
      $link = $matches[0];

      // make get request to link preview API
      $ch = curl_init('https://api.linkpreview.net/?key=50dc46cfcf2c56c2fc0720b58deb5c48&q=' . $link);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
      $response = json_decode($response);

      $host = $_SERVER['HTTP_HOST'];
      $link_preview = "<br><div class='link-preview'><div class='preview-title'><a href='$response->url' class='preview-link'>$response->title</a><div class='preview-description'>$response->description</div></div>" . ($response->image ? "<div class='preview-icon'><img src='https://$host/images/resize/?url=$response->image&w=100&h=100&fit=cover'></div>" : "") . "</div>";
   }

   # file processing
   if ($_FILES['file']['tmp_name']) {
      $target_dir = "../images/uploads/";
      $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
      $filename = substr(str_shuffle(MD5(microtime())), 0, 20) . '.' . stripslashes($imageFileType);
      // $fileName = stripslashes($_SESSION['username']) . $_SESSION['id'] . '.' . stripslashes($imageFileType);
      $target_file = $target_dir . $filename;
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["file"]["tmp_name"]);
      if ($check == false) {
         die("File is not an image.");
      }

      // Check file size
      if ($_FILES["file"]["size"] > 3000000) { // 3MB
         die("Your file is too large.");
      }

      // Allow certain file formats
      if (
         $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
         && $imageFileType != "webp" && $imageFileType != "mp4" && $imageFileType != "webm"
      ) {
         die("Only JPG, PNG & GIF files are allowed.");
      }

      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
         $contents = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a class="link" href="$1">$1</a>', $contents, -1, $link_count);

         // sanitise

         if ($imageFileType == "mp4" || $imageFileType == "webm") {
            $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username <span class='chat-time'>$time</span></div><div class='text'>$contents</div><br><video style='background: url(/images/spinner.svg) no-repeat center center;' onload='this.style.background = `none`' loading='lazy' src='/images/uploads/$filename'>$link_preview</div>\n";
         } else {
            $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username <span class='chat-time'>$time</span></div><div class='text'>$contents</div><br><img style='background: url(/images/spinner.svg) no-repeat center center;' onload='this.style.background = `none`' loading='lazy' src='/images/uploads/$filename'>$link_preview</div>\n";
         }

         file_put_contents("log.html", $text_message, FILE_APPEND);
      } else {
         $error = "Couldn't move uploaded avatar " . $_FILES['file']['name'];
         error_log("Gave SWR error: " . $error);
         header("Location: /swr?id=" . base64_encode($error));
      }
   } else { # no file uploaded
      $htmltext = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a class="link" href="$1">$1</a>', $contents); // linkify

      $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username " . ($_SESSION['id'] == 1 ? "<span class='rank'>Owner</span>" : "") . "<span class='chat-time'>$time</span></div><div class='text'>$htmltext</div>$link_preview</div>\n";

      file_put_contents("log.html", $text_message, FILE_APPEND);
   }

   // Increment messages count
   $_SESSION['messages'] += 1;
   require('/var/www/html/englon/db.php');

   $create_datetime = date("Y-m-d H:i:s");
   $query = "UPDATE users SET messages = " . $_SESSION['messages'] . " WHERE username = '" . $_SESSION['username'] . "'";
   $result = mysqli_query($con, $query);

   $ip = $_SERVER['REMOTE_ADDR'];
   error_log("User sent chat message: $username, $ip");

   // Send message to Discord webhook

   $webhookurl = 'https://discord.com/api/webhooks/1182465059939696740/6vHH2suurW8kcezQRdJeIyX-E1zTbXfG-hf_eJeDeK2pL2GcSWemVgg7kVBjqMh6nIor';

   $json_data = json_encode([
      "content" => $contents,
      "username" => $_SESSION['username'],
      "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar']
   ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

   $ch = curl_init($webhookurl);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   $response = curl_exec($ch);
   $err = curl_error($ch);
   curl_close($ch);

   if ($err) {
      $error = 'cURL error in chat post, with error ' . $err;
      error_log("Gave SWR error: " . $error);
      header("Location: /swr?id=" . base64_encode($error));
   }
}

function censorProfanity($string)
{
   $badword = array();
   $replacementword = array();
   $wordlist = file_get_contents('../../chatutils/profanity.txt');
   $words = explode("|", $wordlist);
   foreach ($words as $key => $word) {
      $badword[$key] = $word;
      $replacementword[$key] = addStars($word);
      $badword[$key] = "/\b{$badword[$key]}\b/i";
   }
   $string = preg_replace($badword, $replacementword, $string);
   return $string;
}

function addStars($word)
{
   $length = strlen($word);
   return substr($word, 0, 1) . str_repeat("*", $length - 2) . substr($word, $length - 1, 1);
}
