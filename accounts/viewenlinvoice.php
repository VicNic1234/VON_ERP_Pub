<?php
session_start();
error_reporting(0);
//ini_set('display_errors', 1);  error_reporting(E_ALL);
include ('../DBcon/db_config.php');

$result = mysql_query("SELECT * FROM notification WHERE StaffID='".$_SESSION['uid']."'");
//check if user exist
$NoRowMsg = mysql_num_rows($result);
$FullName = $_SESSION['Firstname'] . " " .$_SESSION['SurName'];
$msg = "";
if ($NoRowMsg > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($result)) {
	$msg .= '<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> '.$row{'Message'}.'
                        </a>
                      </li>';
	}
	
}

include('route.php');

$prasa = $_SESSION['Picture'];

$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];
$MYID = $_SESSION['uid'];
//Business Year
$BYr = $_SESSION['BusinessYear'];
$CONID = $_GET['poid'];
 $resultLI = mysql_query("SELECT * FROM enlinvoices 
 LEFT JOIN customers ON enlinvoices.CusSource = customers.cusid
 LEFT JOIN users ON enlinvoices.RaisedBy = users.uid
 WHERE cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};Currency:
     
    $cid = $row['cid'];
   
    $PONUM = $row['PONUM'];
    $IVNo = $row['IVNo'];
    $Comment = $row['Comment'];
    $conDiv = $row['conDiv'];
    $IVDate = $row['IVDate'];
    $ENLATTN = $row['ENLATTN'];
    $BnkID = $row['BnkID'];
    $CRDGL = $row['CRDGL'];
    $VENATTN = $row['CUSATTN'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PDFNUM'];
    $SupNme = $row['CustormerNme'];
    $CusSource = $row['CusSource'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
     $TAmth = getTotalSum($cid);
    $PostID = $row['PostID'];
    $ContNum = $row['ContNum'];
    $ServicENum = $row['ServicENum'];
    $VenCode = $row['VenCode'];
    $NGNRate = $row['NGNRate'];
    $Bank = $row['Bank'];
    $DDOfficer = getUserinfo($row['DDOfficer']); $DDOfficerComment = $row['DDOfficerComment']; 
    $DDOfficerOn = $row['DDOfficerOn'];
    $GMCSApp = getUserinfo($row['GMCSApp']); $GMCSAppComment = $row['GMCSAppComment']; 
    $GMCSAppDate = $row['GMCSAppDate'];
    $DDState = ""; $GMCSState = "";

    if($DDOfficerOn != "") { $DDState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($DDOfficerComment != "") { $DDState = '<i class="fa fa-comment text-green"></i>';  }
    else { $DDState = '<i class="fa fa-edit text-red"></i>'; }

    if($GMCSAppDate != "") { $GMCSState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($GMCSAppComment != "") { $GMCSState = '<i class="fa fa-comment text-green"></i>';  }
    else { $GMCSState = '<i class="fa fa-edit text-red"></i>'; }


    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: enlinvoices');
    exit;
  }
  
  function getTotalSum($CONID)
{
        /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM enlivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0; $SubTotal = 0; $MainTotal = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
    $SubTotal = $SubTotal + $totalprice;
    
    
   
  }
 } 





$MainTotal =  $SubTotal;
//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM enlivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    $Impact = $row['Impact'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $AmtType = $row['AmtType'];
    $delDoc = "";
   

    if($Impact == "ADD") { 
      $Impact = "+"; 
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal + $mprice;
      }
      else{ $MainTotal = $MainTotal + ($SubTotal * $mprice)/100; $PERT = "%"; }
    }
    else { 
      $Impact = "-"; 
      
      if($AmtType == "DIRECT")
      {
       $MainTotal = $MainTotal - $mprice;
      }
      else{ $MainTotal = $MainTotal - ($SubTotal * $mprice)/100; $PERT = "% of Sub Total"; }

    }
}
}

return floatval($MainTotal);

}


$PageTitle = "ENL : Invoice".$PONo;
/*Get ATTNTION*/
$resultUser = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 $OptStaff ="";
 if ($NoRowUser > 0) {
  while ($row = mysql_fetch_array($resultUser)) 
  {
    $SUserID = $row['uid'];
    $StfName = $row['Firstname'] . " " . $row['Surname'];
    if($ENLATTN == $SUserID)
    {
    $OptStaff .= '<option selected value="'.$SUserID.'">'.$StfName.'</option>';
    }
    else
    {
    $OptStaff .= '<option value="'.$SUserID.'">'.$StfName.'</option>';
    }
  }
 }

 function getUserinfo($uid)
     {
        $resultUserInfo = mysql_query("SELECT * FROM users WHERE uid ='$uid'");
        while ($row = mysql_fetch_array($resultUserInfo)) 
        {
             return $UserNNE = $row['Firstname'] . " " . $row['Surname'];
        }
     }


 /*Get CURRENCY*/
$resultCurr = mysql_query("SELECT * FROM currencies Order By Abbreviation");
$NoRowCurr = mysql_num_rows($resultCurr);
if ($NoRowCurr > 0) {
  while ($row = mysql_fetch_array($resultCurr)) 
  {
    $cAB = $row['Abbreviation'];
    
    if($Currency == $cAB)
    {
     $CurrOpt .= '<option selected value="'.$cAB.'">'.$cAB.'</option>';
    }
    else
    {
      $CurrOpt .= '<option value="'.$cAB.'">'.$cAB.'</option>';
    }
   
  }
 }
 
  /*Get BANK*/
$resultBNK = mysql_query("SELECT * FROM bankaccount Order By acctnme");
$NoRowBNK = mysql_num_rows($resultBNK);
if ($NoRowBNK > 0) {
  while ($row = mysql_fetch_array($resultBNK)) 
  {
    $cAB = $row['description'];
    $bnkid = $row['baccid'];
    
    if($BnkID == $bnkid)
    {
     $OptBank .= '<option selected value="'.$bnkid.'">'.$cAB.'</option>';
    }
    else
    {
      $OptBank .= '<option value="'.$bnkid.'">'.$cAB.'</option>';
    }
   
  }
 }

//Let's Get All GL accounts
 $GLAccounts = mysql_query("SELECT * FROM acc_chart_master WHERE isActive =1 ORDER BY account_name"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['account_code'];
     $GLmid = $row['mid'];
      $GLAcct = mysql_real_escape_string(strip_tags($row['account_name']));
      
       $GLOptM .= '<option value="'.$GLmid.'">['. $acctvariable .'] ' .$GLAcct.'</option>';
      if($CRDGL == $GLmid )
      { $GLOpt .= '<option value="'.$GLmid.'" selected >['. $acctvariable .'] ' .$GLAcct.'</option>'; }
      else
      {
          if(589 == $GLmid)
          {
            $GLOpt .= '<option value="'.$GLmid.'" selected >['. $acctvariable .'] ' .$GLAcct.'</option>';
          }
          else
          {
            $GLOpt .= '<option value="'.$GLmid.'">['. $acctvariable .'] ' .$GLAcct.'</option>';
          }
          
      }
        // $row['DeptmentName'];
     }
     
     //echo $GLOptM;
    //exit;
     
function GETGL($GLID)
{
    $GLAccounts = mysql_query("SELECT * FROM acc_chart_master WHERE mid='".$GLID."'"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['account_code'];
     $GLmid = $row['mid'];
      $GLAcct = $row['account_name'];
 }
     return '['. $acctvariable .'] ' .$GLAcct;
   // return '<b title="">['. $acctvariable .']</b>';
}

//Let's Get All Equipment
 $EquipOpt = mysql_query("SELECT * FROM equipments WHERE isActivate =1 ORDER BY EquipNme"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['EquipNo'];
     $GLmid = $row['cid'];
      $GLAcct = $row['EquipNme'];
       $EquipOpt .= '<option value="'.$GLmid.'">['. $acctvariable .'] ' .$GLAcct.'</option>'; // $row['DeptmentName'];
     }

 /*Get CURRENCY*/
$resultUOM = mysql_query("SELECT * FROM uom");
$NoRowUOM = mysql_num_rows($resultUOM);
if ($NoRowUOM > 0) {
  while ($row = mysql_fetch_array($resultUOM)) 
  {
    $UOMAbbr = $row['UOMAbbr'];
    
    
    {
      $UOMOpt .= '<option value="'.$UOMAbbr.'">'.$UOMAbbr.'</option>';
    }
   
  }
 }

     /*Get PDF*/
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq WHERE isActive=1 AND Approved>15"); //
$NoRowREQ = mysql_num_rows($resultREQ);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultREQ)) 
  {
    $RequestID = $row['RequestID'];
   
    {
     $ReQOpt .= '<option value="'.$RequestID.'">'.$RequestID.'</option>';
    }
  
   
  }
 }

      /*Get PO*/
     /*Get PO*/
$resultPO = mysql_query("SELECT PONo, cid FROM purchaseorders WHERE isActive=1 ");
$NoRowREQ = mysql_num_rows($resultPO);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultPO)) 
  {
    $PONos = $row['PONo'];
    $POID = $row['cid'];
    if($PONUM == $POID)
    {
     $POOpt .= '<option selected value="'.$POID.'">'.$PONos.'</option>';
    }
    else
    {
     $POOpt .= '<option value="'.$POID.'">'.$PONos.'</option>';
    }
  
   
  }
 }


 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM customers Order By CustormerNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['cusid'];
    $SupNme = $row['CustormerNme'];
    if($CusSource == $supid){
     $CusOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
    }
    else
    {
    $CusOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
    }
  }
 }

 //////////////////////////////////
  
$result = mysql_query("SELECT * FROM users");
//check if user exist
 $NoRow = mysql_num_rows($result);



//Let's get the Business Unit
 $RecDiv = "";
 $resultDiv = mysql_query("SELECT * FROM businessunit ORDER BY BussinessUnit");
 $NoRowDiv= mysql_num_rows($resultDiv);
 if ($NoRowDiv > 0) {
  while ($row = mysql_fetch_array($resultDiv)) 
  {
    $DivID = $row['id'];
    $DivName = $row['BussinessUnit'];
    if($conDiv == $DivID)
    {
    $RecDiv .= '<option selected value="'.$DivID.'">'.$DivName.'</option>';

    }
    else
    {
    $RecDiv .= '<option value="'.$DivID.'">'.$DivName.'</option>';

    }
  }
 }

	

?>
<?php if ($NoRowCUS > 0) 
            {
              //fetch tha data from the database
              while ($row = mysql_fetch_array($resultCUS)) {
             
              $Custms .= '<option value="'.$row['cussnme'].'">'.$row['CustormerNme'].'</option>';
            
              }
              
            }
        

         /*Get Supporting Docs*/
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND isActive=1 AND  module='ENLINV' Order By sdid");
$NoRowSDoc = mysql_num_rows($resultSDoc);
 $SN = 0;
if ($NoRowSDoc > 0) {
  while ($row = mysql_fetch_array($resultSDoc)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['sdid'];
    $link = $row['link'];
    $addedby = $row['addedby'];
    $linkn = '<a target="_blank" href="'.$link.'"><i class="fa fa-link"></i></a>';
    $description = $row['description'];
    $title = $row['title'];
    $delDoc = "";
    if($addedby == $MYID && $PostID == 0)
    {
      $delDoc = '<a href="deldoc?id='.$sdid.'&poid='.$CONID.'"><i class="fa fa-trash"></i></a>';
    }
    $SupDocs .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$title.'</td>
                    <td>'.$description.'</td>
                    <td>'.$linkn.'</td>
                    <td>'.$delDoc.'</td></tr>';
  }
 }  

//poitems

          /*Get Line Item */
$resultPOIt = mysql_query("SELECT * FROM enlivitems Where PONo='".$CONID."' AND isActive=1");
$NoRowPOIt = mysql_num_rows($resultPOIt);
 $SN = 0;
if ($NoRowPOIt > 0) {
  while ($row = mysql_fetch_array($resultPOIt)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $PDFNUM = $row['PDFNUM'];
    $PDFItemID = $row['PDFItemID'];
    $description = $row['description'];
    $units = $row['units'];
    $qty = $row['qty'];
    $days = $row['days'];
    $unitprice = $row['unitprice'];
    if($days > 0)
    {
    $totalprice = floatval($unitprice) * floatval($qty) * floatval($days);
    }
    else
    {
        $totalprice = floatval($unitprice) * floatval($qty);
    }
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $ItemGL = $row['ItemGL'];
    $delDoc = "";
  if($PostID == 0)
  {
      $delDoc = '<form action="delenlIVItem" method="POST">
      <input type="hidden" name="id" value="'.$sdid.'" />
      <input type="hidden" name="poid" value="'.$CONID.'" />
      <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i></button>
      </form>';
    }
    
    $GLIDDesp =  GETGL($ItemGL);
    
    $LineItems .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$units.'</td>
                    <td>'.$qty.'</td>
                    <td>'.$description.'</td>
                    <td>'.$unitprice.'</td>
                    <td>'.$totalprice.'</td>
                    <td>'.$GLIDDesp .'</td>
                    <td>'.$delDoc.'</td></tr>';
  }
 }  


//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM enlivmiscellaneous Where PONo='".$CONID."' AND isActive=1");
$NoRowPOM = mysql_num_rows($resultPOM);
 $SN = 0;
if ($NoRowPOM > 0) {
  while ($row = mysql_fetch_array($resultPOM)) 
  {
    $SN =  $SN  + 1;
    $sdid = $row['poitid'];
    $description = $row['description'];
    $mprice = $row['price'];
    
    $Impact = $row['Impact'];
    $AmtType = $row['AmtType'];
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $ItemGL = $row['ItemGL'];
    $delDoc = "";
  
      //$delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    if($PostID == 0)
    {
      $delM = '<form action="delenlIVMItem" method="POST">
      <input type="hidden" name="id" value="'.$sdid.'" />
      <input type="hidden" name="poid" value="'.$CONID.'" />
      <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i></button>
      </form>';
    }
    
    
     $GLIDDesp =  GETGL($ItemGL);
    $MItems .= '<tr>
                     
                    <td>'.$description.'</td>
                    <td>'.$Impact.'</td>
                    <td>'.$AmtType.'</td>
                    <td>'.number_format($mprice).'</td>
                    <td>'.$GLIDDesp.'</td>
                    <td>'.$delM.'</td>
                    </tr>';
  }
 }  
      ?>





<!DOCTYPE html>
<html>
 <?php include('../header2.php'); ?>

  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
    <?php include('../topmenu2.php') ?>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include('leftmenu.php') ?>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             ENL Invoice No.: <?php echo $IVNo; ?>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $IVNo; ?></li>
          </ol>
        </section>
              
        <!-- Main content -->
        <section class="content">
          
<?php if ($G == "")
           {} else {
echo

'<div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-info-circle"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                         '<center>'.  $G. '</center> '.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}

 if ($B == "")
           {} else {
echo

'<div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-info-circle"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<center>'.  $B. '</center> '.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>
  
          <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">ENL Invoice Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#FFFF99; border-radius: 15px; padding-top:22px;">
                    
                                <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="updateENLINVOICE" method="post">

                                 <input type="hidden" name="conID" value="<?php echo $cid; ?>">
          <div class="form-group has-feedback col-md-12" >
                <label>Choose Customer/Client:</label>
                <select class="select2 form-control" id="CusSource" name="CusSource" style="width:100%" required>
                <option value=""> Choose Customer</option>
                <?php echo $CusOpt; ?>
                </select>
          
          </div>

          
      
       
      
      <div class="form-group has-feedback col-md-4">
                    <label>Invoice Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" name="InvoiceDate" id="InvoiceDate" required readonly placeholder="Click to set Date" value="<?php echo $IVDate; ?>" />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-5">
                 
                    <label>ENL ATTENTION:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <select class="form-control" name="ENLATTN">
                        <?php echo $OptStaff; ?>
                      </select>
                    </div><!-- /.input group -->
          </div>
          <div class="form-group has-feedback col-md-3">
            <label>Currency:</label>
           <select class="form-control" name="currency">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>
          
         <div class="form-group col-md-2">
                    <label>NGN Rate:</label>
                    
                      
                      <input type="text" class="form-control" name="NGNRate" id="NGNRate" onKeyPress="return isNumber(event)" required value="<?php echo $NGNRate; ?>" />
                   
          </div>
          
          <div class="form-group has-feedback col-md-6">
                 
                    <label>ENL BANK:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <select class="form-control" name="ENLBANK">
                        <?php echo $OptBank; ?>
                      </select>
                    </div><!-- /.input group -->
          </div>
          

         

          <div class="form-group has-feedback col-md-6">
                 
                    <label>CLIENT ATTENTION:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input class="form-control" name="CUSATTN" value="<?php echo $VENATTN; ?>" >
                    </div><!-- /.input group -->
          </div>

          <div class="form-group has-feedback col-md-6">
            <label>Choose Business Unit:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Business Unit</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

           <div class="form-group has-feedback col-md-6">
                 
                    <label>Vendor Code:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-barcode"></i>
                      </div>
                      <input class="form-control" name="VenCode" value="<?php echo $VenCode; ?>" >
                    </div><!-- /.input group -->
          </div>

           <div class="form-group has-feedback col-md-6">
                 
                    <label>Service Entry No.:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-barcode"></i>
                      </div>
                      <input class="form-control" name="ServicENum" value="<?php echo $ServicENum; ?>" >
                    </div><!-- /.input group -->
          </div>
          
           <div class="form-group has-feedback col-md-6">
                 
                    <label>Debiting GL Account:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-barcode"></i>
                      </div>
                     <select class="srcselect form-control" id="DBDGL" name="DBDGL" style="width:100%" required>
                <option value=""> --</option>
                <?php echo $GLOpt; ?>
                </select>
                    </div><!-- /.input group -->
          </div>
          
          

     <div class="form-group has-feedback col-md-12">
            <label>Comment:</label>
       <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"><?php echo $Comment; ?></textarea>
     </div>
   
      
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>ENL Invoice Number</strong>
                      </p>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="ENLInvoiceID" name="ENLInvoiceID" placeholder="" value="<?php echo $IVNo; ?>" required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
             <p class="text-center">
                        <strong>Contract Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <!--<select class="form-control" name="ContNum">
            <option value="">--</option>
            <?php echo $ContOpt; ?>
           </select> -->
           <input type="text" class="form-control" name="ContNum" value="<?php echo $ContNum; ?>" />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
          <br/>
             <p class="text-center">
                        <strong>ENL PO Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <!--<select class="form-control" name="ENLPONum">
            <option value="">--</option>
            <?php echo $POOpt; ?>
           </select> -->
           <input type="text" class="form-control" name="ENLPONum" value="<?php echo $PONUM; ?>"  />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br/>
     
      <!--<p class="text-center">
                        <strong>Vendor Invoice Document (Optional)</strong>
                      </p>
      <div class="form-group has-feedback">
            <input type="file" id="VENFile" name="VENFile" class="form-control" />
      
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>-->


          <div class="row">
           
            <div class="col-xs-12">
                 <?php if($PostID < 1 ) { ?>
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update ENL Invoice</button>
              <?php } ?>
            </div><!-- /.col -->
          </div>
                      </form> 
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->

              <!-- Line items -->
              <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header">
                 Line Items
                 <form action="postENLINVOICE" method="POST">
                  <input type="hidden" name="poid" value="<?php echo $cid; ?>">
                  <?php if($PostID < 1 && $TAmth > 0 && $IVDate != "" ) { 
                  
                  if($Currency != "NGN" && $NGNRate ==  "")
                  {
                      echo "Set Naira Rate For : ". $Currency;
                  }
                  else
                  {
                  
                  ?> 
                  <button class="btn btn-success pull-right"> <i class="fa fa-file"></i>  Post ENL's Invoice </button>
                 <?php } } ?>
                 
                 
                </form>
                
                 <?php if($IVDate == "" && $PostID < 1 ) { ?> 
                  <button class="btn btn-danger pull-right"> <i class="fa fa-file"></i>  Set Invoice Date To POST </button>
                 <?php } ?>
                 <form action="printENLINVOICE" method="POST">
                  <input type="hidden" name="poid" value="<?php echo $cid; ?>">
                  <button class="btn btn-info pull-right"> <i class="fa fa-file"></i>  View ENL's Invoice </button>

                </form>
                
                 <?php if($PostID == 0) { ?>
                 <button type="button" class="btn btn-warning pull-right" onclick="addLI()"> Add Item </button>
                 <!--<button class="btn btn-success pull-right" onclick="addLIPDF()"> Add Item From PDF </button> -->
               <?php } ?>
               
               <script>
                        function mmk()
                       {
                            var CONID = '<?php echo $CONID; ?>';
                            var OPTGL = '<?php echo $GLOptM; ?>';
                            alert(OPTGL);
                             /*var UOMOpt = '<?php echo $UOMOpt; ?>';
                           alert("Grace of GOD");
                           var content = '<form role="form" action="addENLIVItem" method="POST" enctype="multipart/form-data" ><div class="form-group">';
                           var size='standart';
                           var title = 'New Item Details';
                              var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                            setModalBox(title,content,footer,size);
                            $('#myModal').modal('show');
                            */
                       }
               </script>
               <script>
               
               
                   function addLI()
                  {
                  
                    var CONID = '<?php echo $CONID; ?>';
                    var OPTGL = '<?php echo $GLOptM; ?>';
                    //alert(OPTGL);
                    var UOMOpt = '<?php echo $UOMOpt; ?>';
                      var size='standart';
                              var content = '<form role="form" action="addENLIVItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                               '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                              
                               '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +
            
                                '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control"  name="ItemUnit" >'+UOMOpt+'</select></div>' +
            
                               
                                 '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitQty" onInput="chkIT()" name="UnitQty" required ></div>' +
            
                                  '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitPrice" onInput="chkIT()" name="UnitPrice" required ></div>' +
            
            
                                 '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nTotalPrice"  name="TotalPrice" readonly ></div>' +
                               
                               '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Crediting GL: </label><select class="form-control"  name="ItemGL" required ><option value=""> --</option>'+OPTGL+'</select></div>' +
            
                                
                                 
                               '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                              var title = 'New Item Details';
                              var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
            
                              setModalBox(title,content,footer,size);
                              $('#myModal').modal('show');
            
                          
                  }
               </script>
               
         
                
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ITEM</th>
                        <th>UNIT</th>
                        <th>QTY</th>
                        <th>DESCRIPTION</th>
                        <th>UNIT PRICE</th>
                        <th>TOTAL PRICE</th>
                        <th>Cr. GL</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $LineItems; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>

              <!-- Line items -->
              <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header">
                 Miscellaneous
                 <?php if($PostID == 0) { ?>

                 <button class="btn btn-warning pull-right" onclick="addMI()"> Add Item </button>
                <?php } ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        
                        <th>DESCRIPTION</th>
                        <th>IMPACT TYPE</th>
                        <th>VALUE TYPE</th>
                        <th>PRICE</th>
                        <th>Cr. GL</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $MItems; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>


              <div class="col-md-12">
              
              <!--
              <div class="col-md-3">
                 <div class="box box-info">
                <div class="box-header">
                 Authorization
                </div>
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th colspan="2">Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Legal</td>
                        <td>
                          <input type="checkbox" name="conlegal">
                      </td>
                      </tr>
                      <tr>
                        <td>Technical</td>
                        <td>
                          <input type="checkbox" name="contech">
                          
                      </td>
                      </tr>
                      <tr>
                        <td>Commercial</td>
                        <td>
                           <input type="checkbox" name="concomm">
                      </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
            -->
              <!--
               <div class="col-md-3">
                 <div class="box box-info">
                <div class="box-header">
                 Release for Citing
                </div>
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Due Diligence</th>
                        <td>
                          <input type="checkbox" name="conlegal">
                        </td>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              </div>
            -->

 


              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
	
	
		
		
		
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  

       <?php include('../footer.php') ?>

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
       <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku">
                      </div>
                      <div class="modal-footer" id="modal-footerq">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of modal ------------------------------>
                    </div>
    </div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
	 <!-- date-range-picker -->
    <script src="../mBOOT/moment.min.js" type="text/javascript"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	 <!-- bootstrap time picker -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
  <script src="../mBOOT/jquery-ui.js"></script>

    <script type="text/javascript">
      $(function () {
        $("#userTab").dataTable();
          var LastEntryDate = '<?php echo $LastEntryDate; ?>';
          $(".datep").datepicker({dateFormat : 'yy/mm/dd', changeYear: true, changeMonth: true, minDate: LastEntryDate });
          //$('#DBDGL').val(589);
          //$("#DBDGL option[value=589]").prop("selected", true);
      });
    </script>


 <script>
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
    }
    </script>

      <script type="text/javascript">
      function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }

    </script>

       <script type="text/javascript">
      function adddoc()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        
          var size='standart';
                  var content = '<form role="form" action="addDocIV" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Title: </label><input type="text" class="form-control"  name="DocTitle" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Description: </label><input type="text" class="form-control"  name="DocDescr" ></div>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Document Link: </label><input type="text" class="form-control"  name="DocLink" ></div> <center> <b>--OR--</b> </center>' +

                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Upload Document: </label><input type="file" class="form-control"  name="DocFile" ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Document</button><br/></form>';
                  var title = 'New Document Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>

    <script type="text/javascript">
      


      function addMI()
      {
      
        var CONID = '<?php echo $CONID; ?>';
        var OPTGL = '<?php echo $GLOptM; ?>';
        //alert(CONID);
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" action="addENLIVMItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Impact Type: </label><select class="form-control"  name="ItemImpact" ><option>ADD</option><option>SUBTRACT</option></select></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Type: </label> <br/> <label> <input type="radio" checked name="AmtType" id="AmtType1" onclick="setlbnum();" value="DIRECT" > Direct Amount</label> &nbsp; &nbsp; <label> <input type="radio" name="AmtType" value="PERCENT" id="AmtType2" onclick="setlbnum();" > Percentage</label></div>' +

                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label id="lbnum">Amount: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" name="ItemPrice" required ></div>' +
                    
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Crediting GL: </label><select class="form-control"  name="ItemGL" required ><option value=""> --</option>'+OPTGL+'</select></div>' +


                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'New Miscellaneous Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

      function setlbnum()
      {
        var AmtType2 = $('#AmtType2').prop('checked');
        if(AmtType2 == true) { $('#lbnum').html("Percentage:"); } else {
          $('#lbnum').html("Amount:");
        }
      }
      function chkIT()
      {
        var UnitQty = $('#nUnitQty').val();
        var UnitPrice = $('#nUnitPrice').val();
        var TotalPrice = Number(UnitQty) * Number(UnitPrice);
        $('#nTotalPrice').val(TotalPrice);
      }
    </script>

    <script type="text/javascript">
      function addLIPDF()
      {
      
        var CONID = '<?php echo $CONID ?>';
        var UOMOpt = '<?php echo $UOMOpt; ?>';
        var ReQOpt = '<?php echo $ReQOpt ?>';
        var $PDFNUM = '<?php echo $PDFNUM ?>';
        //alert(ReQOpt);
        //var Nosr = '<option value=\"ENL-000000\">ENL-000000</option><option value=\"ENL-000001\">ENL-000001</option><option selected value=\"ENL-000002\">ENL-000002</option>';

          var size='standart';
                  var content = '<form role="form" action="addIVItem" method="POST" enctype="multipart/form-data" style="background:#EEE6E6; border-radius:5px;" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Select PDF: </label><select class="form-control" onchange="setPDFItem(this)" id="PDFNum" name="PDFNum" required ><option value=""> --- </option>'+ReQOpt+'</select></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Select PDF Item: </label><select class="form-control" onchange="getPDFItemInfo()"  name="PDFItem" id="PDFItem" ></select></div>' +

                   '<div class="form-group" style="width:90%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" id="PDFItemDesc" required readonly ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control" id="PDFItemUnit"  name="ItemUnit"  >'+UOMOpt+'</select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" oninput="compTotal()" onKeyPress="return isNumber(event)" class="form-control" id="PDFUnitQty"  name="UnitQty" required ></div>' +

                      '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" oninput="compTotal()" onKeyPress="return isNumber(event)" class="form-control" id="PDFUnitPrice"  name="UnitPrice" required ></div>' +


                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="PDFTotalPrice"  name="TotalPrice" readonly ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'PDF Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

                  setPDFItem();
      }
      
      function compTotal()
      {
          var PDFUnitPrice = $('#PDFUnitPrice').val();
           var PDFUnitQty = $('#PDFUnitQty').val();
           var TotalPricePDF = Number(PDFUnitPrice) * Number(PDFUnitQty);
           $('#PDFTotalPrice').val(TotalPricePDF);
      }

      
      function setPDFItem()
      {
        var PDFCODE = $('#PDFNum').val();
        var dataString = { PDFCODE:PDFCODE };
         $.ajax({
                  type: "POST",
                  url: "getPDFItems",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //alert(html);
                     $('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }

        function getPDFItemInfo()
      {
        var PDFItem = $('#PDFItem').val();
        var dataString = { PDFItem:PDFItem };
         $.ajax({
                  type: "POST",
                  url: "getPDFItemInfo",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //var  data1 = JSON.stringify(html[0]); 
                     //alert(html);
                     data1 = JSON.parse(html)
                     var Purpose = data1[0].Purpose;
                     //alert(Purpose);

                    var ItemDes = data1[0].ItemDes;
                     $('#PDFItemDesc').html(ItemDes);//alert(ItemDes);

                     var Amount = data1[0].Amount;
                     $('#PDFUnitPrice').val(Amount);

                     var Qty = data1[0].Qty;
                     $('#PDFUnitQty').val(Qty);

                     var TotalPrice = Number(Qty) * Number(Amount);
                     $('#PDFTotalPrice').val(TotalPrice);
                     //$('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }
    </script>
	
  </body>
</html>