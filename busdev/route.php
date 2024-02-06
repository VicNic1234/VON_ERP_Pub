<?php
if ((strpos($_SESSION['AccessModule'], "Bus Dev") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>