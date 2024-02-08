<?php
require("auth_session.php");

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] == false) {
   $error = 'This geezer tried to get into the php_info page, and has the username ' . $_SESSION['username'];
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
   header("Location: login");
   exit();
}

phpinfo();

?>