<?php
if ((strpos($_SESSION['AccessModule'], "Deck Mach") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>