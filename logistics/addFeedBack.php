<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
//$Userid = $_SESSION['uid'];
$UserID = $_SESSION['uid'];
$CustomerID = $_SESSION['CustomerID'];


//echo $_FILES['LogisticsFile'];
//exit;

if($_POST)
{

$LineID = mysql_real_escape_string($_POST['LineID']);
$DDPDATE = mysql_real_escape_string($_POST['DDPDate']);
$newUpdate = mysql_real_escape_string($_POST['CUSUpdate']);
$newUpdate = str_replace(array("\r\n", "\r", "\n"), "<br />", $newUpdate);
$DBfilelnk = "";
	if (isset($_FILES['attach']) && $_FILES['attach']['size'] > 0) 
{ 
	//echo "File dey";
	//exit;
 $sizemdia = $_FILES['attach']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: ./Qchk');
  exit;
  }
//Let's set new Name for file
// ensure a safe filename
    $fileSpNme = preg_replace("/[^A-Z0-9._-]/i", "_", basename( $_FILES['attach']['name']));
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($fileSpNme);
    while (file_exists('../LogisticsAttach/'. $fileSpNme)) {
        $i++;
        $fileSpNme = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

  $DBfilelnk = '../LogisticsAttach/' . $fileSpNme;
 move_uploaded_file($_FILES['attach']['tmp_name'], $DBfilelnk);


}

if($DBfilelnk != "")
{
 $SQL = "INSERT INTO crmlitfeedback (LineItemID, Msg, Attachment, FromCRM, ToCRM, CreatedBy) VALUES ('$LineID','$newUpdate', '$DBfilelnk','P','C','$UserID');";

}
else
{
$SQL = "INSERT INTO crmlitfeedback (LineItemID, Msg, FromCRM, ToCRM, CreatedBy) VALUES ('$LineID','$newUpdate','P','C','$UserID');";

}

mysql_query($SQL);

$query = "UPDATE logistics SET DDPDATE='".$DDPDATE."' WHERE logID='".$LineID."'"; 
$result = mysql_query($query);


$_SESSION['ErrMsgB'] = "Congratulations! Updated";
header('Location: ./Qchk');

}

//close the connection
mysql_close($dbhandle);


?>
