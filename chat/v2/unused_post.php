<?php

// require "vendor/autoload.php";

// $tester = new swearjar\Tester;

$con = new mysqli(
   "localhost",
   "phpmysql",
   "j%XNr&P'j!#~89@",
   "englon"
);


// Check connection
if ($con->connect_error) {
   $error = 'Failed to connect to database on message send: ' . $con->connect_error;
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   $error = "this nob went to post.php";
   $error_encoded = trim(base64_encode($error), '=');
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . $error_encoded);
   die();
}

session_start();

if (!isset($_SESSION['username']) && !isset($_POST['text'])) {
   $error = "Not logged in at post.php or no input";
   $error_encoded = trim(base64_encode($error), '=');
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . $error_encoded);
   die();
}


// New db-based code



$contents = $_POST['text'];
$contents = mb_strimwidth($_POST['text'], 0, 500, "...");
$contents = stripslashes(htmlspecialchars($contents));

$author = $_SESSION['id'];

// embeds
$matches = [];
// puts link into anchor tag
preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', $text, $matches);

$embed = null;
if (isset($matches[0])) {
   $link = $matches[0];

   // make get request to link preview API
   $ch = curl_init('https://api.linkpreview.net/?key=50dc46cfcf2c56c2fc0720b58deb5c48&q=' . $link);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($ch);
   curl_close($ch);

   $host = $_SERVER['HTTP_HOST'];
   $embed = $response;
}

$attachment = null;
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
   if ($_FILES["file"]["size"] > 10000000) { // 10 MB
      die("Your file is too large.");
   }
   error_log($imageFileType);
   // Allow certain file formats
   if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
      && $imageFileType != "webp" && $imageFileType != "mp4" && $imageFileType != "webm"
   ) {
      die("Only JPG, PNG & GIF files are allowed.");
   }

   if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      $text = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a class="link" href="$1">$1</a>', $text, -1, $link_count);

      $attachment = $filename;

      file_put_contents("log.html", $text_message, FILE_APPEND);
   } else {
      $error = "Couldn't move uploaded avatar " . $_FILES['file']['name'];
      error_log("Gave SWR error: " . $error);
      header("Location: /swr?id=" . base64_encode($error));
   }
}


// send chat

$stmt = $conn->prepare("INSERT INTO chat (author, contents, attachment, embed, type) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sss", $author, $contents, $attachment ?: null, $embed ?: null, 0); // 0 being a normal message

$result = mysqli_query($con, $query);

$stmt->close();
$conn->close();

if (mysqli_error($con)) {
   $error = 'Insert failed on message send with error ' . mysqli_error($con);
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
   die();
}

// Increment messages count
$_SESSION['messages'] += 1;

$stmt = $conn->prepare("UPDATE users SET messages = ? WHERE id = ?");
$stmt->bind_param("ss", $_SESSION['messages'], $author);

$result = mysqli_query($con, $query);

$stmt->close();
$conn->close();

function sendToWebhook($webhookurl, $json_data)
{
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
      $error = 'cURL error in sendToWebhook, with error ' . $err;
      error_log("Gave SWR error: " . $error);
      header("Location: /swr?id=" . base64_encode($error));
   }
   return $response;
}

$json_data = json_encode([
   "content" => $text,
   "username" => $_SESSION['username'],
   "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar']
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

sendToWebhook('https://discord.com/api/webhooks/1120794272627691631/HI1hKaE_wkrULwTrHkS82Pb84LUmml7o2RFnSElDd75KQ13hFDXhaQ2nWJhygwzKRlXw', $json_data);
sendToWebhook('https://discord.com/api/webhooks/1182465059939696740/6vHH2suurW8kcezQRdJeIyX-E1zTbXfG-hf_eJeDeK2pL2GcSWemVgg7kVBjqMh6nIor', $json_data);










// Old log.html code


// if (isset($_SESSION['username']) && isset($_POST['text'])) {
//    $text = mb_strimwidth($_POST['text'], 0, 400, "...");
//    $text = $_POST['text'] ? stripslashes(htmlspecialchars($text)) : 'OH NO HELP ME PLEASE';

//    // $text = $translator->translate($text, 'en', 'cy');

//    $username = $_SESSION['username'];
//    $avatar = $_SESSION['avatar'] ? $_SESSION['avatar'] : 'default.png';
//    $time = date("g:i A");

//    // links (only adds a preview for one for now to prevent spam)
//    $matches = [];
//    // puts link into anchor tag
//    preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', $text, $matches);

//    $link_preview = '';
//    if (isset($matches[0])) {
//       $link = $matches[0];

//       // make get request to link preview API
//       $ch = curl_init('https://api.linkpreview.net/?key=50dc46cfcf2c56c2fc0720b58deb5c48&q=' . $link);
//       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//       $response = curl_exec($ch);
//       curl_close($ch);
//       $response = json_decode($response);

//       $host = $_SERVER['HTTP_HOST'];
//       $link_preview = "<br><div class='link-preview'><div class='preview-title'><a href='$response->url' class='preview-link'>$response->title</a><div class='preview-description'>$response->description</div></div>" . ($response->image ? "<div class='preview-icon'><img src='https://$host/images/resize/?url=$response->image&w=100&h=100&fit=cover'></div>" : "") . "</div>";
//    }

//    # file processing
//    if ($_FILES['file']['tmp_name']) {
//       $target_dir = "../images/uploads/";
//       $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
//       $filename = substr(str_shuffle(MD5(microtime())), 0, 20) . '.' . stripslashes($imageFileType);
//       // $fileName = stripslashes($_SESSION['username']) . $_SESSION['id'] . '.' . stripslashes($imageFileType);
//       $target_file = $target_dir . $filename;
//       // Check if image file is a actual image or fake image
//       $check = getimagesize($_FILES["file"]["tmp_name"]);
//       if ($check == false) {
//          die("File is not an image.");
//       }

//       // Check file size
//       if ($_FILES["file"]["size"] > 3000000) { // 3MB
//          die("Your file is too large.");
//       }
//       error_log($imageFileType);
//       // Allow certain file formats
//       if (
//          $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
//          && $imageFileType != "webp" && $imageFileType != "mp4" && $imageFileType != "webm"
//       ) {
//          die("Only JPG, PNG & GIF files are allowed.");
//       }

//       if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//          $text = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a class="link" href="$1">$1</a>', $text, -1, $link_count);

//          // sanitise

//          if ($imageFileType == "mp4" || $imageFileType == "webm") {
//             $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username <span class='chat-time'>$time</span></div><div class='text'>$text</div><br><video style='background: url(/images/spinner.svg) no-repeat center center;' onload='this.style.background = `none`' loading='lazy' src='/images/uploads/$filename'>$link_preview</div>\n";
//          } else {
//             $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username <span class='chat-time'>$time</span></div><div class='text'>$text</div><br><img style='background: url(/images/spinner.svg) no-repeat center center;' onload='this.style.background = `none`' loading='lazy' src='/images/uploads/$filename'>$link_preview</div>\n";
//          }

//          file_put_contents("log.html", $text_message, FILE_APPEND);
//       } else {
//          $error = "Couldn't move uploaded avatar " . $_FILES['file']['name'];
//          error_log("Gave SWR error: " . $error);
//          header("Location: /swr?id=" . base64_encode($error));
//       }
//    } else { # no file uploaded
//       $htmltext = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a class="link" href="$1">$1</a>', $text); // linkify

//       $text_message = "<div class='msgln'><img class='avatar' src='/images/avatars/$avatar'><div class='user'>$username <span class='chat-time'>$time</span></div><div class='text'>$htmltext</div>$link_preview</div>\n";

//       file_put_contents("log.html", $text_message, FILE_APPEND);
//    }

//    // Increment messages count
//    $_SESSION['messages'] += 1;
//    require('/var/www/html/englon/db.php');

//    $create_datetime = date("Y-m-d H:i:s");
//    $query = "UPDATE users SET messages = " . $_SESSION['messages'] . " WHERE username = '" . $_SESSION['username'] . "'";
//    $result = mysqli_query($con, $query);

//    // Send message to Discord webhook

//    $webhookurl = 'https://discord.com/api/webhooks/1120794272627691631/HI1hKaE_wkrULwTrHkS82Pb84LUmml7o2RFnSElDd75KQ13hFDXhaQ2nWJhygwzKRlXw';

//    $json_data = json_encode([
//       "content" => $text,
//       "username" => $_SESSION['username'],
//       "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar']
//    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

//    $ch = curl_init($webhookurl);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//    curl_setopt($ch, CURLOPT_HEADER, 0);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//    $response = curl_exec($ch);
//    $err = curl_error($ch);
//    curl_close($ch);

//    if ($err) {
//       $error = 'cURL error in chat post, with error ' . $err;
//       error_log("Gave SWR error: " . $error);
//       header("Location: /swr?id=" . base64_encode($error));
//    }

//    // Send message to SECOND Discord webhook in new server

//    $webhookurl = 'https://discord.com/api/webhooks/1182465059939696740/6vHH2suurW8kcezQRdJeIyX-E1zTbXfG-hf_eJeDeK2pL2GcSWemVgg7kVBjqMh6nIor';

//    $json_data = json_encode([
//       "content" => $text,
//       "username" => $_SESSION['username'],
//       "avatar_url" => 'https://englon.biz/images/avatars/' . $_SESSION['avatar']
//    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


//    $ch = curl_init($webhookurl);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
//    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//    curl_setopt($ch, CURLOPT_HEADER, 0);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//    $response = curl_exec($ch);
//    $err = curl_error($ch);
//    curl_close($ch);

//    if ($err) {
//       $error = 'cURL error in chat post, with error ' . $err;
//       error_log("Gave SWR error: " . $error);
//       header("Location: /swr?id=" . base64_encode($error));
//    }
// }
?>