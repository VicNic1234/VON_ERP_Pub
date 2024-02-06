<?php
session_start();
include ('../DBcon/db_config.php');
$Uid = $_SESSION['uid'];
if (trim(strip_tags($_POST['ssv'])) != "")
{
    

//echo $_POST['ssv'];
$cusnme = mysql_real_escape_string(trim(strip_tags($_POST['cusnme'])));
$cusrefn = mysql_real_escape_string(trim(strip_tags($_POST['cusrefn'])));
$cusphn = mysql_real_escape_string(trim(strip_tags($_POST['cusphn1'])));
$cusweb = mysql_real_escape_string(trim(strip_tags($_POST['cusweb'])));
$cusmail = mysql_real_escape_string(trim(strip_tags($_POST['cusmail'])));
$cusadd = mysql_real_escape_string(trim(strip_tags($_POST['cusadd'])));
$cusadd2 = mysql_real_escape_string(trim(strip_tags($_POST['cusadd2'])));
$cussnme = mysql_real_escape_string(trim(strip_tags($_POST['cussnme'])));

//$DOB = trim(strip_tags($_POST['DOB']));
$contphn1 = mysql_real_escape_string(trim(strip_tags($_POST['contphn1'])));
$contphn2 = mysql_real_escape_string(trim(strip_tags($_POST['contphn2'])));
$contemail1 = mysql_real_escape_string(trim(strip_tags($_POST['contemail1'])));
$contemail2 = mysql_real_escape_string(trim(strip_tags($_POST['contemail2'])));
$contnme1 = mysql_real_escape_string(trim(strip_tags($_POST['contnme1'])));
$contnme2 = mysql_real_escape_string(trim(strip_tags($_POST['contnme2'])));
$busunit = mysql_real_escape_string(trim(strip_tags($_POST['busunit'])));
$category = mysql_real_escape_string(trim(strip_tags($_POST['category'])));
//Let's just Update
if (isset($_FILES['CusLOGO']) && $_FILES['CusLOGO']['size'] > 0) 
    { 
      $tmpName  = $_FILES['CusLOGO']['tmp_name']; 
      $fp = fopen($tmpName, 'r');
      $data = fread($fp, filesize($tmpName));
      $data = addslashes($data);
      fclose($fp);
      $query = "UPDATE customers SET CustormerNme='".$cusnme."', cussnme='".$cussnme."', email='".$cusmail."', webaddress='".$cusweb."', CusRefNo='".$cusrefn."', CusAddress='".$cusadd."', CusAddress2='".$cusadd2."',  CusPhone='".$cusphn."', CusPhone1='".$contphn1."', CusPhone2='".$contphn2."', 
       CusEmail1='".$contemail1."', CusEmail2='".$contemail2."', CusNme1='".$contnme1."', CusNme2='".$contnme2."', 
      CusLogo='".$data."', BusinessUnit='".$busunit."', Category='".$category."', updatedby='".$Uid ."' WHERE cusid='".trim(strip_tags($_POST['ssv']))."'"; 
    }
else
{
  $query = "UPDATE customers SET CustormerNme='".$cusnme."', cussnme='".$cussnme."', email='".$cusmail."', webaddress='".$cusweb."', CusRefNo='".$cusrefn."', CusAddress='".$cusadd."', CusAddress2='".$cusadd2."',  CusPhone='".$cusphn."', CusPhone1='".$contphn1."', CusPhone2='".$contphn2."',
  CusEmail1='".$contemail1."', CusEmail2='".$contemail2."', CusNme1='".$contnme1."', CusNme2='".$contnme2."', 
    BusinessUnit='".$busunit."', Category='".$category."', updatedby='".$Uid ."' WHERE cusid='".trim(strip_tags($_POST['ssv']))."'"; 
}

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

//Set for DB insert
$cusnme = mysql_real_escape_string(trim(strip_tags($_POST['cusnme'])));
$cusrefn = mysql_real_escape_string(trim(strip_tags($_POST['cusrefn'])));
$cusphn1 = mysql_real_escape_string(trim(strip_tags($_POST['cusphn1'])));
$cusweb = mysql_real_escape_string(trim(strip_tags($_POST['cusweb'])));
$cusmail = mysql_real_escape_string(trim(strip_tags($_POST['cusmail'])));
$cusadd = mysql_real_escape_string(trim(strip_tags($_POST['cusadd'])));
$cusadd2 = mysql_real_escape_string(trim(strip_tags($_POST['cusadd2'])));
$cussnme = mysql_real_escape_string(trim(strip_tags($_POST['cussnme'])));

//$DOB = trim(strip_tags($_POST['DOB']));
$contphn1 = mysql_real_escape_string(trim(strip_tags($_POST['contphn1'])));
$contphn2 = mysql_real_escape_string(trim(strip_tags($_POST['contphn2'])));
$contemail1 = mysql_real_escape_string(trim(strip_tags($_POST['contemail1'])));
$contemail2 = mysql_real_escape_string(trim(strip_tags($_POST['contemail2'])));
$contnme1 = mysql_real_escape_string(trim(strip_tags($_POST['contnme1'])));
$contnme2 = mysql_real_escape_string(trim(strip_tags($_POST['contnme2'])));
$busunit = mysql_real_escape_string(trim(strip_tags($_POST['busunit'])));
$category = mysql_real_escape_string(trim(strip_tags($_POST['category'])));


//execute the SQL query and return records
$result = mysql_query("SELECT * FROM customers WHERE CustormerNme='".$cusnme."' OR cussnme='".$cussnme."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "Customer with ".$cusnme." OR Code name as ".$cussnme." already exist";
header('Location: Cus');
exit;
}

else
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "INSERT INTO customers (CustormerNme, cussnme, CusRefNo, CusAddress, CusAddress2, CusLogo, CusPhone, CusPhone1, CusPhone2, CusEmail1, CusEmail2, CusNme1, CusNme2, BusinessUnit, Category, webaddress, email, createdby) 
VALUES ('$cusnme', '$cussnme','$cusrefn','$cusadd','$cusadd2','$data','$cusphn1','$contphn1','$contphn2','$contemail1','$contemail2','$contnme1','$contnme2','$busunit','$category','$cusweb','$cusmail','$Uid' );";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Congratulations! New Customer is Registered";
header('Location: Cus');


}
//close the connection
mysql_close($dbhandle);




?>