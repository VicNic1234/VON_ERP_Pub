<?php

if((strpos($_SESSION['AccessModule'], "Account") !== false)) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>