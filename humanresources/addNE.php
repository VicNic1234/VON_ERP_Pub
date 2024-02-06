<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

 
//Take Value from the two guys in index page LOGIN FORM
$Nme = trim(strip_tags($_POST['Nme']));
$valtype = trim(strip_tags($_POST['valtype']));
$caltype = trim(strip_tags($_POST['caltype']));
//$DOB = trim(strip_tags($_POST['DOB']));
$Val = mysql_real_escape_string(trim(strip_tags($_POST['Val'])));



$query = "INSERT INTO payrollelement (payname, valtype, caltype, payval) 
VALUES ('$Nme','$valtype','$caltype','$Val');";

//$regResult = mysql_query($query);
 if (mysql_query($query))
 {
 

  	$_SESSION['ErrMsgB'] = "Done";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  	
  }
  else
  {
    $_SESSION['ErrMsgB'] = "Oops!";
    if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}



//close the connection
mysql_close($dbhandle);




?>