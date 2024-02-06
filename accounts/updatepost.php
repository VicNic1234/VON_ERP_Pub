<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$UID = $_SESSION['uid'];


 $PostGL = mysql_real_escape_string(trim(strip_tags($_POST['PostGL']))); 
$PostDesc = mysql_real_escape_string(trim(strip_tags($_POST['PostDesc'])));
$PostRemark = mysql_real_escape_string(trim(strip_tags($_POST['PostRemark'])));
$PostDate = mysql_real_escape_string(trim(strip_tags($_POST['PostDate']))); 
$PostAmt = mysql_real_escape_string(trim(strip_tags($_POST['PostAmt'])));
$ReceivedBy = mysql_real_escape_string(trim(strip_tags($_POST['ReceivedBy'])));
$PID = mysql_real_escape_string(trim(strip_tags($_POST['PID']))); 

//|| $PostGL == ""
if($PID == "" )
 { 
   	$_SESSION['ErrMsg'] = "Kindly fill form completely ";
	if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
 } 
 else 
 {
 
	 //echo $cid; exit;
    $Log = "Update On ".$DateG." by ". $UID;
 	//$query = "UPDATE postings SET GLImpacted='$PostGL', GLDescription='$PostGL', Remark='$PostRemark',  TransactionAmount='$PostAmt', TransactionDate='$PostDate', UpdateLog='$Log', ReceivedBy='$ReceivedBy'
 	$query = "UPDATE postings SET Remark='$PostRemark', UpdateLog='$Log', GLImpacted='$PostGL'	WHERE tncid='$PID'";

//
$resultOldPosting = mysql_query("SELECT * FROM postings WHERE tncid='$PID' ");
      
             $NoRowChartMaster = mysql_num_rows($resultOldPosting);
            if ($NoRowChartMaster > 0) {
              while ($row = mysql_fetch_array($resultOldPosting)) {
                $OLDPostGL = $row['GLImpacted'];
              }
            }
            



//
if (mysql_query($query, $dbhandle))
  {
//$_SESSION['ErrMsgB'] = "Congratulations! Posting is Update";
$sql = "INSERT INTO posting_update (doneby, doneon, OldGL, NewGL, postid)
VALUES ('$UID', '$DateG', '$OLDPostGL', '$PostGL', '$PID')";
mysql_query($sql, $dbhandle);
$_SESSION['ErrMsgB'] = "Congratulations! Transaction description is updated";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    
 }
 else
 {
     echo mysql_error();
 }

 }


exit;


?>
