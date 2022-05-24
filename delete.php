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
$sqlcmd = "DELETE FROM spacereserve WHERE sid='$sid' AND Aid='$Aid'AND sportid='$sportid' AND time='$time' AND category='$category'";
$db_conn->query($sqlcmd);
if($category==1)
{
    $sqlcmd = "SELECT * FROM spacetime WHERE sid='$sid'AND sportid='$sportid' AND time='$time'";
    $r = querydb($sqlcmd, $db_conn);
    $people=$r[0]['people'];
    $people=$people+1;
    $sqlcmd="UPDATE spacetime SET people='$people' WHERE sid='$sid'AND sportid='$sportid' AND time='$time'";
    $result = updatedb($sqlcmd, $db_conn);
}
else if($category==2)
{
    $sqlcmd = "SELECT * FROM specialspacetime WHERE sid='$sid'AND sportid='$sportid' AND time='$time'";
    $r = querydb($sqlcmd, $db_conn);
    $people=$r[0]['people'];
    $people=$people+1;
    $sqlcmd="UPDATE specialspacetime SET people='$people' WHERE sid='$sid'AND sportid='$sportid' AND time='$time'";
    $result = updatedb($sqlcmd, $db_conn);
}

if(isset($_SESSION['MLoginID']))
echo "<script> {window.alert('已取消預約');location.href='examine.php'} </script>";
else
echo "<script> {window.alert('已取消預約');location.href='order.php'} </script>";

   
?>