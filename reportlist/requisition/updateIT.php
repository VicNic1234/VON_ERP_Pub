<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:s a");

$LitID= mysql_real_escape_string($_POST['LitID']);
$EditDes= mysql_real_escape_string($_POST['EditDes']);
$EditJust= mysql_real_escape_string($_POST['EditJust']);
$EditQty= mysql_real_escape_string($_POST['EditQty']);
$EditAmt= mysql_real_escape_string($_POST['EditAmt']);
$EditSize = mysql_real_escape_string($_POST['size']);
$EditUOM= mysql_real_escape_string($_POST['uom']);
$EditType= mysql_real_escape_string($_POST['type']);

if (isset($_FILES['filed']) && $_FILES['filed']['size'] > 0) 
{ 
  $sizemdia = $_FILES['filed']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
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

if($DocLink == "")
{
     $sql_res=mysql_query("UPDATE poreq SET ItemDes='$EditDes', Purpose='$EditJust', Amount='$EditAmt', Qty='$EditQty', Size='$EditSize', UOM='$EditUOM', Type='$EditType' WHERE reqid = '$LitID'");
}
else
{
    $sql_res=mysql_query("UPDATE poreq SET ItemDes='$EditDes', Purpose='$EditJust', Amount='$EditAmt', Qty='$EditQty', Size='$EditSize', UOM='$EditUOM', Type='$EditType', attachment='$DocLink' WHERE reqid = '$LitID'");
}

$result = mysql_query($sql_res, $dbhandle);


 if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
//close the connection
mysql_close($dbhandle);


?>
