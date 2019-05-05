<?php
session_start();
error_reporting(1);
 
putenv("TZ=Europe/Istanbul");
date_default_timezone_set('Europe/Istanbul');

  
define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","yazilim_MobilHaberSitesi"); 


$host = DB_SERVER;
$user = DB_USER;
$password = DB_PASS;
$db = DB_NAME; 
 
try {
     $db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
	 $db->query("SET CHARACTER SET uf8");
} catch ( PDOException $e ){
     print $e->getMessage();
} 
 
?>