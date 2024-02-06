<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with
  


//Take Value from the two guys in index page LOGIN FORM
$LIRFQ = trim(strip_tags($_POST['LIRFQ']));
$LIRFQ = str_replace("'", "&#8217", $LIRFQ);
$LIRFQ = str_replace('"', '&#8221', $LIRFQ);
$LIMS = trim(strip_tags($_POST['LIMS']));
$LIQty = trim(strip_tags($_POST['LIQty']));
//$DOB = trim(strip_tags($_POST['DOB']));
$LIDes = mysql_real_escape_string(trim(strip_tags($_POST['LIDes'])));
$LIDes = str_replace("'", "&#8217", $LIDes);
$LIDes = str_replace('"', '&#8221', $LIDes);
$LIUOM = trim(strip_tags($_POST['LIUOM']));
$LIUOM = str_replace("'", "&#8217", $LIUOM);
$LIUOM = str_replace('"', '&#8221', $LIUOM);
$LICurr = trim(strip_tags($_POST['LICurr']));
$LIPrice = trim(strip_tags($_POST['LIPrice']));



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
$query = "INSERT INTO lineitems (RFQCode, MatSer, Description, Qty, UOM, Price, Currency) 
VALUES ('$LIRFQ','$LIMS','$LIDes','$LIQty','$LIUOM','$LIPrice','$LICurr');";

mysql_query($query);
  
$_SESSION['ErrMsgB'] = "Ok! New Line Item Added to RFQ No.: ".$LIRFQ;
header('Location: addLi?sRFQ='.$LIRFQ);


}
//close the connection
mysql_close($dbhandle);




?>