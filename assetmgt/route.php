<?php
if ((strpos($_SESSION['AccessModule'], "Asset Management") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>