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

$PageTitle = "Bank Payment";
/*Get ATTNTION*/
$resultUser = mysql_query("SELECT * FROM users ORDER BY Firstname");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 $OptStaff ='<option value=""> --- </option>';
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

 $resultUser = mysql_query("SELECT * FROM otherreceiver ORDER BY FullName");
//check if user exist
 $NoRowUser = mysql_num_rows($resultUser);

 
 if ($NoRowUser > 0) {
  while ($row = mysql_fetch_array($resultUser)) 
  {
    $SUserID = "OR". $row['uid'];
    $StfName = $row['FullName'];
   
    $OptStaff .= '<option value="'.$SUserID.'">'.$StfName.'</option>';
   
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

//Lets get GL for BANK
  $OptGLBank = '<option value="">--</option>';
  $resultGLBnk = mysql_query("SELECT * FROM bankaccount INNER JOIN acc_chart_master ON bankaccount.GLAcct =  acc_chart_master.mid ORDER BY account_name");
    //check if user exist
     $NoRowBnkSet = mysql_num_rows($resultGLBnk);
    if ($NoRowBnkSet > 0) 
      {
        while ($row = mysql_fetch_array($resultGLBnk)) 
        {
          $acctid = $row['baccid'];
          $acctbnkDesp = $row['description'];
          $acctvariable = $row['account_code'];
          $GLAcct = $row['GLAcct'];
          $acctval = $row['account_name'];
          $OptGLBank .='<option glacc="'.$GLAcct.'" value="'.$acctid.'">['.$acctvariable.'] '.$acctval.' :: '.$acctbnkDesp.'</option>';
        }
      }

//Let's Get All GL accounts
 $GLAccounts = mysql_query("SELECT * FROM acc_chart_master WHERE isActive =1 ORDER BY account_name"); 
 while ($row = mysql_fetch_array($GLAccounts)) {
     //$reqid = $row['reqid'];
     $acctvariable = $row['account_code'];
     $GLmid = $row['mid'];
      $GLAcct = $row['account_name'];
       $GLOpt .= '<option value="'.$GLmid.'">['. $acctvariable .'] ' .$GLAcct.'</option>'; // $row['DeptmentName'];
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
$resultREQ = mysql_query("SELECT DISTINCT RequestID FROM cashreq WHERE isActive=1 AND Approved=16 ");
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
$resultSUP = mysql_query("SELECT * FROM customers Order By CustormerNme");
$NoRowSUP = mysql_num_rows($resultSUP);
if ($NoRowSUP > 0) {
  while ($row = mysql_fetch_array($resultSUP)) 
  {
    $supid = $row['cusid'];
    $SupNme = $row['CustormerNme'];
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
             Process Bank/Other Reciepts
            <small>Version <?php echo $_SESSION['version']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Process Bank/Other Reciepts</li>
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
  <form id="postPetty" action="postRecipt" method="POST">
          <div class="row">
            <div class="col-md-12">
              <div class="box <?php if($DDOfficerOn != "") { echo 'collapsed-box' ; } ?>">

                <div class="box-header with-border">
                  <h3 class="box-title">Recipt No./Ref No. Details</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   
                    <!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12" style="background-color:#DBCACA; border-radius: 15px; padding-top:22px;">
                    
                    
                      

          <div class="form-group has-feedback col-md-7" >
                <label>Select Bank:</label>
                <select class="srcselect form-control" id="BANKGL" name="BANKGL" onChange="setDescription(); loadChk(this);" required>
                <option value=""> Choose Bank</option>
                <?php echo $OptGLBank; ?>
                </select>
            <span class="glyphicon glyphicon-export form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-4" >
                <label>Select Receipt No./Ref No.:</label>

                <div class="input-group">
                   <div class="input-group-addon" onclick="RegChk()" style="background-color: green; color:#FFF">
                        <i title="Add New Reciept" class="fa fa-plus"></i>
                      </div>

                      <select class="srcselect form-control" onchange="getCHK(this)" id="ChqNo" name="ChqNo" required>
                <option value=""> Choose Reciept No./Ref No.</option>
                
                </select>
                </div>
          		  
           
           
          </div>
          
            <script type="text/javascript">
            function AddRec()
           {  
                var title = 'New Receiver';

            var size='standart';
            var content = '<form role="form" method="post" action="regnrec">'+
            '<div class="row">'+
                  '<div class="col-md-12">'+
                     

                     '<div class="form-group col-md-12">'+
                     '<label>Receiver FullName: </label>'+
                     '<input type="text" class="form-control" id="RecFN" name="RecFN" required >'+ 
                     '</div>' +

                    

                     '<div class="form-group col-md-6 pull-right">'+
                    
                     '<button type="button" onclick="RegOR()" class="btn btn-success">Register</button>'+ 
                     '</div>' +
                   '</div>'+
            '</div>'
                   ;
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></form>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            //$('#ChqDate').datepicker({dateFormat : 'yy/mm/dd'});
           }    

           function RegOR()
           {
            var OR = $('#RecFN').val();
            if(OR == "") { alert("Kindly enter full name of Receiver. Thanks"); return false; };
                var dataString = { OR:OR };
         $.ajax({
                  type: "POST",
                  url: "regOR",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     
                     
                     if(html == "Receiver with this FullName already exist")
                     {
                      alert(html);
                     }
                     else
                     {
                       $('#RECEIVER').append(html);
                       $('#myModal').modal('hide');
                     }
                  
                  }
              });
        
            /////////////////////


           }  
             function RegChk()
       {  
      var title = 'New Reciept No';
      var OptGLBank = '<?php echo $OptGLBank ?>'; 

            var size='standart';
            var content = '<form role="form" method="post" action="regrecipt">'+
            '<div class="row">'+
                  '<div class="col-md-12">'+
                     '<div class="form-group col-md-12">'+
                     '<label>Select Bank Account: </label>'+
                     '<select class="form-control" id="BANKGL" name="BANKGL"  required >'+ 
                     OptGLBank +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Reciept No./Ref Number: </label>'+
                     '<input class="form-control" id="ChqNo" name="ChqNo" required >'+ 
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Reciept Type: </label>'+
                     '<select class="form-control" id="TranType" name="TranType">'+
                     '<option>Cash</option>'+
                     '<option>Cheque</option>'+
                     '<option>Transfer</option>'+
                     '<option>Bank Wire</option>'+
                     '<option>Others</option>'+
                     '</select>'+ 
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Amount: </label>'+
                     '<input class="form-control" id="ChqAmt" name="ChqAmt" onKeyPress="return isNumber(event)" required >'+ 
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Reciept Date: </label>'+
                     '<input class="form-control" id="ChqDate" name="ChqDate" placeholder="Click to select" readonly required >'+ 
                     '</div>' +

                     '<div class="form-group col-md-6 pull-right">'+
                    
                     '<button type="submit" class="btn btn-success">Register</button>'+ 
                     '</div>' +
                   '</div>'+
            '</div>'
                   ;
           // var title = 'Add Quotation Price to Line Item';
            var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></form>';
            setModalBox(title,content,footer,size);
            $('#myModal').modal('show');
            $('#ChqDate').datepicker({dateFormat : 'yy/mm/dd'});
        }

              function getCHK(elem)
              {
                var CHKID = $(elem).val();
                var dataString = { CHKID:CHKID };
         $.ajax({
                  type: "POST",
                  url: "getRECIPT",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //var  data1 = JSON.stringify(html[0]); 
                     //alert(html);
                     data1 = JSON.parse(html)
                     var Amt = data1[0].Amt;
                     var CAmt = addCommas(Amt);
                     $('#TAMT').val(Amt);
                     //$('#rDCredit').html(CAmt);
                     $('#rDDebit').html(CAmt);
                    // $('#CRBal').html(CAmt);
                     $('#DBBal').html(CAmt);
                     


                     //alert(Purpose);
                     var TDate = data1[0].TDate;
                     $('#transactiondate').val(TDate);

                    
                  }
              });
        
              }
            </script>
		  
		   
		  
		  <div class="form-group has-feedback col-md-3">
                    <label>Transaction Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control datep" readonly name="transactiondate" id="transactiondate" placeholder="Click to set date" required />
                    </div><!-- /.input group -->
          </div>

         <div class="form-group has-feedback col-md-3">
                 
                    <label>Received By:</label>
                   <div class="input-group">
                      <div class="input-group-addon" onclick="AddRec()" style="background-color: green; color:#FFF">
                        <i title="Add New Receiver" class="fa fa-plus"></i>
                      </div>
                      <select class="form-control srcselect" name="RECEIVER" id="RECEIVER">
                        <?php echo $OptStaff; ?>
                      </select>
                    </div><!-- /.input group -->
                   
          </div>

         <script type="text/javascript">
            $('.srcselect').select2();
         </script>

          <div class="form-group has-feedback col-md-2">
            <label>Currency:</label>
           <select class="form-control" onchange="setFOREX(this)" name="TCurr" id="TCurr">
            <option value="">--</option>
            <?php echo $CurrOpt; ?>
           </select>
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>Total Amount:</label>
           <input type="text" class="form-control" name="TAMT" id="TAMT" onKeyPress="return isNumber(event)" readonly="" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback col-md-3">
            <label>NGN To Curreny  rate:</label>
           <input type="text" class="form-control" name="NGNTCURR" id="NGNTCURR" onKeyPress="return isNumber(event)" />
            <span class="glyphicon glyphicon-cash form-control-feedback"></span>
          </div>

		

          <input type="hidden" id="payerDECV" name="payerDECV" />
                     <input type="hidden" id="receiveDECV" name="receiveDECV" />
                     <input type="hidden" name="TAmt" value="" />
                     <input type="hidden" name="REQCODE" value="" />
		  
  </div><!-- /.col -->
  
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
              
              </div><!-- /.box -->
              <!-- Transaction Table -->
         
                <div class="col-md-12">
              <div class="box box-warning collapsed-box">
                <div class="box-header with-border">
                  <center><h4> BANK RECIEPT AND OTHER RECIEPT </h4></center> 
                   <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                 
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">

                      <div class="col-md-6" style="background-color: #FFFFB7">
                        <div class="form-group col-md-12">
                          <br/>
                          <label>Crediting GL Account: </label>
                          <select class="srcselect3 form-control" style="width: 100%" id="DBGL" name="DBGL" required ><option value=""> --- </option><?php echo $GLOpt; ?></select>
                        </div> 
                        
                        <div class="form-group has-feedback col-md-12">
                          <label>Revenue/Cost Center:</label>
                          <select class="form-control" id="BusUnit" name="BusUnit" required >
                          <option value=""> --- </option>
                          <?php echo $RecDiv; ?>
                          </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
                        </div>
                         <div class="form-group has-feedback col-md-12">
                          <label>Equipment:</label>
                          <select class="form-control" id="EquipC" name="EquipC"  >
                          <option value="">-- </option>
                          <?php echo $EquipOpt; ?>
                          </select> <span class="glyphicon glyphicon-download form-control-feedback"></span>
                        </div>
                      </div>

                      <div class="col-md-6" style="background-color: #FFFFB7">
                        <br/>
                        <div class="form-group col-md-12">
                          <button type="button" class="btn btn-warning" onclick="addLI()"> Add Item </button>
                        </div>
                        <div class="form-group col-md-12">
                         
                          &nbsp;
                        </div>
                        <div class="form-group col-md-12">
                          <label>Select Customer: </label>
                          <select class="srcselect3 form-control" style="width: 100%" id="VEND" name="VEND" required ><option value=""> --- </option><?php echo $SupOpt; ?></select>
                        </div> 
                        <div class="form-group col-md-12">
                          <!--<button type="button" class="btn btn-success" onclick="addLICHS()"> Add Item From Cash Requisition </button>-->
                           <button type="button" class="btn btn-primary" onclick="addLIVEN()"> Add Item From Invoice To Customer </button>
                        </div>

                        
                        
                         <script type="text/javascript">
                          $('.srcselect3').select2();
                       </script> 
                        
                 
                      </div>
                    </div>
                  </div>
                
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
              <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header">
                 <center><h3>Transaction Table</h3></center>
                </div><!-- /.box-header -->
                <div class="box-body">
                  
                     <table id="EntryChart" class="table table-bordered table-striped">
                     <thead>
                     <tr><th>Description</th><th>GL Impacting</th><th>Debit </th><th>Credit</th></tr> 
                     </thead>

                      <tbody>
                      <tr>
                      <td id="payerDEC">-</td>
                      <td id="payerGL">-</td>
                      <td id="rDDebit">0.00</td>
                      <td id="rDCredit">0.00</td>
                      </tr>
                     
                     <tr style="border-top: 1px solid #000; border-style: double; border-left: 0px solid; border-right: 0px solid;">
                          <th> &nbsp; </th> 
                          <th> &nbsp; </th> 
                          <th><span id="DBBal">0.00</span></th> 
                          <th><span id="CRBal">0.00</span></th>
                          </tr>
                      </tbody>

                     </table>
                     <button type="button" onclick="setToPost();" class="btn btn-success pull-right">POST</button>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </div>
       

            </div><!-- /.col -->
          </div><!-- /.row -->
        </form>
	
	
		
		
		
		
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
          $(".datep").datepicker({dateFormat : 'yy/mm/dd'});
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
      
      
        var BANKGL = $('#BANKGL').val();
        if(BANKGL == "") { alert("Kindly select Bank Account. Thanks"); return false; }

        var ChqNo = $('#ChqNo').val();
        if(ChqNo == "") { alert("Kindly select Reciept Number. Thanks"); return false; }

        var transactiondate = $('#transactiondate').val();
        if(transactiondate == "") { alert("Kindly select Transaction Date. Thanks"); return false; }


        var RECEIVER = $('#RECEIVER').val();
        if(RECEIVER == "") { alert("Kindly select Receiver. Thanks"); return false; }

        var TCurr = $('#TCurr').val();
        if(TCurr == "") { alert("Kindly select Currency. Thanks"); return false; }

        var DBGL = $('#DBGL').val();
        if(DBGL == "") { alert("Kindly select GL Account. Thanks"); return false; }

         var BusUnit = $('#BusUnit').val();
        if(BusUnit == "") { alert("Kindly select Revenue/Cost Center. Thanks"); return false; }

        
        /*
        





        */
        var UOMOpt = '<?php echo $UOMOpt; ?>';
          var size='standart';
                  var content = '<form role="form" enctype="multipart/form-data" ><div class="form-group">' +
                  
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Item Description: </label><textarea class="form-control" id="nItemDesc"  name="ItemDesc" required ></textarea></div>' +

                    '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control"  name="ItemUnit" id="nItemUnit" >'+UOMOpt+'</select></div>' +

                   
                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Quantity: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitQty" onInput="chkIT()" name="UnitQty" required ></div>' +

                      '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nUnitPrice" onInput="chkIT()" name="UnitPrice" required ></div>' +


                     '<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="nTotalPrice"  name="TotalPrice" readonly ></div>' +
                   

                   '<button type="button" onclick="addBD()" class="btn btn-success pull-right">Add Item</button><br/></form>';
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

                   '<button type="button" onclick="addBD()" class="btn btn-success pull-right">Add Item</button><br/></form>';
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
      function addLIVEN()
      {
         var ReQOpt = '<?php echo $ReQOpt ?>';

          var BANKGL = $('#BANKGL').val();
        if(BANKGL == "") { alert("Kindly select Bank Account. Thanks"); return false; }

        var ChqNo = $('#ChqNo').val();
        if(ChqNo == "") { alert("Kindly select Reciept Number. Thanks"); return false; }

        var transactiondate = $('#transactiondate').val();
        if(transactiondate == "") { alert("Kindly select Transaction Date. Thanks"); return false; }


        var RECEIVER = $('#RECEIVER').val();
        if(RECEIVER == "") { alert("Kindly select Receiver. Thanks"); return false; }

        var TCurr = $('#TCurr').val();
        if(TCurr == "") { alert("Kindly select Currency. Thanks"); return false; }

        var DBGL = $('#DBGL').val();
        var DBGLt = $('#DBGL :selected').text();
        
        if(DBGL == "") { alert("Kindly select GL Account. Thanks"); return false; }

        

        var VEND = $('#VEND').val();
        
        if(VEND == "") { alert("Kindly select Customer. Thanks"); return false; }
        
         var BusUnit = $('#BusUnit').val();
        if(BusUnit == "") { alert("Kindly select Revenue/Cost Center. Thanks"); return false; }


        // Get Invoices tired to this customer

        var dataString = { VEND:VEND };
         $.ajax({
                  type: "POST",
                  url: "getENLINVInfo",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     
                     //data1 = JSON.parse(html)
                     //var Purpose = data1[0].Purpose;
                     //alert(html);
                     $('#VenInv').html(html);
                     
                  }
              });
        /////////////////////////////////////////////////////////////


         var size='standart';
                  var content = '<div class="row" style="background:#EEE6E6; border-radius:5px;" > <div class="col-md-12"><form role="form" ><div class="form-group">' +
                    '<input id="INVID" name="INVID" type="hidden" />'+
                    '<div class="form-group col-md-6"><label>Select ENL Invoice: </label><select class="form-control" onchange="setInvItems(this)" id="VenInv" name="VenInv" required ><option value=""> --- </option>'
                    +'</select></div>' +

                    '<div class="form-group col-md-6"><label>Select Invoice Item: </label><select class="form-control" onchange="getINVItemInfo()"  name="INVItem" id="INVItem" ></select></div>' +

                   '<div class="form-group col-md-12"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" id="INVItemDesc" required readonly ></textarea></div>' +
                   '<div class="form-group col-md-6"><label>Item Quantity: </label><input type="text" oninput="compTotalINV()" onKeyPress="return isNumber(event)" class="form-control" id="INVUnitQty"  name="UnitQty" required ></div>' +

                      '<div class="form-group col-md-6"><label>Item Unit Price: </label><input type="text" oninput="compTotalINV()" onKeyPress="return isNumber(event)" class="form-control" id="INVUnitPrice"  name="UnitPrice" required ></div>' +


                     '<div class="form-group col-md-6"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="INVTotalPrice"  name="TotalPrice" readonly ></div>' +
                     
                   '<button type="button" onclick="addBDINV()" class="btn btn-success pull-right">Add Item</button><br/></form></div></div>';
                  var title = 'ENL Invoice Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

      function setInvItems(elem)
      {
        var INVID = $(elem).val();
        var dataString = { INVID:INVID };
         $.ajax({
                  type: "POST",
                  url: "getENLINVItems",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                    
                     $('#INVItem').html("<option value=''> -- </option>").append(html);
                  }
              });
      }
      function addLICHS()
      {
      
        var GLOpt = '<?php echo $GLOpt; ?>';
        var UOMOpt = '<?php echo $UOMOpt; ?>';
        var ReQOpt = '<?php echo $ReQOpt ?>';
        var DBGL = $('#DBGL').val();

        var BANKGL = $('#BANKGL').val();
        if(BANKGL == "") { alert("Kindly select Bank Account. Thanks"); return false; }

        var ChqNo = $('#ChqNo').val();
        if(ChqNo == "") { alert("Kindly select Reciept Number. Thanks"); return false; }

        var transactiondate = $('#transactiondate').val();
        if(transactiondate == "") { alert("Kindly select Transaction Date. Thanks"); return false; }


        var RECEIVER = $('#RECEIVER').val();
        if(RECEIVER == "") { alert("Kindly select Receiver. Thanks"); return false; }

        var TCurr = $('#TCurr').val();
        if(TCurr == "") { alert("Kindly select Currency. Thanks"); return false; }

        var DBGL = $('#DBGL').val();
        var DBGLt = $('#DBGL :selected').text();
        
        if(DBGL == "") { alert("Kindly select GL Account. Thanks"); return false; }
        
         var BusUnit = $('#BusUnit').val();
        if(BusUnit == "") { alert("Kindly select Revenue/Cost Center. Thanks"); return false; }
          var size='standart';
                  var content = '<div class="row" style="background:#EEE6E6; border-radius:5px;" > <div class="col-md-12"><form role="form" ><div class="form-group">' +
                    '<input id="CHRID" name="CHRID" type="hidden" />'+
                    '<div class="form-group col-md-6"><label>Select Cash Req.: </label><select class="form-control" onchange="setCHSItem(this)" id="CHRNum" name="CHRNum" required ><option value=""> --- </option>'+ReQOpt+'</select></div>' +

                    '<div class="form-group col-md-6"><label>Select Cash Req. Item: </label><select class="form-control" onchange="getCHSItemInfo()"  name="CHSItem" id="CHSItem" ></select></div>' +

                   '<div class="form-group col-md-12"><label>Item Description: </label><textarea class="form-control"  name="ItemDesc" id="CHSItemDesc" required readonly ></textarea></div>' +

                    /*'<div class="form-group" style="width:45%; display: inline-block; margin: 6px"><label>Item Unit: </label><select class="form-control" id="CHSItemUnit"  name="ItemUnit"  >'+UOMOpt+'</select></div>' +
                    */

                   
                     '<div class="form-group col-md-6"><label>Item Quantity: </label><input type="text" oninput="compTotal()" onKeyPress="return isNumber(event)" class="form-control" id="CHSUnitQty"  name="UnitQty" required ></div>' +

                      '<div class="form-group col-md-6"><label>Item Unit Price: </label><input type="text" oninput="compTotal()" onKeyPress="return isNumber(event)" class="form-control" id="CHSUnitPrice"  name="UnitPrice" required ></div>' +


                     '<div class="form-group col-md-6"><label>Total Price: </label><input type="text" onKeyPress="return isNumber(event)" class="form-control" id="CHSTotalPrice"  name="TotalPrice" readonly ></div>' +
                   
                     
                   '<button type="button" onclick="addBDCHS()" class="btn btn-success pull-right">Add Item</button><br/></form></div></div>';
                  var title = 'Cash Req. Item Details';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
                  /* $('.srcselect2').select2({
                         dropdownParent: $('#myModal')
                      });
                      */
                 
                  setCHSItem();

                  
                  
      }
      
      function compTotal()
      {
          var PDFUnitPrice = $('#CHSUnitPrice').val();
           var PDFUnitQty = $('#CHSUnitQty').val();
           var TotalPricePDF = Number(PDFUnitPrice) * Number(PDFUnitQty);
           $('#CHSTotalPrice').val(TotalPricePDF);
      }

      function compTotalINV()
      {
          var PDFUnitPrice = $('#INVUnitPrice').val();
           var PDFUnitQty = $('#INVUnitQty').val();
           var TotalPricePDF = Number(PDFUnitPrice) * Number(PDFUnitQty);
           $('#INVTotalPrice').val(TotalPricePDF);
      }

      
      function setCHSItem()
      {
        var CHRCODE = $('#CHRNum').val();
        var dataString = { CHRCODE:CHRCODE };
         $.ajax({
                  type: "POST",
                  url: "getCHRItems",
                  data: dataString,
                  cache: false,
                  success: function(html)
                  {
                     //ItemD = html;
                     //alert(ItemD); 
                     //alert(html);
                     $('#CHSItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }


          function getINVItemInfo()
      {
        var INVItem = $('#INVItem').val();
        var dataString = { INVItem:INVItem };
         $.ajax({
                  type: "POST",
                  url: "getENLINVItemInfo",
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
                     var PONo = data1[0].PONo;
                     $('#INVID').val(PONo);

                    var ItemDes = data1[0].description;
                     $('#INVItemDesc').html(ItemDes); //alert(ItemDes);

                     var Amount = data1[0].unitprice;
                     $('#INVUnitPrice').val(Amount);

                     var Qty = data1[0].qty;
                     if(Qty == 0) { Qty = 1; }
                     $('#INVUnitQty').val(Qty);

                     var TotalPrice = Number(Qty) * Number(Amount);
                     $('#INVTotalPrice').val(TotalPrice);
                     //$('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }

        function getCHSItemInfo()
      {
        var CHSItem = $('#CHSItem').val();
        var dataString = { CHSItem:CHSItem };
         $.ajax({
                  type: "POST",
                  url: "getCHRItemInfo",
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
                     var RequestID = data1[0].RequestID;
                     $('#CHRID').val(RequestID);

                    var ItemDes = data1[0].ItemDes;
                     $('#CHSItemDesc').html(ItemDes);//alert(ItemDes);

                     var Amount = data1[0].Amount;
                     $('#CHSUnitPrice').val(Amount);

                     var Qty = data1[0].Qty;
                     if(Qty == 0) { Qty = 1; }
                     $('#CHSUnitQty').val(Qty);

                     var TotalPrice = Number(Qty) * Number(Amount);
                     $('#CHSTotalPrice').val(TotalPrice);
                     //$('#PDFItem').html("<option value=''> -- </option>").append(html);
                  }
              });
        }
    </script>

    <script type="text/javascript">
     function loadChk(elem)
     {
        var BNKID = $(elem).val();
        //alert(BNKID);
        var dataString = {BNKID:BNKID};
        $.ajax({
            type: "POST",
            url: "../accounts/setRECIEPTS",
            data: dataString,
            cache: false,
            success: function(html)
            {
                  $('#ChqNo').html(html);
            },
            error: function(a,b,c)
            {
              //alert(c);
            }
          });


     }

     function setToPost()
     {
       var FBAL = getBal();
       var BANKGL = $('#BANKGL').val(); 
       var ChqNo = $('#ChqNo').val(); 
       var RECEIVER = $('#RECEIVER').val(); 
       //var BusUnit = $('#BusUnit').val(); 
       var transactiondate = $('#transactiondate').val(); 
       var TCurr = $('#TCurr').val(); 
       //var remark = $('#remark').val(); 
       if(BANKGL == "") { alert("Oops! Kindly Select Bank Account"); return false; }
       if(ChqNo == "") { alert("Oops! Kindly Enter Cheque No./Ref No."); return false; }
       if(RECEIVER == "") { alert("Oops! Kindly Select the receiving personnel"); return false; }
       //if(BusUnit == "") { alert("Oops! Kindly Select the Business Unit"); return false; }
       if(transactiondate == "") { alert("Oops! Kindly Select the Transaction Date"); return false; }
       if(TCurr == "") { alert("Oops! Kindly Select the Currency"); return false; }
       //if(remark == "") { alert("Oops! Kindly enter your remark"); return false; }
       if(FBAL != 0) { alert("Oops! Your Table is not balanced"); return false; }
       $('#postPetty').submit();

     }

     function addCommas(nStr)
      {
          nStr += '';
          x = nStr.split('.');
          x1 = x[0];
          x2 = x.length > 1 ? '.' + x[1] : '';
          var rgx = /(\d+)(\d{3})/;
          while (rgx.test(x1)) {
              x1 = x1.replace(rgx, '$1' + ',' + '$2');
          }
          return x1 + x2;
      }

     function setDescription()
     {
        //var RECVGL = $('#RECVGL').find('option:selected').text() + ' :: ' + $('#RECEIVER').find('option:selected').text();
        var payerDEC = $('#BANKGL').find('option:selected').text();
        $('#payerDEC').html("Bank to be Debited");
        $('#payerGL').html(payerDEC);
        $('#payerDECV').val(payerDEC);
        //$('#rDDebit').html(RECVGL);
        //$('#receiveDECV').val(RECVGL);
     }
     
     
         function ADDCGL()
     {
        var sReqID = '<?php echo $sReqID ?>';
        var OptGLBank = '<?php echo $OptGLBank ?>'; 
        var GLOpt = '<?php echo $GLOpt ?>';  
        var CurOpt = '<?php echo $CurOpt ?>';  
        var BusOpt = '<?php echo $BusOpt ?>';  
        var RECVOpt = '<?php echo $RECVOpt ?>';  
        var TotalPayableVal = '<?php echo number_format($TAmt) ?>';
        var TotalPayable = '<?php echo $TAmt ?>';
        var GBaL = getBal();
        
          var size='standart';
                  var content = '<form role="form" >'+
                  '<div class="row">'+
                  '<div class="col-md-12">'+
                     '<div class="form-group col-md-6">'+
                     '<label>Debiting GL Account: </label>'+
                     '<select class="form-control" id="DBGL" required >'+ 
                     GLOpt +
                     '</select>'+
                     '</div>' +

                     '<div class="form-group col-md-6">'+
                     '<label>Amount to Debit: </label>'+
                     '<input class="form-control" id="DBNUM" onKeyPress="return isNumber(event)" name="DBNUM" value="'+GBaL+'" required >'+ 
                     '</div>' +

                    

                  

                      '<div class="form-group col-md-2 pull-right">'+
                    
                     '<button type="button" onclick="addBD()" class="btn btn-success form-control">Add</button>'+
                     '</div>' +


                     '<div class="form-group col-md-12">'+
                     '<br/>'+
                   
                    
                     '</div>' +
                  '</div>'+
                  '</div>'+
                                 
                   '</form>';

                  var title = 'Add GL to Debit on Cash Request :: ' + sReqID;
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox1(title,content,footer,size);
                  $('#myModal1').modal('show');
                 
                 
                   
     }

      function addBDINV()
     {

          event.preventDefault();
         var DBGL = $('#DBGL').val();
         var DBGLt = $('#DBGL :selected').text();
         var DBNUM = $('#DBNUM').val();
         //////////////////////////////////////////////////////////////////////////
        var BANKGL = $('#BANKGL').val();
        var ChqNo = $('#ChqNo').val();
        var transactiondate = $('#transactiondate').val();
        var RECEIVER = $('#RECEIVER').val();
        var TCurr = $('#TCurr').val();
        var DBGL = $('#DBGL').val();
        var DBGLt = $('#DBGL :selected').text();
        var BusUnit = $('#BusUnit').val();
        var EquipC = $('#EquipC').val();

        ////////////////////////////////////////////////////////////
        var CHRID = $('#INVID').val(); if(CHRID == "") { alert("Kindly select Customer"); return false; }
       
        var CHRNum = $('#VenInv').val(); if(CHRNum == "") { alert("Kindly select ENL Invoice to this Vendor"); return false; }

        var CHSItem = $('#INVItem').val(); if(CHSItem == "") { alert("Kindly select Invoice Item"); return false; }

        var CHSItemDesc = $('#INVItemDesc').val(); if(CHSItemDesc == "") { alert("Kindly enter Description"); return false; }

        var CHSUnitQty = $('#INVUnitQty').val(); if(CHSUnitQty == "") { alert("Kindly enter Invoice item Quantity"); return false; }

        var CHSUnitPrice = $('#INVUnitPrice').val(); if(CHSUnitPrice == "") { alert("Kindly enter Invoice Item Amount"); return false; }

        var CHSTotalPrice = $('#INVTotalPrice').val(); if(CHSTotalPrice == "") { alert("Kindly enter Invoice Item Amount"); return false; }
         /////////////////////////////////////////////////////////////////////////////
         //Here we have to chk how qualified the entry is
         var FBALDiff = getBal();
         if(Number(FBALDiff) < Number(CHSTotalPrice) )
          { alert('Credit Amount must balance on table'); return false; }

          if( 0 == Number(CHSTotalPrice) )
          { alert('Credit Amount must not be zero'); return false; }

          var TRow =   '<tr>'+
                     '<td class="receiveDEC">'+
                    CHSItemDesc+
                     '</td>'+

                     '<td class="receiveGL">'+
                      '<input type="hidden" name="DrDesc[]" value="'+DBGLt+'@&@'+DBGL+'@&@'+CHSTotalPrice+'@&@'+BusUnit+'@&@'+EquipC+'@&@'+CHSItemDesc+'@&@'+CHSUnitQty+'@&@'+CHRNum+'@&@'+CHSItem+'@&@VENDINV@&@'+CHRID+'" />'+
                     DBGLt+
                     '</td>'+
                     
                     '<td>0.00</td>'+
                     '<td class="pDDebit" amt="'+CHSTotalPrice+'">'+addCommas(CHSTotalPrice)+'</td>'+

                     '<td><i onclick="$(this).closest(\'tr\').remove(); resetBal();" class="fa fa-trash text-red"></i></td>'+
             '</tr>';

             /*
             <td id="payerDEC">-</td>
                      <td id="payerGL">-</td>
                      <td id="rDDebit">0.00</td>
                      <td id="rDCredit">0.00</td>
             */
              $('#myModal').modal('hide');
             $('#EntryChart tbody').prepend(TRow);
             resetBal();

             
             
     }

      function addBDCHS()
     {

          event.preventDefault();
         var DBGL = $('#DBGL').val();
         var DBGLt = $('#DBGL :selected').text();
         var DBNUM = $('#DBNUM').val();
         //////////////////////////////////////////////////////////////////////////
        var BANKGL = $('#BANKGL').val();
        var ChqNo = $('#ChqNo').val();
        var transactiondate = $('#transactiondate').val();
        var RECEIVER = $('#RECEIVER').val();
        var TCurr = $('#TCurr').val();
        var DBGL = $('#DBGL').val();
        var DBGLt = $('#DBGL :selected').text();
        var BusUnit = $('#BusUnit').val();
        var EquipC = $('#EquipC').val();

        ////////////////////////////////////////////////////////////
        var CHRID = $('#CHRID').val(); if(CHRID == "") { alert("Kindly select Cash Request Code"); return false; }
       
        var CHRNum = $('#CHRNum').val(); if(CHRNum == "") { alert("Kindly select Cash Request Code"); return false; }

        var CHSItem = $('#CHSItem').val(); if(CHSItem == "") { alert("Kindly select Cash Item"); return false; }

        var CHSItemDesc = $('#CHSItemDesc').val(); if(CHSItemDesc == "") { alert("Kindly enter Cash Description"); return false; }

        var CHSUnitQty = $('#CHSUnitQty').val(); if(CHSUnitQty == "") { alert("Kindly enter Cash Quantity"); return false; }

        var CHSUnitPrice = $('#CHSUnitPrice').val(); if(CHSUnitPrice == "") { alert("Kindly enter Cash Amount"); return false; }

        var CHSTotalPrice = $('#CHSTotalPrice').val(); if(CHSTotalPrice == "") { alert("Kindly enter Cash Amount"); return false; }
         /////////////////////////////////////////////////////////////////////////////
         //Here we have to chk how qualified the entry is
         var FBALDiff = getBal();
         if(Number(FBALDiff) < Number(CHSTotalPrice) )
          { alert('Debit Amount must balance on table'); return false; }

          if( 0 == Number(CHSTotalPrice) )
          { alert('Debit Amount must not be zero'); return false; }

          var TRow =   '<tr>'+
                     '<td class="receiveDEC">'+
                    CHSItemDesc+
                     '</td>'+

                     '<td class="receiveGL">'+
                      '<input type="hidden" name="DrDesc[]" value="'+DBGLt+'@&@'+DBGL+'@&@'+CHSTotalPrice+'@&@'+BusUnit+'@&@'+EquipC+'@&@'+CHSItemDesc+'@&@'+CHSUnitQty+'@&@'+CHRNum+'@&@'+CHSItem+'@&@CASHR@&@'+CHRID+'" />'+
                     DBGLt+
                     '</td>'+
                     
                     '<td class="pDDebit" amt="'+CHSTotalPrice+'">'+addCommas(CHSTotalPrice)+'</td>'+
                     '<td>0.00</td>'+
                     '<td><i onclick="$(this).closest(\'tr\').remove(); resetBal();" class="fa fa-trash text-red"></i></td>'+
             '</tr>';

             /*
             <td id="payerDEC">-</td>
                      <td id="payerGL">-</td>
                      <td id="rDDebit">0.00</td>
                      <td id="rDCredit">0.00</td>
             */
              $('#myModal').modal('hide');
             $('#EntryChart tbody').prepend(TRow);
             resetBal();

             
             
     }
     
     function addBD()
     {

          event.preventDefault();
         var DBGL = $('#DBGL').val();
         var DBGLt = $('#DBGL :selected').text();
         var BusUnit = $('#BusUnit').val();
         var EquipC = $('#EquipC').val();
         var DBNUM = $('#nTotalPrice').val();
        var CHRNum = "";
        var CHRItem = "";
        var CHRID = 0;
         ///////////////////////////////////////////////////////////
         var CHSItemDesc = $('#nItemDesc').val(); if(CHSItemDesc == "") { alert("Kindly enter Cash Description"); return false; }

        var CHSUnitQty = $('#nUnitQty').val(); if(CHSUnitQty == "") { alert("Kindly enter Cash Quantity"); return false; }

        var CHSUnitPrice = $('#nUnitPrice').val(); if(CHSUnitPrice == "") { alert("Kindly enter Cash Amount"); return false; }

        var CHSTotalPrice = $('#nTotalPrice').val(); if(CHSTotalPrice == "") { alert("Kindly enter Cash Amount"); return false; }
         ////////////////////////////////////////////////////////////
         //Here we have to chk how qualified the entry is
         var FBALDiff = getBal();
         if(Number(FBALDiff) < Number(DBNUM) )
          { alert('Credit Amount must balance on table'); return false; }

          if( 0 == Number(DBNUM) )
          { alert('Credit Amount must not be zero'); return false; }

          var TRow =   '<tr>'+
                     '<td class="receiveDEC">'+
                     CHSItemDesc+
                     '</td>'+

                     '<td class="receiveGL">'+
                      '<input type="hidden" name="DrDesc[]" value="'+DBGLt+'@&@'+DBGL+'@&@'+DBNUM+'@&@'+BusUnit+'@&@'+EquipC+'@&@'+CHSItemDesc+'@&@'+CHSUnitQty+'@&@'+CHRNum+'@&@'+CHRItem+'@&@JITEM@&@'+CHRID+'" />'+
                     DBGLt+
                     '</td>'+
                     
                     '<td>0.00</td>'+
                     '<td class="pDDebit" amt="'+DBNUM+'">'+addCommas(DBNUM)+'</td>'+

                     '<td><i onclick="$(this).closest(\'tr\').remove(); resetBal();" class="fa fa-trash text-red"></i></td>'+
             '</tr>';
              $('#myModal').modal('hide');
             $('#EntryChart tbody').prepend(TRow);
             resetBal();

             
             
     }

     function resetBal()
     {
      var TB = 0.0;
       
       $('.pDDebit').each(function() {
            var amt = $(this).attr("amt");
            TB = TB + Number(amt);
            //alert(TB)
        });

       var finalFig = addCommas(TB);
       //alert("God is so Loving");
        $('#CRBal').html(finalFig);
     }

     function getBal()
     {
       var CRBal = $('#CRBal').html().replace(',', '');
       CRBal = CRBal.replace(',', '');
       CRBal = CRBal.replace(',', '');
       var CRBaln = Number(CRBal);

       var DBBal = $('#DBBal').html().replace(',', '');
       DBBal = DBBal.replace(',', '');
       DBBal = DBBal.replace(',', '');
       var DBBaln = Number(DBBal);
       
       return  DBBaln - CRBaln;
     }
    </script>
  
	
  </body>
</html>