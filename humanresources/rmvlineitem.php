<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
  


//Take Value from the two guys in index page LOGIN FORM
$LIRFQ = trim(strip_tags($_POST['LIRFQ']));
$LIRFQ = str_replace("'", "&#8217", $LIRFQ);
$LIRFQ = str_replace('"', '&#8221', $LIRFQ);

//$DOB = trim(strip_tags($_POST['DOB']));
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));




/*execute the SQL query and return records
$result = mysql_query("SELECT * FROM rfq WHERE RFQNum='".$RFQNo."'");
//check if user exist
 $NoRow = mysql_num_rows($result);


if ($NoRow > 0) 
{
	
$_SESSION['ErrMsg'] = "RFQ Number already exist";
header('Location: InternalSales');
exit;
}

else */
{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "DELETE FROM lineitems WHERE LitID ='$LIID';";
mysql_query($query);
/////////////////////////////////
$liID = mysql_insert_id();
$query1 = "DELETE FROM polineitems WHERE LitID ='$LIID';";



mysql_query($query1);
  
  
$_SESSION['ErrMsgB'] = "Ok! Line Item Deleted to RFQ No.: ".$LIRFQ;
header('Location: addLi?sRFQ='.$LIRFQ);


}
//close the connection
mysql_close($dbhandle);




?>