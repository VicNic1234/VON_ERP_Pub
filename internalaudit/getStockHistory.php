<?php
session_start();
include ('../DBcon/db_config.php');
$DateG = date("Y/m/d h:i:sa");


$stockID = mysql_real_escape_string(trim(strip_tags($_POST['stockID'])));


if($stockID == "")
 { 
   echo '<tr>No Record </tr>'; exit;
 } 
 else 
 {
 	
 	$setTable = "<tr><th>Date of Action</th><th>Purpose</th><th>Action</th><th>Action By</th><th>Stock State</th></tr>";
 	//ShortCode
 	$chkExist = mysql_query("SELECT *, wh_stations.station_name As StationName, wh_storages.name As StoragenName, wh_stations.cid As CID, itemcategory.CategoryName As itemcatNme, wh_bins.account_code AS BinCode, wh_bins.account_name As BinName FROM  stockhistory 
 		LEFT JOIN users ON stockhistory.actor = users.uid 
 		LEFT JOIN itemcategory
ON stockhistory.itemcat=itemcategory.id 

LEFT JOIN wh_storages
ON stockhistory.storage=wh_storages.id 

LEFT JOIN wh_stations 
ON wh_storages.class_id = wh_stations.cid

LEFT JOIN wh_bins 
ON stockhistory.Bin = wh_bins.mid

WHERE sid ='".$stockID."'");
	$NoRowchkExist = mysql_num_rows($chkExist);

	if($NoRowchkExist > 0)
	 { 
	   	 while ($row = mysql_fetch_array($chkExist)) {
			     $setTable .= '<tr>
			        <td>'.$row['actiondate'].'</td>
			        <td>'.$row['purpose'].'</td>
			        <td>'.$row['action'].'</td>
			        <td>'.$row['Firstname']. ' ' .$row['Surname'].'</td>
			        <td><b>Station : </b>'.$row['StationName']. ' <br/><b>Storage : </b>'  .$row['StoragenName'].' <br/><b>Bin : </b>'.$row['BinCode'] . " [" . $row['BinName'] . "]".' <br/><b>Balance : </b>'  .$row['Bal'].'<br/><b>Condition : </b>'  .$row['Condi'].'</td>
			        </tr>';
			   }
		echo $setTable;
		exit;
	 } 
	else
	{
       echo '<tr>No Record </tr>'; exit;
		
	}

 }


exit;


?>
