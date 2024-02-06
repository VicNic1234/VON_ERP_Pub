<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$UID = $_SESSION['uid'];

  $ConID = trim(strip_tags($_POST['ConID']));
  $VendSource = trim(strip_tags($_POST['VendSource']));
  $PODate = trim(strip_tags($_POST['PODate']));
   $ENLATTN = trim(strip_tags($_POST['ENLATTN']));
  $conDiv = trim(strip_tags($_POST['conDiv']));
  $Comment = trim(strip_tags($_POST['Comment']));
  $ContractNo = trim(strip_tags($_POST['ContractNo']));
  $totalSum = trim(strip_tags($_POST['totalSum']));
  $currency = trim(strip_tags($_POST['currency']));
  $PDFNum = trim(strip_tags($_POST['PDFNum']));
  $Scope = trim(strip_tags($_POST['Scope'])); 


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
  header('Location: viewpo?poid='.$ConID);

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
if($FILEURL != "")
{
  $query1 = "UPDATE purchaseorders SET ScopeOfSW='".$Scope."', PONo='".$ContractNo."', Comment='".$Comment."', conDiv='".$conDiv."', PODate='".$PODate."', ENLATTN='".$ENLATTN."', VendSource='".$VendSource."', FileLink='".$FILEURL."', TotalSum='".$totalSum."', Currency='".$currency."', PDFNUM='".$PDFNum."' WHERE cid='".$ConID."'";
}
else
{
  $query1 = "UPDATE purchaseorders SET ScopeOfSW='".$Scope."', PONo='".$ContractNo."', Comment='".$Comment."', conDiv='".$conDiv."', PODate='".$PODate."', ENLATTN='".$ENLATTN."', VendSource='".$VendSource."', TotalSum='".$totalSum."', Currency='".$currency."', PDFNUM='".$PDFNum."' WHERE cid='".$ConID."'";
}


if(mysql_query($query1, $dbhandle))
{
   


  	$_SESSION['ErrMsgB'] = "Update ".$ContractNo;
	header('Location: viewpo?poid='.$ConID);
mysql_close($dbhandle);
exit;
  	
 }
 else{
echo mysql_error();
exit;
 $_SESSION['ErrMsg'] = "Oops! Did not update : ".$ContractNo;
  header('Location: viewpo?poid='.$ConID);

//close the connection
mysql_close($dbhandle);
}



?>