<?php

  //Had to change this path to point to IOFactory.php.
  //Do not change the contents of the PHPExcel-1.8 folder at all.
  include('../Classes/PHPExcel/IOFactory.php');

  //Use whatever path to an Excel file you need.
  $inputFileName = 'test.xls';

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
 /*
  for ($row = 1; $row <= $highestRow; $row++) { 
    //$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
    //CellRead


    //Prints out data in each row.
    //Replace this with whatever you want to do with the data.
    echo '<pre>';
      print_r($rowData);
    echo '</pre>';
  } */
 for ($row = 1; $row <= $highestRow; $row++) { 
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

  $sql = "INSERT INTO historylineitem (itno, martno, desp, qty, uom, OEMPrice, FinalPRice, CusPO, OEM)
  VALUES ('$itemNo', '$martNo', '$Desp','$Qty', '$UOM', '$OEMPrice','$FinalPRice','$CusPO','$OEM')";

  //$result = mysql_query($sql);

  
}
  ?>