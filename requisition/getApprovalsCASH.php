
<?php


     function getStatus($Approved)
     {
			     if ($Approved == 0) 
			      {
			        $ApprovedN = "Raised";
			      }
			      else if ($Approved == 1)
			      {
			        $ApprovedN = "Pending with Supervisor of Department";
			      }
			      else if ($Approved == 2)
			      {
			        $ApprovedN = "Pending with Head of Department";
			      }
			      else if ($Approved == 3)
			      {
			        $ApprovedN = "Pending with Head of Divison";
			      }
			      else if ($Approved == 4) //Skip for Depts under coporate services
			      {
			        $ApprovedN = "Pending with your General Manager";
			      }
			       else if ($Approved == 5) //For only Material Request
			      {
			        $ApprovedN = "Pending with Contracts and Procurement";
			      }

			      else if ($Approved == 6) //For only Material Request
			      {
			        $ApprovedN = "Pending with GM Coporate Service";
			      }

			       else if ($Approved == 7)
			      {
			        $ApprovedN = "Pending with Due Diligence Officer";
			      }

			       else if ($Approved == 8)
			      {
			           $ApprovedN = "Pending with Mgr Internal/Ctrl";
			       // $ApprovedN = "Pending with Mgr Due Diligence";
			      }
			      
			         else if ($Approved == 18)
			      {
			           $ApprovedN = "Pending with COO";
			    
			      }

			       else if ($Approved == 9)
			      {
			        $ApprovedN = "Pending with MD";
			      }
			       else if ($Approved == 10) //Only for material request
			      {
			        $ApprovedN = "Pending with Due Diligence";
			      }
			      else if ($Approved == 11)
			      {
			        $ApprovedN = "Pending with Finance";
			      }
			      else if ($Approved == 12)
			      {
			        $ApprovedN = "Pending with Internal Audit";
			      }
			       else if ($Approved == 13)
			      {
			        $ApprovedN = "Approved";
			      }
			      else if ($Approved == 14)
			      {
			        $ApprovedN = "Keep in View";
			      }
			      else if ($Approved == 15)
			      {
			        $ApprovedN = "Cancelled";
			      }
			       else if ($Approved == 16)
			      {
			        $ApprovedN = "Processing Payment";
			      }
                  else if ($Approved == 17)
                  {
                    $ApprovedN = "Cash Released";
                  }

		return $ApprovedN;
     }


     function setHistory($ReqID)
     {  
     	$resultREQH = mysql_query("SELECT * FROM cashreq WHERE RequestID= '".$ReqID."' AND isActive=1");
        while ($row = mysql_fetch_array($resultREQH)) 
        {
       		 $UserApp = getUserinfo($row['UserApp']);
		     $UserAppDate = $row['UserAppDate'];
		     $UserAppComment = $row['UserAppComment'];

		     $SupervisorApp = getUserinfo($row['SupervisorApp']);
		     $SupervisorAppDate = $row['SupervisorAppDate'];
		     $SupervisorAppComment = $row['SupervisorComment'];

		     $DeptHeadApp = getUserinfo($row['DeptHeadApp']);
		     $DeptHeadAppDate = $row['DeptHeadAppDate'];
		     $DeptHeadAppComment = $row['DeptHeadAppComment'];

		     $DivHeadApp = getUserinfo($row['DivHeadApp']);
		     $DivHeadAppDate = $row['DivHeadAppDate'];
		     $DivHeadAppComment = $row['DivHeadAppComment'];

		     $CPApp = getUserinfo($row['CPApp']);
		     $CPAppDate = $row['CPAppDate'];
		     $CPAppComment = $row['CPAppComment'];

		     $MgrApp = getUserinfo($row['MgrApp']);
		     $MgrAppDate = $row['MgrAppDate'];
		     $MgrAppComment = $row['MgrAppComment'];

		     $CSApp = getUserinfo($row['CSApp']);
		     $CSAppDate = $row['CSAppDate'];
		     $CSAppComment = $row['CSAppComment'];


		     $DDOfficerApp = getUserinfo($row['DDOfficerApp']);
		     $DDOfficerAppDate = $row['DDOfficerAppDate'];
		     $DDOfficerAppComment = $row['DDOfficerAppComment'];

		     $DDApp = getUserinfo($row['DDApp']);
		     $DDAppDate = $row['DDAppDate'];
		     $DDAppComment = $row['DDAppComment'];

		     $MDApp = getUserinfo($row['MDApp']);
		     $MDAppDate = $row['MDAppDate'];
		     $MDAppComment = $row['MDComment'];
		     
		     $COOApp = getUserinfo($row['COOApp']);
             $COOAppDate = $row['COOAppDate'];
             $COOAppComment = $row['COOComment'];

		     $ApprovedBy = $row['ApprovedBy'];//
		     $LastActor = $row['LastActor'];//
        }

     	 $reqHistory .=	'<tbody>';

                   if($UserApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Requested by:</b> </td>
                        <td>'.$UserApp.'</td>
                    </tr>
                    <tr>
                        <td><b>Submitted On:</b> </td>
                        <td>'.$UserAppDate.'</td>
                    </tr>
                     <tr>
                        <td><b>Requester\'s Comment:</b> </td>
                        <td>'.$UserAppComment.'</td>
                    </tr>';
                   }
                 
                   if($SupervisorApp != "") { 
                    $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Supervisor of Department:</b> </td>
                        <td>'.$SupervisorApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Supervisor of Department Acted On:</b> </td>
                        <td>'.$SupervisorAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Supervisor of Department\'s Comment:</b> </td>
                        <td>'.$SupervisorAppComment.'</td>
                    </tr>';
                }
                  
                  if($DeptHeadApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Department:</b> </td>
                        <td>'.$DeptHeadApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Head of Department Acted On:</b> </td>
                        <td>'.$DeptHeadAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Head of Department\'s Comment:</b> </td>
                        <td>'.$DeptHeadAppComment.'</td>
                    </tr>';
                 }
                 if($DivHeadApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Head of Division:</b> </td>
                        <td>'.$DivHeadApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Head of Division Acted On:</b> </td>
                        <td>'.$DivHeadAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Head of Division\'s Comment:</b> </td>
                        <td>'.$DivHeadAppComment.'</td>
                    </tr> ';
                 
                }

                   if($CPApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>Contracts & Procurement:</b> </td>
                        <td>'.$CPApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Contracts & Procurement Acted On:</b> </td>
                        <td>'.$CPAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Contracts & Procurement\'s Comment:</b> </td>
                        <td>'.$CPAppComment.'</td>
                    </tr>';
                }

                if($CSApp != "") {  
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>


                    <tr>
                        <td><b>GM Coporate Services:</b> </td>
                        <td>'.$CSApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM Coporate Services Acted On:</b> </td>
                        <td>'.$CSAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM Coporate Services\'s Comment:</b> </td>
                        <td>'.$CSAppComment.'</td>
                    </tr>';
                }
                 
                 if($MgrApp != "") { 
                    $reqHistory .='<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>GM of Division:</b> </td>
                        <td>'.$MgrApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM of Division Acted On:</b> </td>
                        <td>'.$MgrAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM of Division\'s Comment:</b> </td>
                        <td>'.$MgrAppComment.'</td>
                    </tr>';
                }
                	if($DDOfficerApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Due Dilligence Officer:</b> </td>
                        <td>'.$DDOfficerApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Due Dilligence Officer Acted On:</b> </td>
                        <td>'.$DDOfficerAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Due Dilligence Officer\'s Comment:</b> </td>
                        <td>'.$DDOfficerAppComment.'</td>
                    </tr>';
                }

                   if($DDApp != "") { 
                   $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>

                    <tr>
                        <td><b>Internal Control:</b> </td>
                        <td>'.$DDApp.'</td>
                    </tr>
                     <tr>
                        <td><b>Internal Control Acted On:</b> </td>
                        <td>'.$DDAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>Internal Control\'s Comment:</b> </td>
                        <td>'.$DDAppComment.'</td>
                    </tr>';
                }
                
                if($COOApp != "") { 
                    $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>
                    <tr>
                        <td><b>COO:</b> </td>
                        <td>'.$COOApp.'</td>
                    </tr>
                     <tr>
                        <td><b>COO Acted On:</b> </td>
                        <td>'.$COOAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>COO\'s Comment:</b> </td>
                        <td>'.$COOAppComment.'</td>
                    </tr>';
                }


                    if($MDApp != "") { 
                    $reqHistory .= '<tr><td colspan="2" style="background: #00CC99"></td></tr>
                    <tr>
                        <td><b>MD:</b> </td>
                        <td>'.$MDApp.'</td>
                    </tr>
                     <tr>
                        <td><b>MD Acted On:</b> </td>
                        <td>'.$MDAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>MD\'s Comment:</b> </td>
                        <td>'.$MDAppComment.'</td>
                    </tr>';
                }

                   

                $reqHistory .= '</tbody>';

                return $reqHistory;
     }
?>
 