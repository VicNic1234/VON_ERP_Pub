<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");
$Files = "";
$q=$_POST['rid'];
$sql_res=mysql_query("SELECT * FROM cashreq WHERE reqid = '$q'");
while ($row = mysql_fetch_array($sql_res)) {
       $ItemDes = $row['ItemDes'];
       //$Purpose = $row['Purpose'];
       $RequestID = $row['RequestID'];
       $Amount = $row['Amount'];
       $Qty = $row['Qty'];
       $relatedPDF = $row['relatedPDF'];
    $attach = $row['attachment'];
       if($attach != "")
			{
			       $Files .= '<span id="fidold-'.$q.'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['attachment'].'" target="_blank"><i class="fa fa-link"></i> attachment </a><i fid="'.$q.'" ty="old" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
			}
     }





$sql_file=mysql_query("SELECT * FROM filereq WHERE reqcode = '$RequestID' AND isActive=1");
while ($row = mysql_fetch_array($sql_file)) {
       $Files .= '<span  id="fid-'.$row['fid'].'" style="padding:12px; border-radius:25px; background:#00CCFF; color:#000"><a style="color:#000" href="'.$row['fpath'].'" target="_blank"><i class="fa fa-link"></i> '.$row['tile'].' </a><i fid="'.$row['fid'].'" ty="new" onclick="rmFile(this);" class="fa fa-trash text-red" title="Click to remove file"></i></span>';
     }
  




//close the connection
mysql_close($dbhandle);

$ITDetails = array();
$ITDetails['ItemDes'] = $ItemDes;
$ITDetails['Amount'] = $Amount;
$ITDetails['Qty'] = $Qty;
$ITDetails['Files'] = $Files;
$ITDetails['relatedPDF'] = $relatedPDF;


echo json_encode($ITDetails);

?>
