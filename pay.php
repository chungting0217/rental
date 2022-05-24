<?php
session_start();
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("htmlpurifier/library/HTMLPurifier.auto.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sid=$_GET['sid'];
$Aid=$_GET['Aid'];
$sportid=$_GET['sportid'];
$time=$_GET['time'];
$category=$_GET['category'];
$sqlcmd = "SELECT * FROM spacereserve WHERE sid='$sid'AND Aid='$Aid' AND sportid='$sportid' AND time='$time'AND category='$category'";
$r = querydb($sqlcmd, $db_conn);
$date=$r[0]['date'];
$people=$r[0]['people'];
$rsqlcmd='INSERT INTO payment (sid,Aid,sportid,date,time,people,category) VALUES ('
."?,?,?,?,?,?,?)";
$result = $db_conn->prepare($rsqlcmd);
$result->execute(array($sid,$Aid,$sportid,$date,$time,$people,$category));

$sqlcmd = "DELETE FROM spacereserve WHERE sid='$sid' AND Aid='$Aid'AND sportid='$sportid' AND time='$time' AND category='$category'";
$db_conn->query($sqlcmd);

if(isset($_SESSION['MLoginID']))
echo "<script> {window.alert('已繳費');location.href='examine.php'} </script>";
else
echo "<script> {window.alert('已取消預約');location.href='order.php'} </script>";

   
?>