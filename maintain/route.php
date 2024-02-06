<?php
if ((strpos($_SESSION['AccessModule'], "Maintenance") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>