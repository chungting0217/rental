<?php
session_start();
if (isset($_SESSION['LoginID']) || !empty($_SESSION['LoginID'])||isset($_SESSION['MLoginID']) || !empty($_SESSION['MLoginID'])) {
    session_unset();
    echo "<script> {window.alert('已經登出');location.href='index.php'} </script>";
    exit();
}else{
    echo "<script>history.go(-1)</script>";
}
?>