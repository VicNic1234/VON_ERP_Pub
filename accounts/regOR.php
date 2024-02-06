<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];

if($_POST)
{
$q=$_POST['OR'];

//Let Register OR now

$chkExist = mysql_query("SELECT * FROM otherreceiver WHERE FullName='$q'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	echo "Receiver with this FullName already exist"; exit;
    }

    /////////////
    $query = "INSERT INTO otherreceiver (FullName, CreatedBy, CreatedOn, isActive) 
VALUES ('$q', '$UID', '$DateG', 1);";

mysql_query($query);
		
/*$ItemInfo = array(
    'uid' => 1,
    'fullname' => "God's Great Grace"
);
*/

echo '<option value="OR'.mysql_insert_id().'" selected >'.$q.'</option>';

//echo json_encode($ItemInfo);

}
?>
