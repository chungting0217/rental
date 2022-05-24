<?php
session_start();
if (!isset($_SESSION["LoginID"])) {
    header("Location: ../timeout.php");
    exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$uDate = date("Y-m-d H:i:s");
?>