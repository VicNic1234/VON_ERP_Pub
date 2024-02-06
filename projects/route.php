<?php
if ((strpos($_SESSION['AccessModule'], "Projects") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>