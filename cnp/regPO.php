<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $VendSource = trim(strip_tags($_POST['VendSource']));
  $PODate = trim(strip_tags($_POST['PODate']));
  $ENLATTN = trim(strip_tags($_POST['ENLATTN']));
  $conDiv = trim(strip_tags($_POST['conDiv']));
  $Comment = addslashes(trim(strip_tags($_POST['Comment'])));
  $ContractNo = trim(strip_tags($_POST['ContractNo']));
  $totalSum = trim(strip_tags($_POST['totalSum']));
  $currency = trim(strip_tags($_POST['currency']));
  $PDFNum = trim(strip_tags($_POST['PDFNum']));
  $Scope = addslashes(trim(strip_tags($_POST['Scope'])));

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
  header('Location: newpo');
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
         if (file_exists("../POAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../POAttach/" . $FILEID .".". $ext;
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

	$query1 = "INSERT INTO purchaseorders (PONo, Comment, conDiv, PODate, ENLATTN, VendSource, RaisedBy, RaisedOn, FileLink, TotalSum, Currency, PDFNUM, ScopeOfSW) 
	VALUES ('".$ContractNo."','".$Comment."','".$conDiv."','".$PODate."','".$ENLATTN."','".$VendSource."','".$UID."','".$Today."', '".$FILEURL."', '".$totalSum."', '".$currency."', '".$PDFNum."', '".$Scope."');";

if(mysql_query($query1, $dbhandle))
{
   //Read CONCount
              $CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'POCount'");
              while ($row = mysql_fetch_array($CONcount)) { $CONcount = $row{'variableValue'}; }

              $CONcount = intval($CONcount) + 1;
   $query2 = "UPDATE sysvar SET variableValue='".$CONcount."' WHERE variableName = 'POCount'";
   mysql_query($query2, $dbhandle);


  	$_SESSION['ErrMsgB'] = "Created ".$ContractNo;
	header('Location: newpo');
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not create : ".$ContractNo;
  header('Location: newpo');
//close the connection
mysql_close($dbhandle);
}



?>