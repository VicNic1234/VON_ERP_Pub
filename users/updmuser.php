<?php
session_start();
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

include ('imagerzer.php');

//select a database to work with
if (isset($_FILES['StaffPhoto']) && $_FILES['StaffPhoto']['size'] > 0) 
{ 
  $tmpName  = $_FILES['StaffPhoto']['tmp_name']; 
  $imgName = $_FILES['StaffPhoto']['name'];

  // Load the original image
$image = new SimpleImage($tmpName);
// Create a squared version of the image
$image->square(400);
$image->save('userpix/'.$imgName);
$data=addslashes(file_get_contents('userpix/'.$imgName));

  //$fp = fopen($tmpName, 'r');
  //$data = fread($fp, filesize($tmpName));
  //$data = addslashes($data);
  //fclose($fp);
}

///For Signature
if (isset($_FILES['SignPhoto']) && $_FILES['SignPhoto']['size'] > 0) 
{ 
  $tmpName  = $_FILES['SignPhoto']['tmp_name']; 
  $imgNamesn = $_FILES['SignPhoto']['name'];

  // Load the original image
$imagesn = new SimpleImage($tmpName);
// Create a squared version of the image
$imagesn->scale(400);
$imagesn->save('userpix/'.$imgNamesn);
$sndata=addslashes(file_get_contents('userpix/'.$imgNamesn));

}
//Take Value from the two guys in index page LOGIN FORM
$firstnme = mysql_real_escape_string(trim(strip_tags($_POST['firstnme'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
$fullname = $surnme . " " . $firstnme;
$surnme = mysql_real_escape_string(trim(strip_tags($_POST['surnme'])));
$Gender = mysql_real_escape_string(trim(strip_tags($_POST['Gender'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$staffid = mysql_real_escape_string(trim(strip_tags($_POST['staffid'])));
//$LIDes = str_replace("'", "&#8217", $LIDes);
//$LIDes = str_replace('"', '&#8221', $LIDes);
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$LIemai = mysql_real_escape_string(trim(strip_tags($_POST['LIemai'])));
$staffPass = mysql_real_escape_string(trim(strip_tags($_POST['staffPass'])));


if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: register');
exit;
}

//We need to Get the Role set 
$SetRoles = $_POST['role_cap'];
if(empty($SetRoles)) { $ItemRole = ""; } 
  else
  {
    $N = count($SetRoles);
    $ItemRole ="";
    for($i=0; $i < $N; $i++)
    {
      $ItemRole .= $SetRoles[$i] .",";
    }
  }

{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
  
  if(!$sndata)
  {
    $SetSign = "";
  }
  else
  {
    $SetSign = ", Signature='".$sndata."'";
  }

if(!$data)
	{
		$query = "UPDATE users SET AccessModule='".$ItemRole."', Password='".$staffPass."', Firstname='".$firstnme."', Surname='".$surnme."', Gender='".$Gender."', Email='".$LIemai."', Phone='".$staffphn."', StaffID='".$staffid."' ".$SetSign." WHERE uid='".$uID."'"; 
	}
else 
	{
		$query = "UPDATE users SET AccessModule='".$ItemRole."', Password='".$staffPass."', Firstname='".$firstnme."', Surname='".$surnme."', Gender='".$Gender."', Email='".$LIemai."', Phone='".$staffphn."', StaffID='".$staffid."', Picture='".$data."' ".$SetSign." WHERE uid='".$uID."'"; 
	}


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: admin');
}
else
{
$CompAbbr = $_SESSION['CompanyName'];
  //we need to push the email over now
        $mail->Subject = $CompAbbr." (Password Change)";
        $mail->AddAddress($LIemai,$fullname);
       // $mail->AddAddress("victor_oko2006@yahoo.com",$fullname);
        
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:25px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:40px; height:49px; margin-top: 0px;" src="https://www.elshcon.space/mBOOT/splant.png" /> '.$CompAbbr.' [Login Details] </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br /> USERNAME: '.$LIemai.' <br/> PASSWORD: '.$staffPass.' <br/> Kindly click on the below to login to your ERP account. <br /><br /> <center><a href="https://www.elshcon.space"><button type="button" style="padding:12px; background:#CC3300; color:#FFF; border-radius:8px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  https://www.elshcon.space <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $mail->Body = $msg;      //HTML Body
        
       $mail->Send();
        //exit;
$_SESSION['ErrMsgB'] = "Congratulations! ".$surnme . "'s details Updated!";
header('Location: admin');
}

}
//close the connection
mysql_close($dbhandle);




?>