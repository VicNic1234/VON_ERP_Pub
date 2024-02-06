<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page JHA FORM
$JHAID = trim(strip_tags($_POST['JHAID']));
$ProjTitle = trim(strip_tags($_POST['ProjTitle']));
$CLient = trim(strip_tags($_POST['CLient']));
$Location = trim(strip_tags($_POST['Location']));
$rptDate = trim(strip_tags($_POST['rptDate']));
$ReviewTeam = trim(strip_tags($_POST['ReviewTeam']));


{

$query = "UPDATE jha SET ProjectTitle='$ProjTitle', Client='$CLient', Location='$Location', rptDate='$rptDate', TeamComposition='$ReviewTeam' WHERE jhaid='$JHAID'"; 


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Congratulations! New JHA is Updated";
        mysql_close($dbhandle);
		header('Location: jhas');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: jhas'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>