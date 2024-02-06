<?php
ini_set("display_errors", "on");
session_start();
//error_reporting(0);
ini_set('memory_limit', '-1');
include ('../DBcon/db_config.php');
require_once('../Classes/PHPExcel.php');
include('../Classes/PHPExcel/IOFactory.php');


$noRow = $_POST["RowNo"];
//echo $file = $_FILES['ExcelFile']['name']; exit;
//echo $file = $_FILES['ExcelFile']['tmp_name']; exit;

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["ExcelFile"]["name"]);



if(isset($_FILES["ExcelFile"]) && ($noRow > 1) )
{

    // Check file size
      if ($_FILES["ExcelFile"]["size"] > 5000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0; exit;
      }
  //Use whatever path to an Excel file you need.
  //$inputFileName =  $_FILES['ExcelFile']['tmp_name'];//'test.xls';
  //Move file to Server now
  if (move_uploaded_file($_FILES["ExcelFile"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["ExcelFile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }


  //Use whatever path to an Excel file you need.
  $inputFileName =  $target_file;//'test.xls';
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();

for ($row = 1; $row <= $noRow; $row++) {  //$highestRow
  //echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, 2)->getValue();
 $itemNo = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
 $martNo = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
 $Desp = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
 $Qty = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue();
 $UOM = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue();
 $OEMPrice = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue();
 $FinalPRice = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue();;
 $CusPO = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue();
 $OEM = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue();

 if(chkMartNo($MertNo) == "NO") {
  $sql = "INSERT INTO historylineitem (itno, martno, desp, qty, uom, OEMPrice, FinalPRice, CusPO, OEM)
  VALUES ('$itemNo', '$martNo', '$Desp','$Qty', '$UOM', '$OEMPrice','$FinalPRice','$CusPO','$OEM')";

  $result = mysql_query($sql);
  
  }

  
}

      if (!$result)
      {
      echo mysql_error();
      /*$_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
      header('Location: rpor');*/

      $_SESSION['ErrMsg'] = "Connection to Data Pool Error!";
      header('Location: bulkupload');
      exit;
      }
      else
      {
      /*$_SESSION['ErrMsgB'] = "PO Request Made!";
      header('Location: rpor');*/
      $_SESSION['ErrMsgB'] = "Reported!";
      header('Location: bulkupload');

      exit;
      }

}

function chkMartNo($MertNo)
{
      $resultHLine = mysql_query("SELECT * FROM historylineitem Where martno='$MertNo'");
      $resultHLineNo = mysql_num_rows($resultHLine);
     
      if ($resultHLineNo > 0) 
      {
          return "YES";
      }

      $resultHLineN = mysql_query("SELECT * FROM  lineitems Where MatSer='$MertNo'");
      $resultHLineNNo = mysql_num_rows($resultHLineN);
     
      if ($resultHLineNNo > 0) 
      {
          return "YES";
      }
      else
      {
          return "NO";
      }
}
//close the connection
mysql_close($dbhandle);
 
?>		 
