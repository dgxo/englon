<?php
session_start();

if (!isset($_SESSION["username"])) {
   header("Location: /account/login?reason=your%20account&to=" . $_SERVER['REQUEST_URI']);
   exit();
}
?>