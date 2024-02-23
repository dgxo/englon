<?php
require("auth_session.php");
// Destroy session
if (session_destroy()) {
   header("Location: login");
} else {
   $error = 'Session destruction on logout failed';
   error_log("Gave SWR error: " . $error);
   header("Location: /swr?id=" . base64_encode($error));
}
