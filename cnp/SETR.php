<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['sr']));
  $SETR = trim(strip_tags($_POST['SETR']));
 


  $Today = date('Y/m/d h:i:s a'); 
 
  //Get Log//////////////////////////////////
  $resultLI = mysql_query("SELECT * FROM vendorsinvoices 
  WHERE cid = '".$ConID."'"); 

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {   
     while ($row = mysql_fetch_array($resultLI)) 
     {
       $SERLog = $row['SERLog'];
       $IVNo = $row['IVNo'];
     }
   }
  //////////////////////////////////////////

   $SERLog = $SERLog . " <br/> @@ Updated On : ".$Today." By : ".$UID ." Set To : ".$SETR;

  $query1 = "UPDATE vendorsinvoices SET SETR='".$SETR."', SERLog='".$SERLog."' WHERE cid='".$ConID."'";


if(mysql_query($query1, $dbhandle))
{
  if($SETR == 1) { echo "GM CS can view ".$IVNo; } else { echo "GM CS can no longer view ".$IVNo; }
  
}

//close the connection
mysql_close($dbhandle);



?>