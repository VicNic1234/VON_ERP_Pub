<?php

if((strpos($_SESSION['AccessModule'], "CEO") > -1) || $_SESSION['CEO'] == 1 ) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>