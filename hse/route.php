<?php
if ((strpos($_SESSION['AccessModule'], "HSE") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>