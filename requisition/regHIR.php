<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page HIR FORM
$rptLocation = trim(strip_tags($_POST['rptLocation']));
$rptDate = trim(strip_tags($_POST['rptDate']));
$Desc = trim(strip_tags($_POST['Desc']));
$ImAct = mysql_real_escape_string(trim(strip_tags($_POST['ImAct'])));
$FtAct = mysql_real_escape_string(trim(strip_tags($_POST['FtAct'])));
$conDiv = trim(strip_tags($_POST['conDiv']));
$conEDate = trim(strip_tags($_POST['conEDate']));
$htype = $_POST['htype'];
$RAMRating = trim(($_POST['RAMRating']));


if(count($htype) < 1) 
  {
    $_SESSION['ErrMsg'] = "You didn't select any Harzard Type.";
   header('Location: hir');
	exit;
  } 
  else
  {
  	$N = count($htype);
	  $ItemHType ="";
	
    //echo("You selected $N Item(s): <br/> ");
    //echo("<center>	<li> You selected $N Item(s): </li> </center>");
    for($i=0; $i < $N; $i++)
    {
	  $ItemHType .= $htype[$i].",";
	  
    }

  }

 // exit;


if($RAMRating == "") 
  {
    $_SESSION['ErrMsg'] = "You didn't select any RAM Rating.";
   header('Location: hir');
   // echo count($aDoor);
	exit;
  } 



{

$query = "INSERT INTO hir (rptLocation, rptDate, Description, ImAct, FtAct, PartyInv, TargetDate, HType, RAMRating, raisedby, raisedon) 
VALUES ('$rptLocation','$rptDate','$Desc','$ImAct','$FtAct','$conDiv','$conEDate','$ItemHType','$RAMRating', '$UID', '$TDay');";


 if (mysql_query($query))
{
		$_SESSION['ErrMsgB'] = "Congratulations! New HIR is Registered";
        mysql_close($dbhandle);
		header('Location: hir');  exit;
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: hir'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>