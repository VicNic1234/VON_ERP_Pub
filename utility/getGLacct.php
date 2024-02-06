<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];
$BusinessYr = $_SESSION['BusinessYear'];

$TRowArray = "";
//$CusID = mysql_real_escape_string(trim(strip_tags($_POST['CusID'])));

{
    $resultGLAccNum = mysql_query("SELECT * FROM acc_chart_master 
        LEFT JOIN acc_chart_types ON acc_chart_master.account_type = acc_chart_types.id  
        LEFT JOIN acc_chart_class ON acc_chart_types.class_id = acc_chart_class.cid  
        WHERE acc_chart_master.isActive = 1 ");
    $NoRowGLONo = mysql_num_rows($resultGLAccNum);
    if($NoRowGLONo > 0)
    {
        while ($row = mysql_fetch_array($resultGLAccNum))
        { 
            $Type = $row['cid'];
          if($Type == 3)
          {

            if($row['mid'] == 523)
                { 
                    $OptGLRevenue .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>';
                }
            else
                {
                    $OptGLRevenue .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>';
                }
          }
          if($Type == 1)
          { 
            if($row['mid'] == 506)
                { 
                    $OptGLTradeRev .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }
            else
                {
                   // $OptGLTradeRev .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }

                if($row['mid'] == 555)
                { 
                    $OptGLValueAddOP .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }
            else
                {
                   $OptGLValueAddOP .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }


          }
          if($Type == 2)
          {

            if($row['mid'] == 556)
                { 
                    $OptGLValueAdd .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }
            else
                {
                    $OptGLValueAdd .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>';
                }
          }
          if($Type == 4)
          {

            if($row['mid'] == 532)
                { 
                    $OptGLExpense .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>';

                }
            else
                {
                    $OptGLExpense .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>';
                }
          }

          if($row['mid'] == 532)
          { $OptGLInventory .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>'; }
          else { $OptGLInventory .= '<option value="'.$row['mid'].'">['.$row['account_code'].'] '.$row['account_name'].'</option>'; }
          
          //OptGLPayable
          if($row['mid'] == 516)
          { $OptGLPayable .= '<option value="'.$row['mid'].'" selected >['.$row['account_code'].'] '.$row['account_name'].'</option>'; }
         
        }
    }

    
}

$ACCDetails = array();
$ACCDetails['OptGLRevenue'] = $OptGLRevenue; 
$ACCDetails['OptGLTradeRev'] = $OptGLTradeRev; 
$ACCDetails['OptGLPayable'] = $OptGLPayable; 
$ACCDetails['OptGLValueAdd'] = $OptGLValueAdd; 
$ACCDetails['OptGLValueAddOP'] = $OptGLValueAddOP; 
$ACCDetails['OptGLExpense'] = $OptGLExpense; 
$ACCDetails['OptGLInventory'] = $OptGLInventory; 



echo json_encode($ACCDetails);


?>
