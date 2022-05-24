<?php
$SystemName = 'rental.isrcttu.net';
$dbhost = "mariadb.cc-isac.org";
$dbname = "proj10db";
$dbuser = "proj10dbuser";
$dbpwd = "proj10au4a83";
$uDate = date("Y-m-d H:i:s");
$ErrMsg = "";
$UserIP = '';
if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    $UserIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if (isset($_SERVER['REMOTE_ADDR'])) $UserIP = $_SERVER['REMOTE_ADDR'];
?>
