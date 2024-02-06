<?php
error_reporting(0);
session_start();
//include ('../DBcon/db_configOOP.php');
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$userID = $_SESSION['uid'];
$newpassword = mysql_real_escape_string(trim(strip_tags($_POST['newpassword'])));
$oldpassword = mysql_real_escape_string(trim(strip_tags($_POST['oldpassword'])));

$UserPwsDCHK = mysql_query("SELECT * FROM users WHERE uid='".$userID."'");

while($row = $UserPwsDCHK->fetch_assoc()) {
        $UPSWD = $row['Password'];  
        $Surname = $row['Surname'];  
        $Firstname = $row['Firstname'];  
        $Email = $row['Email']; 
        $fullname =  $Surname . " " . $Firstname; 
    }

  if($UPSWD == $oldpassword)
  {
    $ReDONE =  mysqli_query($dbhandle, "UPDATE users SET Password='".$newpassword."' WHERE uid='".$userID."'");

    if($ReDONE)
    {
      echo "Updated";
$CompAbbr = $_SESSION['CompanyName'];
  //we need to push the email over now
        $mail->Subject = $CompAbbr." (Password Change)";
        $mail->AddAddress($Email,$fullname);
        
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:25px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:40px; height:49px; margin-top: 0px;" src="https://www.elshcon.space/mBOOT/splant.png" /> '.$CompAbbr.' [Login Details] </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Dear '.$fullname.',<br /><br /> USERNAME: '.$Email.' <br/> PASSWORD: '.$newpassword.' <br/> Kindly click on the below to login to your ERP account. <br /><br /> <center><a href="https://www.elshcon.space"><button type="button" style="padding:12px; background:#CC3300; color:#FFF; border-radius:8px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  https://www.elshcon.space <br /><br /><br />Thanks<br />
        <br />Sincerely,<br /> </div>   
        </body></html>';
        $mail->Body = $msg;      //HTML Body
        
       $mail->Send();
        //exit;
}

  }
  else
  {
    echo "Wrong Password";
  }








?>