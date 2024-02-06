<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page RFQ FORM
$CusSource = trim(strip_tags($_POST['CusSource'])); 
$CusID = explode("@@", $CusSource)[0]; 
$CusSCode = explode("@@", $CusSource)[1];
$conSDate = trim(strip_tags($_POST['conSDate']));
$conEDate = trim(strip_tags($_POST['conEDate']));
$Currency = mysql_real_escape_string(trim(strip_tags($_POST['currency'])));
$Attn = mysql_real_escape_string(trim(strip_tags($_POST['attn'])));
$PONo = mysql_real_escape_string(trim(strip_tags($_POST['PONo'])));
//$RFQFile = mysql_real_escape_string(trim(strip_tags($_POST['RFQFile'])));
$Comment = mysql_real_escape_string(trim(strip_tags($_POST['Comment'])));
$conBusn = trim(strip_tags($_POST['conBusn']));
$CorContract = trim(strip_tags($_POST['CorContract']));
$CorRFQ = trim(strip_tags($_POST['CorRFQ']));



///////////////////////////////////////
if (isset($_FILES['POFile']) && $_FILES['POFile']['size'] > 0) 
{ 
 
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['POFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: receivePO');
  exit;
  }
//Let's set new Name for file
 $ftmpName  = $_FILES['POFile']['tmp_name']; 
        $fimgName = $_FILES['POFile']['name'];
        

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
        if (isset($_FILES['POFile']) && $_FILES['POFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }
////////////////////////////////////////




{

$query = "INSERT INTO cuspo (PONum, Customer, cusid, Attention, DateStart, DateEnd, Comment, RFQBusUnit, Attachment, Status, Currency, PEAID, CreatedOn, CorContract, CorRFQ) 
VALUES ('$PONo','$CusSCode','$CusID', '$Attn', '$conSDate','$conEDate','$Comment','$conBusn','$FILEURL', 'OPEN', '$Currency', '$UID', '$TDay', '$CorContract', '$CorRFQ');";


 if (mysql_query($query))
{
		

    //if(mysql_query($query1, $dbhandle))
{
   
    $_SESSION['ErrMsgB'] = "Recorded Customer PO";
  header('Location: receivePO');
mysql_close($dbhandle);
exit;
    
 }
}
else
{
  echo mysql_error(); exit;
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: receivePO'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>