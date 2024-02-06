<?php
session_start();
include ('../DBcon/db_config.php');
//select a database to work with

  



//Take Value from the two guys in index page LOGIN FORM
$LIID = mysql_real_escape_string(trim(strip_tags($_POST['LIID'])));
$LIRFQ = mysql_real_escape_string(trim(strip_tags($_POST['LIRFQ'])));
$LIRFQ = str_replace("'", "&#8217", $LIRFQ);
$LIRFQ = str_replace('"', '&#8221', $LIRFQ);
$LIMS = mysql_real_escape_string(trim(strip_tags($_POST['LIMS'])));
$LIQty = mysql_real_escape_string(trim(strip_tags($_POST['LIQty'])));
//$DOB = trim(strip_tags($_POST['DOB']));
$LIDes = mysql_real_escape_string(trim(strip_tags($_POST['LIDes'])));
$LIDes = str_replace("'", "&#8217", $LIDes);
$LIDes = str_replace('"', '&#8221', $LIDes);
$LIUOM = mysql_real_escape_string(trim(strip_tags($_POST['LIUOM'])));
$LIUOM = str_replace("'", "&#8217", $LIUOM);
$LIUOM = str_replace('"', '&#8221', $LIUOM);

if ( $LIDes == "" )
{
$_SESSION['ErrMsg'] = "Did not update because NO description field was emtpy!";
header('Location: LineItems?sRFQ='.$LIRFQ);
exit;
}



{
//$_SESSION['ErrMsg'] = "Wrong Username or Password";
//header('Location: index.php');
$query = "UPDATE lineitems SET MatSer='".$LIMS."', Description='".$LIDes."', Qty='".$LIQty."', UOM='".$LIUOM."' WHERE LitID='".$LIID."'"; 


$result = mysql_query($query, $dbhandle);

if (!$result)
{
//echo mysql_error();
$_SESSION['ErrMsg'] = "Connection to Data Pool Error!!";
header('Location: LineItems?sRFQ='.$LIRFQ);
}
else
{
$_SESSION['ErrMsgB'] = "Congratulations! Line Item : ".$LIID . " Updated!";
header('Location: LineItems?sRFQ='.$LIRFQ);
}

}
//close the connection
mysql_close($dbhandle);




?>