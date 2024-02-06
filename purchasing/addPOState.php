<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('../emailsettings/emailSettings.php');

$DateG = date("Y/m/d h:i:sa");
$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
    
//echo $_FILES['LogisticsFile'];
//exit;
$formtype = mysql_real_escape_string(trim($_POST['formtype']));

$PONum = mysql_real_escape_string(trim($_POST['PONumv']));
//echo $PONum;
//exit;

$Terms = mysql_real_escape_string(trim($_POST['termsv']));
$SpecialNote = mysql_real_escape_string(trim($_POST['specialnote']));
$Supplier = mysql_real_escape_string(trim($_POST['svsupinfo']));

$Currency = mysql_real_escape_string(trim($_POST['currrealv']));
$CurrencySymb = mysql_real_escape_string(trim($_POST['currsymbv']));

$SupplierRefNum = mysql_real_escape_string(trim($_POST['suprefnov']));
$OtherRefNum = mysql_real_escape_string(trim($_POST['orefnov']));
$DespatchThrough = mysql_real_escape_string(trim($_POST['desthroughv']));
$Destination = mysql_real_escape_string(trim($_POST['desv']));
$ConNme = mysql_real_escape_string(trim($_POST['cpNmev']));
$ConEmail = mysql_real_escape_string(trim($_POST['cpEmailv']));
$ConPhone = mysql_real_escape_string(trim($_POST['cpPhonev']));
$PODate = mysql_real_escape_string(trim($_POST['poDatev']));

$SubTotal = mysql_real_escape_string(trim($_POST['RealSubTotal']));
$Total = mysql_real_escape_string(trim($_POST['realAmt']));
$datastate = mysql_real_escape_string(trim($_POST['datastate']));

if ($datastate == 1)
{
  //here we have to CLear the DB of Old details
  $query1 = "DELETE FROM poinfo WHERE PONum ='".$PONum."'"; 
  $result1 = mysql_query($query1, $dbhandle);

  $query2 = "DELETE FROM poinfocomm WHERE PONum ='".$PONum."'"; 
  $result2 = mysql_query($query2, $dbhandle);

  $query3 = "DELETE FROM poinfolineitem WHERE PONum ='".$PONum."'"; 
  $result3 = mysql_query($query3, $dbhandle);




}

if($_POST)
{
//Insert PO Info.
  //we would need to confirm if PO already saved
  $resultOldUpdate = mysql_query("SELECT * FROM poinfo WHERE PONum ='".$PONum."'");
 $NoRowOldUpdate = mysql_num_rows($resultOldUpdate);
 if ($NoRowOldUpdate > 0)
 {
  //$_SESSION['ErrMsgB'] = "Did not save This PO number already exist";
  echo "Did not save, This PO number already exist";
    //header('Location: sndPO');
  exit;
 }
else
{

//We may need to rec this Reverse PO
$query = "INSERT INTO poinfo (PONum, Terms, SpecialNote, Supplier, Currency, CurrencySymb, SupplierRefNum, OtherRefNum, DespatchThrough, Destination, ConNme, ConEmail, ConPhone, PODate, SubTotal, Total) 
VALUES ('$PONum','$Terms','$SpecialNote','$Supplier','$Currency','$CurrencySymb','$SupplierRefNum','$OtherRefNum','$DespatchThrough','$Destination','$ConNme','$ConEmail','$ConPhone','$PODate','$SubTotal','$Total');";

mysql_query($query);
//////////////////////////////////////
$ItemNamesArray1 = $_POST['CommT'];

$N = count($ItemNamesArray1);
for($i=1; $i < $N + 1; $i++)
  {
    
 $Title =  $ItemNamesArray1[$i]['Title'];
 $Amount = $ItemNamesArray1[$i]['Amount'];

  $query12 = "INSERT INTO poinfocomm (PONum, sn, Title, Amount) 
     VALUES ('$PONum','$i','$Title','$Amount');";
     mysql_query($query12);
  }
//////////////////////////////////////
$ItemNamesArray = $_POST['POLineItem'];

$N = count($ItemNamesArray);
for($i=1; $i < $N+1; $i++)
  {
    
    $sn = $ItemNamesArray[$i]['SNv'];
    $Description = $ItemNamesArray[$i]['Descriptionv'];
    $DueOn = $ItemNamesArray[$i]['DDatev'];
    $Quantity = $ItemNamesArray[$i]['Quantityv'];
    $Rate = $ItemNamesArray[$i]['Ratev'];
    $Per = $ItemNamesArray[$i]['UOMv'];
    $Discount = $ItemNamesArray[$i]['PODiscountv'];
    $Amount = $ItemNamesArray[$i]['DPOAmtv'];
  
     $query1 = "INSERT INTO poinfolineitem (PONum, sn, Description, DueOn, Quantity, Rate, Per, Discount, Amount) 
     VALUES ('$PONum','$sn','$Description','$DueOn','$Quantity','$Rate','$Per','$Discount','$Amount');";
     mysql_query($query1);
  }

}

}
//exit();


/*$query = "INSERT INTO poinfo (PONum, Terms, SpecialNote, Supplier, Currency, CurrencySymb, SupplierRefNum, OtherRefNum, DespatchThrough, Destination, ConNme, ConEmail, ConPhone, PODate, SubTotal, Total) 
VALUES ('$PONum','$Terms','$SpecialNote','$Supplier','$Currency','$CurrencySymb','$SupplierRefNum','$OtherRefNum','$DespatchThrough','$Destination','$ConNme','$ConEmail','$ConPhone','$PODate','$SubTotal','$Total');";

mysql_query($query);

//Let's set all the Lne Items on the PO

$query1 = "INSERT INTO poinfolineitem (PONum, sn, Description, DueOn, Quantity, Rate, Per, Discount, Amount) 
VALUES ('$PONum','$sn','$Description','$DueOn','$Quantity','$Rate','$Per','$Discount','$Amount');";

mysql_query($query1); */
  
//$_SESSION['ErrMsgB'] = "Saved!";
echo "Saved!";
//header('Location: addLi?sRFQ='.$LIRFQ);
//close the connection

mysql_close($dbhandle);
//we need to push the email over now
        $mail->Subject = $PONum." PO Ready";
        //$mail->AddAddress("c.ogbulu@pengrg.com","");
        $mail->AddAddress("l.obhiose@pengrg.com","");
        $mail->AddAddress("c.ogbulu@pengrg.com", "");

        //$mail->AddAddress("","");
        $mail->AddBCC("g.onukwufor@pengrg.com", " PO Ready");
        $mail->AddBCC("elchabodworld@gmail.com", " PO Ready");
        
        $msg = '<!DOCTYPE html>
        <html><head>
        <meta charset="UTF-8"></head><body style="margin:0px; font-family:Sans-serif, sans-serif; background:#DBDBDB;"><div style="padding:25px; background:#FFF; font-size:22px; color:#999;"><center> <img style="float:left; width:40px; height:49px; margin-top: 0px;" src="https://www.planterp.space/mBOOT/splant.png" /> '.$PONum.' [is Ready] </center></div>
        <div style="padding:24px; margin:12px; margin-bottom:12px; font-size:15px; color:#8F8F8F; background:#FCFCFC;">Good Day,<br /><br /> Purchase Order with number : '.$PONum.' <br/> Kindly click on the below to view PO. <br /><br /> <center><a href="https://www.planterp.space/purchasing/viewPO?sPO='.$PONum.'"><button type="button" style="padding:12px; background:#00AA4D; color:#FFF; border-radius:8px; cursor:pointer;">Go to ERP</button></a></center> <br /> or copy and paste the link below on your browser <br />  https://www.planterp.space/purchasing/viewPO?sPO='.$PONum.' <br /><br /><br />Thanks<br />
        <br />Sincerely, <br/> Procurement Officer <br /> </div>   
        </body></html>';
        $mail->Body = $msg;      //HTML Body
        
       $mail->Send();

?>
