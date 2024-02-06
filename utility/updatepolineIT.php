<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$resultCusOrdNumLinetem = mysql_query("SELECT * FROM so WHERE poID ='114'");
    $NoRowCusONo = mysql_num_rows($resultCusOrdNumLinetem);
    if($NoRowCusONo > 0)
    {   //$SN = 0; $SubT = 0.0;
        while ($row = mysql_fetch_array($resultCusOrdNumLinetem))
        { 
         
         $ItemsDetails = $row['ItemsDetails'];
        
        }
    }

    $ItemDetail = explode("<br>",$ItemsDetails);
    $N = count($ItemDetail);

    for($i=0; $i < $N; $i++)
    {
    
     $RawITD = explode("@&@",$ItemDetail[$i]);
     //$ItemDm .= $RawITD[2]."<br/>";
     echo $POLitID = $RawITD[1]."<br/>";
    }
?>
