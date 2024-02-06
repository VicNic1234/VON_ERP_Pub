<?php

if((strpos($_SESSION['AccessModule'], "Document Control") > -1)) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>