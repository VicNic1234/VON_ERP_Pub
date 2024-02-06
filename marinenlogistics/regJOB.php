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
$Scope = trim(strip_tags($_POST['Scope']));
$Source = trim(strip_tags($_POST['Source']));
$JOBType = trim(strip_tags($_POST['JOBType']));
$Currency = mysql_real_escape_string(trim(strip_tags($_POST['currency'])));
$Attn = mysql_real_escape_string(trim(strip_tags($_POST['attn'])));
$JOBNo = mysql_real_escape_string(trim(strip_tags($_POST['JOBNo'])));
//$RFQFile = mysql_real_escape_string(trim(strip_tags($_POST['RFQFile'])));
$Comment = mysql_real_escape_string(trim(strip_tags($_POST['Comment'])));
$conBusn = trim(strip_tags($_POST['conBusn']));
/*$personelresp = $_POST['personelresp']; 

if(count($personelresp) < 1) 
  {
    $_SESSION['ErrMsg'] = "You didn't select any personnel responsible.";
   header('Location: newjob');
  exit;
  } 
  else
  {
    $N = count($personelresp);
    $ItemResponsibles ="";
  
    for($i=0; $i < $N; $i++)
    {
   
    $ItemResponsibles .= $personelresp[$i].",";
    
    }

  }

  */

///////////////////////////////////////
if (isset($_FILES['JOBFile']) && $_FILES['JOBFile']['size'] > 0) 
{ 
 
}
////////////////////////////////////////////////////////
$sizemdia = $_FILES['JOBFile']['size'];
    if ($sizemdia > 35000000) //if above 35MB
  {
  //echo "<strong style='color:red;'>YOU MEDIA FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  $_SESSION['ErrMsg'] = "<strong style='color:red;'>YOUR ATTACHED FILE MUST NOT EXCEED 35MB PLEASE!</strong>";
  header('Location: newjob');
  exit;
  }
//Let's set new Name for file
 $ftmpName  = $_FILES['JOBFile']['tmp_name']; 
        $fimgName = $_FILES['JOBFile']['name'];
        

        send1:    
        $FILEID = date('Ymd_his');
       $ext = pathinfo($fimgName, PATHINFO_EXTENSION); 
       // $temp = explode(".", $_FILES["file"]["name"]);
        //$newfilename = round(microtime(true)) . '.' . end($temp);
         if (file_exists("../JOBAttach/" . $FILEID .".". $ext )) { goto send1; } else
            {
              $FILEURL = "../JOBAttach/" . $FILEID .".". $ext;
            }
        
         

/////////////////////////////////////////////////////////////
//Here we need to send details to Contract Table
        if (isset($_FILES['JOBFile']) && $_FILES['JOBFile']['size'] > 0) 
        { 
          move_uploaded_file($ftmpName, $FILEURL);
          
        }
        else
        {
          $FILEURL = "";
        }
////////////////////////////////////////




{

$query = "INSERT INTO mljobs (JOBNum, Customer, cusid, Scope, JOBType, Attention, Source, DateStart, DateEnd, Comment, RFQBusUnit, Attachment, Status, Currency, PEAID, CreatedOn) 
VALUES ('$JOBNo','$CusSCode','$CusID', '$Scope', '$JOBType', '$Attn', '$Source', '$conSDate','$conEDate','$Comment','$conBusn','$FILEURL', 'OPEN', '$Currency', '$UID', '$TDay');";


 if (mysql_query($query))
{
		

    //if(mysql_query($query1, $dbhandle))
{
   //Read CONCount
              $CONcount = mysql_query("SELECT * FROM sysvar WHERE variableName = 'JOBCount'");
              while ($row = mysql_fetch_array($CONcount)) { $CONcount = $row{'variableValue'}; }

              $CONcount = intval($CONcount) + 1;
   $query2 = "UPDATE sysvar SET variableValue='".$CONcount."' WHERE variableName = 'JOBCount'";
   mysql_query($query2, $dbhandle);


    $_SESSION['ErrMsgB'] = "Created ".$ContractNo;
  header('Location: newjob');
mysql_close($dbhandle);
exit;
    
 }
}
else
{
		$_SESSION['ErrMsg'] = "Error! Contact admin";
		header('Location: newjob'); exit;
}

}
//close the connection
mysql_close($dbhandle);




?>