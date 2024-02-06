<?php
session_start();
include ('../DBcon/db_config.php');
include ('imagerzer.php');


$Bank = mysql_real_escape_string(trim(strip_tags($_POST['Bank'])));
$BankAccountType = mysql_real_escape_string(trim(strip_tags($_POST['BankAccountType'])));
$AccountNumber = mysql_real_escape_string(trim(strip_tags($_POST['AccountNumber'])));

$salary = mysql_real_escape_string(trim(strip_tags($_POST['salary'])));
$uID = mysql_real_escape_string(trim(strip_tags($_POST['uID'])));

  //We need to Get the Payroll Element set 
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


//echo $ItemRole; exit;
if ( $uID == "" )
{
$_SESSION['ErrMsg'] = "Did not update!";
 if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
exit;
}

else
{

		$query = "UPDATE users SET BankID='".$Bank."', AccountType='".$BankAccountType."', AccountNumber='".$AccountNumber."', GrossSalary='".$salary."', PayrollElem='".$ItemRole."' WHERE uid='".$uID."'"; 




if (mysql_query($query, $dbhandle))
{
$_SESSION['ErrMsgB'] = "Congratulations! salary details Updated!";

if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}
else
{
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
}

}
//close the connection
mysql_close($dbhandle);




?>