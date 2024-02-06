<?php
session_start(); 
error_reporting(0);
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

   $tncID = trim(strip_tags($_GET['p'])); 
  //$poid = trim(strip_tags($_GET['poid']));

  $Today = date('Y/m/d h:i:s a'); 
  $DelGroupCode = date('Ymdhisa'); 
 $CounterTrans  = "";

if($tncID != "")
{
    //First we need to get its CounterTrans Now
 // $QuerySelCT = "SELECT postings WHERE tncid='$tncID'";
  ////////////////////////////////////////////////
    $QuerySelCT = mysql_query("SELECT * FROM postings WHERE tncid='$tncID' AND isActive = 1");
    $NoRowQuerySelCT = mysql_num_rows($QuerySelCT);
    
   if ($NoRowQuerySelCT > 0) {
      while ($row = mysql_fetch_array($QuerySelCT)) 
      {
         $MCounterTrans = $row['CounterTrans'];
         $Mtncid = $row['tncid'];
         if(mysql_query("UPDATE postings SET isActive='0', DelLog='Deleted By :: ".$UID." :: On = :: ".$Today." ::', DelGroup = '$DelGroupCode' WHERE tncid='".$tncID."'"))
         {
         RecDel($tncID, $MCounterTrans, $Today, $UID);
             
         }
      }
    }
  ////////////////////////////////////////////////////
 // Now we need to check fellow mate posted together;
 if($MCounterTrans == "0" || $MCounterTrans == "")
 {
     $QuerySelCT = mysql_query("SELECT * FROM postings WHERE CounterTrans='$Mtncid' AND isActive = 1");
    $NoRowQuerySelCT = mysql_num_rows($QuerySelCT);
    
   if ($NoRowQuerySelCT > 0) {
      while ($row = mysql_fetch_array($QuerySelCT)) 
      {
        
         $Rtncid = $row['tncid'];
         if(mysql_query("UPDATE postings SET isActive='0', DelLog='Deleted By :: ".$UID." :: On = :: ".$Today." ::', DelGroup = '$DelGroupCode' WHERE tncid='".$Rtncid."'", $dbhandle))
             {
         RecDel($Rtncid, $Mtncid, $Today, $UID);
             
         }
      }
    }
 }
 else
 {
      $QuerySelCT = mysql_query("SELECT * FROM postings WHERE CounterTrans='$MCounterTrans' AND isActive = 1");
    $NoRowQuerySelCT = mysql_num_rows($QuerySelCT);
    
   if ($NoRowQuerySelCT > 0) {
      while ($row = mysql_fetch_array($QuerySelCT)) 
      {
        // $MCounterTrans = $row['CounterTrans'];
         $R2tncid = $row['tncid'];
         if(mysql_query("UPDATE postings SET isActive='0', DelLog='Deleted By :: ".$UID." :: On = :: ".$Today." ::', DelGroup = '$DelGroupCode' WHERE tncid='".$R2tncid."'", $dbhandle))
         {
             RecDel($R2tncid, $MCounterTrans, $Today, $UID);
         }
      }
    }
 }
   
 
}
else
{
  $_SESSION['ErrMsg'] = "Oops! Did not delete ";
   if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
  exit;
}

function RecDel($tncID, $CounterTrans, $Today, $UID)
{
    $dbhandle = $GLOBALS['dbhandle']; $DelGroupCode = $GLOBALS['DelGroupCode'];
     mysql_query("INSERT INTO RecentDeletes (tncid, CounterTrans, DoneOn, DoneBy, DelGroup) VALUES ('$tncID', '$CounterTrans', '$Today', '$UID', '$DelGroupCode')", $dbhandle);
}


 $_SESSION['ErrMsgB'] = "Posting Deleted";
	 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;





?>