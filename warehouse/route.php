<?php
if ((strpos($_SESSION['AccessModule'], "Warehouse") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>