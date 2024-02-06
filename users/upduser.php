<?php
session_start();
include ('../DBcon/db_config.php');
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
//Take Value from the two guys in index page LOGIN FORM
$firstnme = mysql_real_escape_string(trim(strip_tags($_POST['firstnme'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));
//$LIRFQ = str_replace("'", "&#8217", $LIRFQ);
//$LIRFQ = str_replace('"', '&#8221', $LIRFQ);
$surnme = mysql_real_escape_string(trim(strip_tags($_POST['surnme'])));
$Gender = mysql_real_escape_string(trim(strip_tags($_POST['Gender'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$staffid = mysql_real_escape_string(trim(strip_tags($_POST['staffid'])));
//$LIDes = str_replace("'", "&#8217", $LIDes);
//$LIDes = str_replace('"', '&#8221', $LIDes);
$staffphn = mysql_real_escape_string(trim(strip_tags($_POST['staffphn'])));
$LIemai = mysql_real_escape_string(trim(strip_tags($_POST['LIemai'])));


if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
header('Location: register');
exit;
}


{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
if(!$data)
	{
		$query = "UPDATE users SET Firstname='".$firstnme."', Surname='".$surnme."', Gender='".$Gender."', Email='".$LIemai."', Phone='".$staffphn."', StaffID='".$staffid."' WHERE uid='".$uID."'"; 
	}
else 
	{
		$query = "UPDATE users SET Firstname='".$firstnme."', Surname='".$surnme."', Gender='".$Gender."', Email='".$LIemai."', Phone='".$staffphn."', StaffID='".$staffid."', Picture='".$data."' WHERE uid='".$uID."'"; 
	}


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: register');
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! ".$surnme . "'s details Updated!";
header('Location: register');
}

}
//close the connection
mysql_close($dbhandle);




?>