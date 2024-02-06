<?php
if ((strpos($_SESSION['AccessModule'], "Marine/Logistics") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>