<?php
if ((strpos($_SESSION['AccessModule'], "HR/Administration") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }
?>