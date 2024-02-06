<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $VendSource = trim(strip_tags($_POST['VendSource']));
  $conSDate = trim(strip_tags($_POST['conSDate']));
  $conEDate = trim(strip_tags($_POST['conEDate']));
  $conDiv = trim(strip_tags($_POST['conDiv']));
  $Comment = trim(strip_tags($_POST['Comment']));
  $ContractNo = trim(strip_tags($_POST['ContractNo']));
  $totalSum = trim(strip_tags($_POST['totalSum']));
  $currency = trim(strip_tags($_POST['currency']));
  $PDFNum = trim(strip_tags($_POST['PDFNum']));

  $Today = date('Y/m/d h:i:s a'); 
 
  
if (isset($_FILES['CONFile']) && $_FILES['CONFile']['size'] > 0) 
{ 
 
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['CONFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: newcontract');
  exit;
  }
//Let's set new Name for file
 $ftmpName  = $_FILES['CONFile']['tmp_name']; 
        $fimgName = $_FILES['CONFile']['name'];
        

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../CONAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../CONAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['CONFile']) && $_FILES['CONFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }

	$query1 = "INSERT INTO contracts (ContractNo, Comment, conDiv, conSDate, conEDate, VendSource, RaisedBy, RaisedOn, FileLink, TotalSum, Currency, PDFNUM) 
	VALUES ('".$ContractNo."','".$Comment."','".$conDiv."','".$conSDate."','".$conEDate."','".$VendSource."','".$UID."','".$Today."', '".$FILEURL."', '".$totalSum."', '".$currency."', '".$PDFNum."');";

if(mysql_query($query1, $dbhandle))
{
   //Read CONCount
              $CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'CONTRACTCOUNT'");
              while ($row = mysql_fetch_array($CONcount)) { $CONcount = $row{'variableValue'}; }

              $CONcount = intval($CONcount) + 1;
   $query2 = "UPDATE sysvar SET variableValue='".$CONcount."' WHERE variableName = 'CONTRACTCOUNT'";
   mysql_query($query2, $dbhandle);


  	$_SESSION['ErrMsgB'] = "Created ".$ContractNo;
	header('Location: newcontract');
mysql_close($dbhandle);
exit;
  	
 }
 else{
//echo mysql_error();
//exit;
 $_SESSION['ErrMsg'] = "Oops! Did not create : ".$ContractNo;
  header('Location: newcontract');
//close the connection
mysql_close($dbhandle);
}



?>