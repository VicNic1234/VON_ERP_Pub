<?php

if((strpos($_SESSION['AccessModule'], "Contracts/Procurement") > -1)) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>