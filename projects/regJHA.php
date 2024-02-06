<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page HIR FORM
$ProjTitle = trim(strip_tags($_POST['ProjTitle']));
$CLient = trim(strip_tags($_POST['CLient']));
$Location = trim(strip_tags($_POST['Location']));
$rptDate = trim(strip_tags($_POST['rptDate']));
$ReviewTeam = trim(strip_tags($_POST['ReviewTeam']));


{

$query = "INSERT INTO jha (ProjectTitle, Client, Location, rptDate, TeamComposition, raisedby, raisedon) 
VALUES ('$ProjTitle','$CLient','$Location','$rptDate','$ReviewTeam', '$UID', '$TDay');";


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Congratulations! New JHA is Registered";
        mysql_close($dbhandle);
		header('Location: newjha');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: newjha'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>