<?php
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("htmlpurifier/library/HTMLPurifier.auto.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqlcmd = "SELECT * FROM spaces ";
$rs = querydb($sqlcmd, $db_conn);
$today = date("Y/m/d"); 

    foreach($rs as $row)
    {
        $uid=$row['sid'];
        $sname=$row['sname'];
        if(strtotime($today)>strtotime($row['date']))
        {

            $next = date("Y/m/d",strtotime("+7 day",strtotime($row['date'])));
            $sqlcmdud="UPDATE spaces SET date='$next' WHERE sid='$uid' AND sname='$sname'";
            $result = updatedb($sqlcmdud, $db_conn);

            $sqlcmds = "SELECT * FROM spacetime WHERE sid='$uid'";
            $rss=querydb($sqlcmds, $db_conn);
            foreach($rss as $r)
            {
                $limit=$r['limitpeople'];
                $time=$r['time'];
                $sportid=$r['sportid'];
                $sqlcmdud="UPDATE spacetime SET people='$limit' WHERE sid='$uid' AND time='$time' AND sportid='$sportid'";
                $result = updatedb($sqlcmdud, $db_conn);
            }
            
        }
          
    }
    $sqlcmd = "SELECT * FROM spacereserve ";
    $rs = querydb($sqlcmd, $db_conn);
    foreach($rs as $row)
    {
        $sid=$row['sid'];
        $Aid=$row['Aid'];
        $date=$row['date'];
        $sportid=$row['sportid'];
        $time=$row['time'];
        $category=$row['category'];
        if(strtotime($today)>strtotime($date))
        {
            $sqlcmd = "DELETE FROM spacereserve WHERE sid='$sid' AND Aid='$Aid'AND sportid='$sportid' AND date='$date'AND time='$time' AND category='$category'";
            $db_conn->query($sqlcmd);
            
        }
          
    }
    $sqlcmd = "SELECT * FROM payment ";
    $rs = querydb($sqlcmd, $db_conn);
    foreach($rs as $row)
    {
        $sid=$row['sid'];
        $Aid=$row['Aid'];
        $date=$row['date'];
        $sportid=$row['sportid'];
        $time=$row['time'];
        $category=$row['category'];
        if(strtotime($today)>strtotime($date))
        {
            $sqlcmd = "DELETE FROM payment WHERE sid='$sid' AND Aid='$Aid'AND sportid='$sportid' AND date='$date'AND time='$time' AND category='$category'";
            $db_conn->query($sqlcmd);
            
        }
          
    }
    $sqlcmd = "SELECT * FROM specialspaces ";
    $rs = querydb($sqlcmd, $db_conn);
    foreach($rs as $row)
    {
        $sid=$row['sid'];
        $date=$row['date'];

        if(strtotime($today)>strtotime($date))
        {
            $sqlcmds = "SELECT * FROM specialspacessport WHERE sid='$sid' ";
            $rss = querydb($sqlcmds, $db_conn);
            foreach($rss as $r)
            {
                $sportid=$r['sportid'];
                $sqlcmdss = "DELETE FROM specialspacetime WHERE sid='$sid' AND  sportid='$sportid' ";
                $db_conn->query($sqlcmdss);
            }
            $sqlcmdd = "DELETE FROM specialspacessport WHERE sid='$sid'";
            $db_conn->query($sqlcmdd);
            $sqlcmddd = "DELETE FROM specialspaces WHERE sid='$sid' AND date='$date'";
            $db_conn->query($sqlcmddd);
            
        }
          
    }
?>