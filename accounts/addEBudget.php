<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$Year = mysql_real_escape_string(trim(strip_tags($_POST['Year'])));
$DivID = mysql_real_escape_string(trim(strip_tags($_POST['DivID'])));

exit;
if($DivID == "")
 { 
   	$_SESSION['ErrMsg'] = "No Division Selected";
    if (isset($_SERVER["HTTP_REFERER"])) {
          header("Location: " . $_SERVER["HTTP_REFERER"]);
      }
      exit;
 } 
 else 
 {
 	//Check if exist
 	$chkExist = mysql_query("SELECT * FROM budget_expected WHERE year='$Year' AND division='$DivID'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   $_SESSION['ErrMsg'] = "Already Exist";
         if (isset($_SERVER["HTTP_REFERER"])) {
              header("Location: " . $_SERVER["HTTP_REFERER"]);
          }
		exit;
	 } 

 	$query = "INSERT INTO budget_expected (year, division, isActive) 
VALUES ('$Year', '$DivID', 1);";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Forcast is added";
 if (isset($_SERVER["HTTP_REFERER"])) {
              header("Location: " . $_SERVER["HTTP_REFERER"]);
          }

 }


exit;


?>
