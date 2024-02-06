<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('../utility/notify.php');

$reqID = $_GET['id'];

$resultLeave = mysql_query("UPDATE empleave SET isActive='0' WHERE id = '".$reqID."'");
header("Location: myleave");


?>