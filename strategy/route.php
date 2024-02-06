<?php

if((strpos($_SESSION['AccessModule'], "Strategy/Innovation") > -1) ) {}
else { 	$_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>