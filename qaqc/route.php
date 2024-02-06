<?php
if ((strpos($_SESSION['AccessModule'], "QA/QC") !== false))
{}
else 
{ $_SESSION['ErrMsg'] = "ACCESS DENIED"; 
header('Location: ../users/logout'); exit; }

?>