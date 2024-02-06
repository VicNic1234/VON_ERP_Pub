<?php

if((strpos($_SESSION['AccessModule'], "Internal Audit") > -1)) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>