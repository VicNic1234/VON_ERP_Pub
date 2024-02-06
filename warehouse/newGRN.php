<?php
session_start();
include ('../DBcon/db_config.php');

  $USERID = $_SESSION['uid'];
  

//Take Value from the two guys in index page LOGIN FORM
$GRNCode = trim(strip_tags($_POST['GRNCODENew']));
$ItemsSelected = trim(strip_tags($_POST['ItemsSelected']));

if($GRNCode == "") { echo "Kindly confirm GRN Code"; exit; }

$ArryItems = explode(",",$ItemsSelected);

$ArryCount = count($ArryItems);

//Go through Loop
for ($i = 0; $i < $ArryCount; $i++) {
    	
    	if($ArryItems[$i] != "") { setForGRN($ArryItems[$i], $GRNCode); }
}

echo "success";

function setForGRN($ItemID, $GRNCode)
{
	$USERID = $GLOBALS['USERID'];
	 $NowD = date("Y-m-d h:i:s");
	 //We need to check if Item already iin GRN
	 ///////////////////////////////////////////
	 $result = mysql_query("SELECT * FROM GRN WHERE ItemID='$ItemID'");
	
	$NoRowGRN = mysql_num_rows($result);

	if ($NoRowGRN > 0) 
	{
		goto t;
	}
	 /////////////////////////////////////////
	$query = "INSERT INTO grn (ItemID, GRNCode, CreatedOn, CreatedBy) 
	VALUES ('$ItemID','$GRNCode','$NowD','$USERID');";
     $regResult = mysql_query($query);
t:

 }


//close the connection
mysql_close($dbhandle);




?>