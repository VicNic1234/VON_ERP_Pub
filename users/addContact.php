<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');
include ('imagerzer.php');
//select a database to work with
$uid = trim(strip_tags($_POST['uid']));
$cName = trim(strip_tags($_POST['cName']));
$CRelationShip = trim(strip_tags($_POST['CRelationShip']));
$CAddress = trim(strip_tags($_POST['CAddress']));
$CPhone = trim(strip_tags($_POST['CPhone']));
$CLGA = trim(strip_tags($_POST['CLGA']));
$CreatedBy = $_SESSION['uid'];
  

$queryNewContact = "INSERT INTO empcontacts (user_id, ContactName, Relationship, Address, PhoneNo, LGA,  CreatedBy) 
VALUES ('$uid','$cName','$CRelationShip','$CAddress','$CPhone','$CLGA', '$CreatedBy');";

    //$regr = ;
     
     if(mysql_query($queryNewContact)) 
     {
        $_SESSION['ErrMsgB'] = "Contact have been added!";
        //header('Location: employee?dc='.$uid);
      }
 
      else
      {
        $_SESSION['ErrMsg'] = mysql_error();//"Opps! Data Pool error, tryagain";
        //header('Location: employee?dc='.$uid);

      }

      $indiv = trim(strip_tags($_POST['indiv']));

      if($indiv == "YES")
      {
        header('Location: mydetails');
      }
      else
      {
        header('Location: employee?dc='.$uid);
      }







?>