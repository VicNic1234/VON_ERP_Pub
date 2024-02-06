<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];

 
if($_POST)
{

$updateTEXT = mysql_real_escape_string(strip_tags(trim($_POST['updateTEXT']))); //
$updateITEM = strip_tags(trim($_POST['updateITEM'])); //LIDpuc
$ReplaceITEM = str_replace("'","",$updateITEM);
$SPlitTEMs = explode(",", $ReplaceITEM);
//print_r($SPlitTEMs);
$Itmen = count($SPlitTEMs);
if($Itmen < 1) 
  {
    $_SESSION['ErrMsg'] = "You didn't select any item.";
   header('Location: Qchk');
   // echo count($aDoor);
  exit;
  } 
else
{

  for($i=0; $i < $Itmen; $i++)
    {

      if($SPlitTEMs[$i] > 1){
        $Logid = $SPlitTEMs[$i];
        $resultOldUpdate = mysql_query("SELECT * FROM logistics WHERE logID = '$Logid'", $dbhandle);
        $NoRowOldUpdate = mysql_num_rows($resultOldUpdate);


              if ($NoRowOldUpdate > 0) 
              {

              while ($row = mysql_fetch_array($resultOldUpdate)) {

                $OEMUpdate = $row['OEMUpdate'];
                $AttachUpdate = $row['AttachmentUpdate'];
                $logIDn = $row['logID'];
                $POID = $row['POID']; 
                $OEMUpdate  = $OEMUpdate . "<br/>" . $updateTEXT . " : Created On - " .$DateG."<br/>";
                }

                $sql_res="UPDATE logistics SET OEMUpdate='$OEMUpdate' WHERE logID = '$logIDn'";
                mysql_query($sql_res, $dbhandle);
               // echo "ffgfgdfdf";
                
                //exit;

              }

              else
              {
                //echo "fh";
              }

      }

       
    }
     $_SESSION['ErrMsgB'] = "Congratulations! OEM Info. Updated!";
        header('Location: Qchk?sRFQ='.$POID);
        
        exit;
}

//close the connection
        mysql_close($dbhandle);
}




?>
