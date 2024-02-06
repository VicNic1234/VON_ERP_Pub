<?php
session_start();
include ('../DBcon/db_config.php');
//require_once('../notify.php');
include ('../emailsettings/emailSettings.php');


$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$DeptID = $_SESSION['DeptID'];

$impactType = mysql_real_escape_string(trim(strip_tags($_POST['impactType'])));
$CurrOB = mysql_real_escape_string(trim(strip_tags($_POST['CurrOB'])));
$AmtOB = mysql_real_escape_string(trim(strip_tags($_POST['AmtOB'])));
$TDOB = mysql_real_escape_string(trim(strip_tags($_POST['TDOB'])));

$RemarkOB = mysql_real_escape_string(trim(strip_tags($_POST['RemarkOB'])));
$accID = mysql_real_escape_string(trim(strip_tags($_POST['accID'])));

//Let's get Total Amount


  /*$resultCHAMT = mysql_query("SELECT * FROM acc_chart_master WHERE mid = '$accID'");
            //check if user exist
             $NoRowCHAMT = mysql_num_rows($resultCHAMT);
            if ($NoRowCHAMT > 0) 
              {
                while ($row = mysql_fetch_array($resultCHAMT)) 
                {
                  $TAmt = $row['Amt'];
                  
                }
            }
            */
if ( $accID == 0)
{
    $_SESSION['ErrMsg'] = "No GL account to set Opening Balance for.";
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    exit;
  
}

$TodayD = date("Y-m-d h:i:s a");

$TRANCODE = date("Ymdhis")."OB";

$query = "INSERT INTO postings (REQCODE,  GLImpacted, GLDescription, TransactionAmount, 
         TransacType, TransactionDate, Remark, PostedBy, PostedOn, CounterTrans, Currency, RptType) 
         VALUES ('OPEN BAL','$accID','$RemarkOB','$AmtOB', '$impactType', '$TDOB', '$RemarkOB', '$uid', '$TodayD', '$TRANCODE', '$CurrOB', 'Opening Balance');";

mysql_query($query);
///////////////////////////////////////
$_SESSION['ErrMsgB'] = "Posted. Thanks";
if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
mysql_close($dbhandle);
exit;









?>