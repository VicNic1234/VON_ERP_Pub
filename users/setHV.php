<?php
include ('../DBcon/db_config.php');

if($_POST)
{
  $UID=$_POST['UID'];
  $PS=$_POST['PS'];
  $Chk=$_POST['Chk']; 
    
    if($PS == "Supervisor") {
    $sql_res=mysql_query("UPDATE users SET Supervisor='$Chk' WHERE uid = '$UID'");
    }

  	if($PS == "Dept") {
	  $sql_res=mysql_query("UPDATE users SET HDept='$Chk' WHERE uid = '$UID'");
  	}

  	if($PS == "Div") {
	  $sql_res=mysql_query("UPDATE users SET HDiv='$Chk' WHERE uid = '$UID'");
  	}

  	if($PS == "Mgr") {
	  $sql_res=mysql_query("UPDATE users SET Mgr='$Chk' WHERE uid = '$UID'");
  	}

    if($PS == "CEO") {
    $sql_res=mysql_query("UPDATE users SET CEO='$Chk' WHERE uid = '$UID'");
    }
    
      if($PS == "COO") {
    $sql_res=mysql_query("UPDATE users SET COO='$Chk' WHERE uid = '$UID'");
    }

	
}


//close the connection
mysql_close($dbhandle);


?>
