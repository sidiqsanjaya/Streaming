<?php
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location:$domain");
exit;
?>