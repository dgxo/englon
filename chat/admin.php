<?php
session_start();
$action = htmlspecialchars($_POST['action']);

if (isset($_SESSION['admin'])) {
   if ($action == 'clear-chat') {
      $emptycheck = file_put_contents("log.html", "");
      error_log('!! Cleared log.html !! ');
   } elseif ($action == 'del-msg' || $action == 'del-msgs') {
      $lines = file("log.html");
      $counter = intval(stripslashes($_POST['msgcount']));
      error_log('Messages: ' . $counter);
      while ($counter > 0) {
         // remove the last element from the array
         array_pop($lines);
         $counter--;
      }
      file_put_contents("log.html", implode('', $lines));
   }
} else {
   $error = 'This goofy mf tried to use the admin api, with the username ' . $_SESSION['username'];
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
}
error_log('Request to admin.php with action ' . $action . ' from IP: ' . $_SERVER['REMOTE_ADDR']);
?>

<html style="filter: invert();">
<h1>go away</h1>

</html>