<?php
session_start();
error_reporting(0);
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
 $resultLI = mysql_query("SELECT * FROM purchaseorders 
 LEFT JOIN suppliers ON purchaseorders.VendSource = suppliers.supid
 LEFT JOIN users ON purchaseorders.RaisedBy = users.uid
 WHERE cid='".$CONID."'
 "); //WHERE isActive=1 ORDER BY cid

 $NoRowLI = mysql_num_rows($resultLI);
//fetch tha data from the database
   if ($NoRowLI > 0) 
   {
   $SN = 1;
  while ($row = mysql_fetch_array($resultLI)) {
     //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     
    $cid = $row['cid'];
    $PONo = $row['PONo'];
    $Comment = $row['Comment'];
    $conDiv = $row['conDiv'];
    $PODate = $row['PODate'];
    $ENLATTN = $row['ENLATTN'];
    $Currency = $row['Currency'];
    $PDFNUM = $row['PDFNUM'];
    $SupNme = $row['SupNme'];
    $VendSource = $row['VendSource'];
    $RaisedBy = $row['Firstname'] . " " . $row['Surname'];//$row['RaisedBy'];
    $TotalSum = $row['TotalSum'];
    $FileLink = $row['FileLink'];
    $SupNme = $row['SupNme'];
    $SupAddress = $row['SupAddress'];
    $SupCountry = $row['SupCountry'];
    $SupPhone1 = $row['SupPhone1'];
    $ScopeWS = $row['ScopeOfSW'];
    $DDOfficer = getUserinfo($row['DDOfficer']); $DDOfficerComment = $row['DDOfficerComment']; 
    $DDOfficerOn = $row['DDOfficerOn'];
    $DDState = "";

    if($DDOfficerOn != "") { $DDState = '<i class="fa fa-legal text-green"></i>';  }
    elseif ($DDOfficerComment != "") { $DDState = '<i class="fa fa-comment text-green"></i>';  }
    else { $DDState = '<i class="fa fa-edit text-red"></i>'; }
    }
  }
  else
  {
    $_SESSION['ErrMsg'] = "Oops! an error occured, try again";
    header('Location: purchaseorders');
    exit;
  }
$PageTitle = "PO : ".$PONo;
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
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM poreq WHERE isActive=1 AND Approved=11 ");
$NoRowREQ = mysql_num_rows($resultREQ);
if ($NoRowREQ > 0) {
  while ($row = mysql_fetch_array($resultREQ)) 
  {
    $RequestID = $row['RequestID'];
    if($PDFNUM == $RequestID)
    {
     $ReQOpt .= '<option selected value="'.$RequestID.'">'.$RequestID.'</option>';
    }
    else
    {
     $ReQOpt .= '<option value="'.$RequestID.'">'.$RequestID.'</option>';
    }
  
   
  }
 }

 /*Get Suppliers*/
$resultSUP = mysql_query("SELECT * FROM suppliers Order By SupNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['supid'];
    $SupNme = $row['SupNme'];
    if($VendSource == $supid){
     $SupOpt .= '<option selected value="'.$supid.'">'.$SupNme.'</option>';
    }
    else
    {
    $SupOpt .= '<option value="'.$supid.'">'.$SupNme.'</option>';
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
$resultSDoc = mysql_query("SELECT * FROM supportingdoc Where docid='".$CONID."' AND isActive=1 AND  module='CNP' Order By sdid");
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
    if($addedby == $MYID && $DDOfficerOn == "")
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
$resultPOIt = mysql_query("SELECT * FROM poitems Where PONo='".$CONID."' AND isActive=1");
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
    $unitprice = $row['unitprice'];
    $totalprice = floatval($unitprice) * floatval($qty);
    $CreatedBy = $row['CreatedBy'];
    $isActive = $row['isActive'];
    $delDoc = "";
  if($DDOfficerOn == "")
  {
      $delDoc = '<form action="delPOItem" method="POST">
      <input type="hidden" name="id" value="'.$sdid.'" />
      <input type="hidden" name="poid" value="'.$CONID.'" />
      <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i></button>
      </form>';
    }
    
    $LineItems .= '<tr>
                      <td>'.$SN.'</td>
                      <td>'.$units.'</td>
                    <td>'.$qty.'</td>
                    <td>'.$description.'</td>
                    <td>'.$unitprice.'</td>
                    <td>'.$totalprice.'</td>
                    <td>'.$delDoc.'</td></tr>';
  }
 }  


//PO Miscellaneous
           /*Get M Item */
$resultPOM = mysql_query("SELECT * FROM pomiscellaneous Where PONo='".$CONID."' AND isActive=1");
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
    $delDoc = "";
  
      //$delDoc = '<a href="deldoc?id='.$sdid.'"><i class="fa fa-trash"></i></a>';
    if($DDOfficerOn == "")
    {
      $delM = '<form action="delPOMItem" method="POST">
      <input type="hidden" name="id" value="'.$sdid.'" />
      <input type="hidden" name="poid" value="'.$CONID.'" />
      <button type="submit" class="btn btn-success"><i class="fa fa-trash"></i></button>
      </form>';
    }
    
    $MItems .= '<tr>
                     
                    <td>'.$description.'</td>
                    <td>'.$Impact.'</td>
                    <td>'.$AmtType.'</td>
                    <td>'.number_format($mprice).'</td>
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
             P. Order No.: <?php echo $PONo; ?>
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $PONo; ?></li>
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
              <div class="box <?php if($DDOfficerOn != "") { echo 'collapsed-box' ; } ?>">
                <div class="box-header with-border">
                  <h3 class="box-title">Purchase Order Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8" style="background-color:#DBCACA; border-radius: 15px; padding-top:22px;">
                    
                     <?php if($DDOfficerOn == "") { ?>
                      <form enctype="multipart/form-data" id="fRFQ" name="fRFQ" action="updatePO" method="post">
                      <?php } ?>
          <div class="form-group has-feedback col-md-12" >
                <label>Choose Vendor:</label>
          		  <select class="form-control" id="VendSource" name="VendSource" required>
          			<option value=""> Choose Vendor</option>
          			<?php echo $SupOpt; ?>
          			</select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
            <input type="hidden" name="ConID" value="<?php echo $CONID; ?>" required>
          </div>
		  
		   
		  
		  <div class="form-group has-feedback col-md-6">
                    <label>PO Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" value="<?php echo $PODate; ?>" name="PODate" required />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-6">
                 
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

          <div class="form-group has-feedback col-md-6">
            <label>Choose Business Unit:</label>
            <select class="form-control" id="conDiv" name="conDiv" required >
            <option value=""> Choose Business Unit</option>
            <?php echo $RecDiv; ?>
            </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Currency:</label>
           <select class="form-control" name="currency">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Total Sum (optional):</label>
           <input type="text" class="form-control" name="totalSum" value="<?php echo $TotalSum; ?>" onKeyPress="return isNumber(event)" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

		 <div class="form-group has-feedback col-md-12">
            <label>Scope of Work/Supply:</label>
       <textarea rows="4" cols="50" placeholder=" Enter scope here..." id="Scope" name="Scope" style="width:100%; display: inline-block;"><?php echo $ScopeWS; ?></textarea>
     </div>
   
		 
		 <div class="form-group has-feedback col-md-12">
            <label>Comment:</label>
		   <textarea rows="4" cols="50" placeholder=" Enter comment here..." id="Comment" name="Comment" style="width:100%; display: inline-block;"><?php echo $Comment; ?></textarea>
		 </div>
   
		  
  </div><!-- /.col -->
                    
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>PO Number</strong>
                      </p>
			    <div class="form-group has-feedback">
            <input type="text" class="form-control" readonly value="<?php echo $PONo; ?>" id="ContractNo" name="ContractNo" placeholder="ENL/CUSN/C&P/PO/002"  required />
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
		 <br/>
             <p class="text-center">
                        <strong>PDF Number (Optional)</strong>
                      </p>
          <div class="form-group has-feedback">
           <select class="form-control" name="PDFNum">
            <option value="">--</option>
            <?php echo $ReQOpt; ?>
           </select>
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
          </div>
<br/>
			<p class="text-center">
                        <strong>Select Document to Over write (Optional)</strong>
                      </p>
			<div class="form-group has-feedback">
            <input type="file" id="CONFile" name="CONFile" class="form-control" />
			
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>		

                      <p class="text-center">
                        <?php if($FileLink != "") { ?>
                       <a href="<?php echo $FileLink; ?>"><strong>Main PO Document</strong></a>
                     <?php } ?>
                      </p>

 
     
         <?php if($DDOfficerOn == "") { ?>
          <div class="row">
           
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
            </div><!-- /.col -->
          </div>
        <?php } ?>
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
                 <form action="printPO" method="POST">
                  <input type="hidden" name="poid" value="<?php echo $cid; ?>">
                  <button class="btn btn-info pull-right"> <i class="fa fa-file"></i>  View PO </button>

                </form>
                 <?php if($DDOfficerOn == "") { ?>
                 <button class="btn btn-warning pull-right" onclick="addLI()"> Add Item </button>
                 <button class="btn btn-success pull-right" onclick="addLIPDF()"> Add Item From PDF </button> 
               <?php } ?>
                
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
                 <?php if($DDOfficerOn == "") { ?>

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
              <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header">
                 Supporting Documents
                 <button class="btn btn-primary pull-right" onclick="adddoc()"> Add Document</button>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S/N</th>
                        <th>File Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Delete</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                        <tr><td>-</td><td colspan=4> <?php if($FileLink != "") { ?>
                       <a href="<?php echo $FileLink; ?>"><center><strong>Main PO Document</strong></center></a>
                     <?php } ?></td></tr>
                    <?php echo $SupDocs; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
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
            
            
              <div class="col-md-6">
                 <div class="box box-success">
                <div class="box-header">
                 Officer Due Diligence Comment
                </div><!-- /.box-header -->
                <div class="box-body">
                   <div class="row">
                    <div class="col-md-12">
                       
                       <form enctype="multipart/form-data" action="" method="post">

                            <div class="form-group has-feedback col-md-12" >
                                  <input type="hidden" name="conID" value="<?php echo $cid; ?>">
                                  <textarea class="form-control" style="height: auto" required name="DDcomment" disabled="" ><?php echo $DDAOfficerComment; ?></textarea> 
                            </div>

                             <div class="form-group has-feedback col-md-12" >
                                  <label>Treated By:</label>
                                <label> <?php echo $DDAOfficer; ?></label>
                            </div>
                            

                            <div class="form-group has-feedback col-md-12" >
                                  <label>Officer Due Dilligence Approved On:</label>
                                <label> <?php echo $DDAOfficerOn; ?></label>
                            </div>

                            <div class="form-group has-feedback col-md-12" >
                              <?php if($DDAOfficerOn == "") { ?>
                                  <label style="color:red"><input type="checkbox" name="DDapprove" disabled=""> &nbsp; &nbsp; Pending Approval</label>
                              <?php } else { ?>
                                <label  style="color:green"><input type="checkbox" checked name="DDapprove" disabled> &nbsp; &nbsp; Approved</label>
                              <?php } ?>
                                  
                            </div>

                           

                      </form>

                    </div>
                   </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>

   <div class="col-md-6">
                 <div class="box box-success">
                <div class="box-header">
                 GM Due Diligence Comment
                </div><!-- /.box-header -->
                <div class="box-body">
                   <div class="row">
                    <div class="col-md-12">
                       
                       <form enctype="multipart/form-data" action="" method="post">

                            <div class="form-group has-feedback col-md-12" >
                                  <input type="hidden" name="conID" value="<?php echo $cid; ?>">
                                  <textarea class="form-control" style="height: auto" required name="DDcomment" disabled="" ><?php echo $DDOfficerComment; ?></textarea> 
                            </div>

                             <div class="form-group has-feedback col-md-12" >
                                  <label>Treated By:</label>
                                <label> <?php echo $DDOfficer; ?></label>
                            </div>
                            

                            <div class="form-group has-feedback col-md-12" >
                                  <label>GM Due Dilligence Approved On:</label>
                                <label> <?php echo $DDOfficerOn; ?></label>
                            </div>

                            <div class="form-group has-feedback col-md-12" >
                              <?php if($DDOfficerOn == "") { ?>
                                  <label style="color:red"><input type="checkbox" name="DDapprove" disabled=""> &nbsp; &nbsp; Pending Approval</label>
                              <?php } else { ?>
                                <label  style="color:green"><input type="checkbox" checked name="DDapprove" disabled> &nbsp; &nbsp; Approved</label>
                              <?php } ?>
                                  
                            </div>

                           

                      </form>

                    </div>
                   </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>


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
          $(".datep").datepicker();
      });
    </script>

  <script type="text/javascript">      
        $('.srcselect').select2();
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
                  var content = '<form role="form" action="addDocPO" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
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
      function addLI()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" action="addPOItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control"  name="ItemUnit" >'+UOMOpt+'</select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitQty" onInput="chkIT()" name="UnitQty" required ></div>' +

                      '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitPrice" onInput="chkIT()" name="UnitPrice" required ></div>' +


                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nTotalPrice"  name="TotalPrice" readonly ></div>' +
                   

                   '<button type="submit" class="btn btn-success pull-right">Add Item</button><br/></form>';
                  var title = 'New Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }


      function addMI()
      {
      
        var CONID = '<?php echo $CONID ?>';
        //alert(CONID);
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" action="addPOMItem" method="POST" enctype="multipart/form-data" ><div class="form-group">' +
                   '<input type="hidden" name="conID" value="'+CONID+'" required />'+
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Impact Type: </label><select class="form-control"  name="ItemImpact" ><option>ADD</option><option>SUBTRACT</option></select></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Type: </label> <br/> <label> <input type="radio" checked name="AmtType" id="AmtType1" onclick="setlbnum();" value="DIRECT" > Direct Amount</label> &nbsp; &nbsp; <label> <input type="radio" name="AmtType" value="PERCENT" id="AmtType2" onclick="setlbnum();" > Percentage</label></div>' +

                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label id="lbnum">Amount: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" name="ItemPrice" required ></div>' +

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
                  var content = '<form role="form" action="addPOItem" method="POST" enctype="multipart/form-data" style="background:#EEE6E6; border-radius:5px;" ><div class="form-group">' +
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