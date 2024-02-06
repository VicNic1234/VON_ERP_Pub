<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$UID = $_SESSION['uid'];

if($UID < 1)
{
     header('Location: ../users/logout');
    exit;
}

  $INVCODE = trim(strip_tags($_POST['INVCODE']));
  $INVSTATUS = $IVSTATUS = trim(strip_tags($_POST['INVSTATUS']));
 if($IVSTATUS == 0)  { $invStatus = '<button class="btn btn-warning btn-sm">Pending with C&P </button>'; } 
if($IVSTATUS == 1)  { $invStatus = '<button class="btn btn-info btn-sm">Pending with CS </button>'; } 
if($IVSTATUS == 2)  { $invStatus = '<button class="btn btn-primary btn-sm">Pending with Internal Control </button>'; } 
if($IVSTATUS == 3)  { $invStatus = "Pending with MD"; }
if($IVSTATUS == 4)  { $invStatus = '<button class="btn btn-danger btn-sm">Approved By MD </button>'; }
if($IVSTATUS == 5)  { $invStatus = '<button class="btn btn-success btn-sm">Paid </button>'; }
//exit;
  $Today = date('Y/m/d h:i:s a'); 


 //Let Read the INVOICE Status
  /////////////////////////////////////////
  $sqlPOREQ=mysql_query("SELECT * FROM vendorsinvoices WHERE cid='$INVCODE'");
while ($rowPOREQ = mysql_fetch_array($sqlPOREQ)) {
      
       $StatusLog = $rowPOREQ['StatusLog'];
       $PrestentStatus = $rowPOREQ['Status'];

     }
     
     $NewStatusLog = $StatusLog . '<div class="rcorners1">'.$invStatus.'  | <b>'.$Today.' By '.$UID.' 4ma Status : '.$PrestentStatus.'</b></div>';
     
      $query1 = "UPDATE vendorsinvoices SET StatusLog='".$NewStatusLog."', Status='".$INVSTATUS."' WHERE cid='".$INVCODE."'";
      
      if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Updated";
  	 if (isset($_SERVER["HTTP_REFERER"])) {
        //header("Location: " . $_SERVER["HTTP_REFERER"]);
         header("Location: printINVOICE?cnid=".$INVCODE);
        
       }
  	
}


?>