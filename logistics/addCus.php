<?php
session_start();
include ('../DBcon/db_config.php');

if (trim(strip_tags($_POST['ssv'])) != "")
{
if (isset($_FILES['CusLOGO']) && $_FILES['CusLOGO']['size'] > 0) 
{ 
  $tmpName  = $_FILES['CusLOGO']['tmp_name']; 
  $fp = fopen($tmpName, 'r');
  $data = fread($fp, filesize($tmpName));
  $data = addslashes($data);
  fclose($fp);
}

$cusnme = trim(strip_tags($_POST['cusnme']));
$cusrefn = trim(strip_tags($_POST['cusrefn']));
$cusphn1 = trim(strip_tags($_POST['cusphn1']));
//$DOB = trim(strip_tags($_POST['DOB']));
$cusphn2 = mysql_real_escape_string(trim(strip_tags($_POST['cusphn2'])));
$cusphn3 = trim(strip_tags($_POST['cusphn3']));
$cusphn4 = trim(strip_tags($_POST['cusphn4']));
$cusweb = trim(strip_tags($_POST['cusweb']));
$cusmail = trim(strip_tags($_POST['cusmail']));
$cusadd = trim(strip_tags($_POST['cusadd']));

$cussnme = trim(strip_tags($_POST['cussnme']));
//Let's just Update
$query = "UPDATE customers SET CustormerNme='".$cusnme."', cussnme='".$cussnme."', email='".$cusmail."', webaddress='".$cusweb."', CusRefNo='".$cusrefn."', CusAddress='".$cusadd."', CusPhone1='".$cusphn1."' WHERE cusid='".trim(strip_tags($_POST['ssv']))."'"; 

$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: Cus');
exit;
}
{
$_SESSION['ErrMsgB'] = "Updated!";
header('Location: Cus');
exit;
}


}  
  
if (isset($_FILES['CusLOGO']) && $_FILES['CusLOGO']['size'] > 0) 
{ 
  $tmpName  = $_FILES['CusLOGO']['tmp_name']; 
  $fp = fopen($tmpName, 'r');
  $data = fread($fp, filesize($tmpName));
  $data = addslashes($data);
  fclose($fp);
}
else
{
$data = "";
}

//Take Value from the two guys in index page LOGIN FORM
$cusnme = trim(strip_tags($_POST['cusnme']));
$cusrefn = trim(strip_tags($_POST['cusrefn']));
$cusphn1 = trim(strip_tags($_POST['cusphn1']));
//$DOB = trim(strip_tags($_POST['DOB']));
$cusphn2 = mysql_real_escape_string(trim(strip_tags($_POST['cusphn2'])));
$cusphn3 = trim(strip_tags($_POST['cusphn3']));
$cusphn4 = trim(strip_tags($_POST['cusphn4']));
$cusweb = trim(strip_tags($_POST['cusweb']));
$cusmail = trim(strip_tags($_POST['cusmail']));
$cusadd = trim(strip_tags($_POST['cusadd']));
$cussnme = trim(strip_tags($_POST['cussnme']));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM customers WHERE CustormerNme='".$cusnme."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Customer with ".$cusnme." as name already exist";
header('Location: Cus');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO customers (CustormerNme, cussnme, CusRefNo, CusAddress, CusLogo, CusPhone1, CusPhone2, CusPhone3, CusPhone4, webaddress, email) 
VALUES ('$cusnme', '$cussnme','$cusrefn','$cusadd','$data','$cusphn1','$cusphn2','$cusphn3','$cusphn4','$cusweb','$cusmail');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Customer is Registered";
header('Location: Cus');


}
//close the connection
mysql_close($dbhandle);




?>