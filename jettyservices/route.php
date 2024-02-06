<?php
if ((strpos($_SESSION['AccessModule'], "Jetty Service") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>