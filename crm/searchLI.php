<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

if($_POST)
{
$q=$_POST['search'];
$sql_res=mysql_query("select * from crmlitfeedback WHERE LineItemID = '$q' AND isActive=1");
$NoRow = mysql_num_rows($sql_res);
	if ($NoRow > 0) 
	{
		while($row=mysql_fetch_array($sql_res))
		{
		   	$Msg = $row['Msg'];
		   	$crmLITfbID = $row['crmLITfbID'];
		   	$Attachment = $row['Attachment'];
		   	$FromCRM = $row['FromCRM'];

		   	if($Attachment == "") { $Attachment = "-"; }
		   	else { $Attachment = '<a style="color:#000" href="../LogisticsAttach/'.$Attachment.'" target="_blank"><i title="Click to download attachment" class="fa fa-link"></i></a>'; }
			//We would need to build the Table now
			if($FromCRM == "P")
			{
			 $TableBuilder .= '<tr style="background:#42A679; color:#FFF;"><td>MSG-'.$crmLITfbID.'-'.$q.'</td><td>'.$Msg.'</td><td>'.$Attachment.'</td></tr>';
			}
			else
			{ $TableBuilder .= '<tr><td>MSG-'.$crmLITfbID.'-'.$q.'</td><td>'.$Msg.'</td><td>'.$Attachment.'</td></tr>';	}

		}
	}
	else
	{
		echo "--";
	}

	echo $TableBuilder;

}
?>
