<?php
require_once("includes/session.php");
require_once("includes/functions.php");
//simple logout
$_SESSION["user_id"] = null;
$_SESSION["username"] = null;
$_SESSION["role_id"] = null;

//destroy session
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', (time() - 42000));
}
session_destroy();

redirect_to("login.php");
?>