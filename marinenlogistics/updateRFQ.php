<?php
session_start();
include ('../DBcon/db_config.php');

  
$UID = $_SESSION['uid'];
$TDay = date("Y-m-d h:i:s a");


//Take Value from the two guys in index page RFQ FORM
$RFQIDn = trim(strip_tags($_POST['RFQIDn'])); 
//$CusSource = trim(strip_tags($_POST['CusSource'])); 
//$CusID = explode("@@", $CusSource)[0]; 
//$CusSCode = explode("@@", $CusSource)[1];
$conSDate = trim(strip_tags($_POST['conSDate']));
$conEDate = trim(strip_tags($_POST['conEDate']));
$Currency = mysql_real_escape_string(trim(strip_tags($_POST['currency'])));
$Attn = mysql_real_escape_string(trim(strip_tags($_POST['attn'])));
$RFQNo = mysql_real_escape_string(trim(strip_tags($_POST['RFQNo'])));
//$RFQFile = mysql_real_escape_string(trim(strip_tags($_POST['RFQFile'])));
$Comment = mysql_real_escape_string(trim(strip_tags($_POST['Comment'])));
$conBusn = trim(strip_tags($_POST['conBusn']));



///////////////////////////////////////
if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
{ 
 
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['RFQFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: viewrfq?cnid='.$RFQIDn);
  exit;
  }
//Let's set new Name for file
 $ftmpName  = $_FILES['RFQFile']['tmp_name']; 
        $fimgName = $_FILES['RFQFile']['name'];
        

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../RFQAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../RFQAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['RFQFile']) && $_FILES['RFQFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }
////////////////////////////////////////




{
if($FILEURL != "")
{
$query = "UPDATE rfq SET  Attention='$Attn', DateStart='$conSDate', DateEnd='$conEDate', Comment='$Comment', RFQBusUnit='$conBusn', Attachment='$FILEURL', Currency='$Currency' WHERE RFQid='$RFQIDn'";
}
else
{
  $query = "UPDATE rfq SET  Attention='$Attn', DateStart='$conSDate', DateEnd='$conEDate', Comment='$Comment', RFQBusUnit='$conBusn', Currency='$Currency' WHERE RFQid='$RFQIDn'";

}

 if (mysql_query($query))
{
		

    //if(mysql_query($query1, $dbhandle))
{

    $_SESSION['ErrMsgB'] = "Updated RFQ :".$RFQNo;
  header('Location: viewrfq?cnid='.$RFQIDn);
mysql_close($dbhandle);
exit;
    
 }
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: viewrfq?cnid='.$RFQIDn); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>