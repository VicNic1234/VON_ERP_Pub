<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include ('../DBcon/db_configOOP.php');
//select a database to work with
//Take Value from the two guys in index page LOGIN FORM
$newpassword = mysqli_real_escape_string($dbhandle,trim(strip_tags($_POST['newpassword'])));
$oldpassword = mysqli_real_escape_string($dbhandle, trim(strip_tags($_POST['oldpassword'])));

$uid = $_SESSION['uid'];

if($uid == "") { $_SESSION['ErrMsg'] = "Oops! Login to try again"; header("Location: " . $_SERVER["HTTP_REFERER"]); exit; }
if($newpassword == "" || $oldpassword == "") { $_SESSION['ErrMsg'] = "Oops! Old and new password is required"; header("Location: " . $_SERVER["HTTP_REFERER"]); exit; }
if($newpassword == $oldpassword) { $_SESSION['ErrMsg'] = "Oops! You must enter a new password different from the old password."; header("Location: " . $_SERVER["HTTP_REFERER"]); exit; }

$UserPwsDCHK = mysqli_query($dbhandle, "SELECT * FROM users WHERE uid='".$uid."'");

while($row = $UserPwsDCHK->fetch_assoc()) {
        $UPSWD = $row['Password']; 
        $Surname = $row['Surname'];  
        $Firstname = $row['Firstname'];  
        $Email = $row['Email']; 
        $fullname =  $Surname . " " . $Firstname; 
    }

if($UPSWD != $oldpassword) { $_SESSION['ErrMsg'] = "Oops! The old password you entered is not correct"; header("Location: " . $_SERVER["HTTP_REFERER"]); exit; }


$query = "UPDATE users SET password='$newpassword' WHERE uid='$uid' ";

 
if (mysqli_query($dbhandle, $query))
{
    $_SESSION['ErrMsgB'] = "Your password is updated!";
 header("Location: " . $_SERVER["HTTP_REFERER"]);
}
else
{
    
//echo mysql_error();
$_SESSION['ErrMsg'] = "Oops! Got issues with data bank, contact administrator, thanks.";
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
  



}
//close the connection
mysql_close($dbhandle);




?>