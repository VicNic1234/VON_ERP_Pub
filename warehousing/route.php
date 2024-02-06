<?php
if ($_SESSION['Dept'] == "superadmin" || (strpos($_SESSION['AccessModule'], "warehousing") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>