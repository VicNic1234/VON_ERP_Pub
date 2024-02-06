<?php
if ((strpos($_SESSION['AccessModule'], "ICT") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>