<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$preg = "I like this show, 
Copyright Disclaimer Under Section 107 of the Copyright Act 1976, allowance is made for fair use for purposes such as criticism, comment, news reporting, teaching, scholarship, and research. Fair use is a use permitted by copyright statute that might otherwise be infringing. Non-profit, educational, or personal use is in favor of fair use.";
$pattern = '';
$value = preg_filter("/^[a-zA-Z0-9 \(\)\n,.-]*$/", '$0' ,$preg);

print_r($value);
echo "<br>";
var_dump($value);
?>