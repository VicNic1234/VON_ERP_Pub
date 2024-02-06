<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['sr']));
  $SETR = trim(strip_tags($_POST['SETR']));
 


  $Today = date('Y/m/d h:i:s a'); 
 
  //Get Log//////////////////////////////////
  $resultLI = mysql_query("SELECT * FROM contracts 
  WHERE cid = '".$ConID."'"); 

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {   
     while ($row = mysql_fetch_array($resultLI)) 
     {
       $SERLog = $row['SERLog'];
       $IVNo = $row['ContractNo'];
     }
   }
  //////////////////////////////////////////

   $SERLog = $SERLog . " <br/> @@ Updated On : ".$Today." By : ".$UID ." Set To : ".$SETR;

  $query1 = "UPDATE contracts SET AllowMD='".$SETR."', SERLog='".$SERLog."' WHERE cid='".$ConID."'";


if(mysql_query($query1, $dbhandle))
{
  if($SETR == 1) { echo "MD can view ".$IVNo; } else { echo "MD can no longer view ".$IVNo; }
  
}

//close the connection
mysql_close($dbhandle);



?>