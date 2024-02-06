<?php
session_start();
include ('../DBcon/db_config.php');

$staffname = $_SESSION['Firstname']. " ". $_SESSION['SurName'];
$uid = $_SESSION['uid'];
$Dept = $_SESSION['DeptID'];

$desp = mysql_real_escape_string(trim(strip_tags($_POST['desp'])));
$ppor = mysql_real_escape_string(trim(strip_tags($_POST['ppor']))); 
$amt = mysql_real_escape_string(trim(strip_tags($_POST['amt'])));
$qnt = mysql_real_escape_string(trim(strip_tags($_POST['qnt'])));
$rPDF = mysql_real_escape_string(trim(strip_tags($_POST['rPDF'])));
$rqid = mysql_real_escape_string(trim(strip_tags($_POST['rqid']))); 

$tcurr = mysql_real_escape_string(trim(strip_tags($_POST['tcurr'])));
$reqstate = mysql_real_escape_string(trim(strip_tags($_POST['reqstate'])));  

$TodayD = date("Y-m-d h:i:s a");

//$RECount = explode("-",$rqid); $RECount = intval(ltrim($RECount[2], '0')) + 1;
if($reqstate == "new"){
$resultPDFCount = mysql_query("SELECT * FROM sysvar WHERE variableName='CASHRCount'");
while ($row = mysql_fetch_array($resultPDFCount)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
       $PDFCount = $row['variableValue'];
     }
$RECount = $PDFCount + 1;
$PDFCountPAD = str_pad($PDFCount,6,"0",STR_PAD_LEFT);
 $rqid = "ENL-CHR-".$PDFCountPAD;
} 

if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
{ 
  $sizemdia = $_FILES['filed']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: cashrequest');
  exit;
  }
}
//exit;
$DocLink = "";
if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
{ 
		$ftmpName  = $_FILES['filed']['tmp_name']; 
     $fimgName = $_FILES['filed']['name'];

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../REQAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../REQAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }

        $DocLink = $FILEURL; 
}
//Let's just Update
if($DocLink != ""){
$query = "INSERT INTO cashreq (Curr, staffID, staffName, ItemDes, Purpose, Amount, Qty, relatedPDF, RequestID, Deparment, RequestDate, attachment) VALUES ('$tcurr','$uid','$staffname','$desp','$ppor','$amt','$qnt','$rPDF', '$rqid', '$Dept', '$TodayD', '$DocLink' );";
}
else{
  $query = "INSERT INTO cashreq (Curr, staffID, staffName, ItemDes, Purpose, Amount, Qty, relatedPDF, RequestID, Deparment, RequestDate) VALUES ('$tcurr','$uid','$staffname','$desp','$ppor','$amt','$qnt','$rPDF', '$rqid', '$Dept', '$TodayD' );";
} 



if (mysql_query($query))
{
//echo mysql_error();
$_SESSION['ErrMsgB'] = "Request Registered!";
//Update Count
if($reqstate == "new"){
$sql_res=mysql_query("UPDATE sysvar SET variableValue='$RECount' WHERE variableName = 'CASHRCount'");
}

///////////////////////////////////////
header('Location: cashrequest');
exit;

}
else
{
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
header('Location: cashrequest');
exit;
}


//close the connection
mysql_close($dbhandle);




?>