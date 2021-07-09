<?php
session_start();
//debug
$debug = off;
if($debug == on){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}
//website
$namedomain = 'Streaming';
$domain 	= 'http://localhost/projectlinux/';
$copyright = $author  = 'siddiq sanjaya bakti';
$description = 'bla bla bla';
$version	= '1.3';

//database
$host       =   "localhost";
//$user       =   "batchanime";
//$user       =   "INAdik";
$user       =   "admin";
//$password   =   "batchanimegh08";
//$password   =   "akudandiagh0809";
$password   =   "123";
$database   =   "streaming";
$conn = mysqli_connect($host, $user, $password, $database);
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

//define
$shelogin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

//function website
//default on
$featureedit     		= on; //editpage
$featureupload 	 		= on; //upload page
$featurelogin    		= on; //login page
$featureregister 		= on; //register page
$featuredelete	 		= on; //delete page
$featurechanpass		= on; //password change page
$featuredetailaccount 	= on; //change name
?>
 
