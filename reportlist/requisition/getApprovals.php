<?php

function getDeptApprovals($DeptIDn,$MyID,$ApproveStatus)
     {
       
       	//$mySupervisor = array(); $HDept = array(); $HDiv = array();
       	$mySupervisor = 0; $myDeptH = 0; $myDivH = 0; $myGM = 0;

		$resultDeptHnSuperV = mysql_query("SELECT * FROM department");
        while ($row = mysql_fetch_array($resultDeptHnSuperV)) 
        {
         	if($row['id'] == $DeptIDn)
         	{
         	  if($row['supervisor'] > 0) { $mySupervisor = $row['supervisor']; }
	          if($row['hod'] > 0) { $myDeptH = $row['hod']; }
	          $DivIDmm = $row['DivID'];
         	}


         	if($row['id'] == 3)
         	{
	          if($row['hod'] > 0) { $myCPDeptH = $row['hod']; }
         	}

        }


        $resultGMnDivH = mysql_query("SELECT * FROM divisions");
        while ($row = mysql_fetch_array($resultGMnDivH)) 
        {
       		if($row['divid'] == 5) 
       		{
       		   if($row['GM'] > 0) { $myGMDD = $row['GM']; }
       		}
       		if($row['divid'] == 1) 
       		{
       		   if($row['GM'] > 0) { $myGMCS = $row['GM']; }
       		}
       		if($row['divid'] == $DivIDmm) 
       		{
	          if($row['GM'] > 0) { $myGM = $row['GM']; }
	          if($row['DH'] > 0) { $myDivH = $row['DH']; }
	        }
        }


        /*$resultGMnDivH = mysql_query("SELECT * FROM divisions WHERE divid='$DivIDmm'");
        while ($row = mysql_fetch_array($resultGMnDivH)) 
        {
       
          if($row['GM'] > 0) { $myGM = $row['GM']; }
          if($row['DH'] > 0) { $myDivH = $row['DH']; }
        }*/

        $Result['supervisor'] = $mySupervisor;
        $Result['hod'] = $myDeptH;
        $Result['DH'] = $myDivH;
        $Result['CPHOD'] = $myCPDeptH;
        $Result['GM'] = $myGM;
        $Result['GMCS'] = $myGMCS;
        $Result['GMDD'] = $myGMDD;

        return $Result;
     }

     function RequesterNextApproval($MyID, $mySupervisor, $myDeptH, $myDivH, $myCPDeptH, $myGM, $myGMCS, $myGMDD, $myDIV)
     {
     	//$dfd = getUserinfo($mySupervisor);
     	//Let's Set Next Approval ta RAISED
        if( 
        	$mySupervisor > 0 
	        && $MyID != $mySupervisor
	        && $MyID != $myDeptH
	        && $MyID != $myDivH
	        && $MyID != $myGM
	      ) //Chk Supervisor
        {
        	//$NextApproval = $mySupervisor;
        	return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOSupervisor('.$mySupervisor.', \'Requester\')" type="button"> Send to Supervisor | <i class="fa fa-send"></i></button>';
        }
        elseif(
        		 $myDeptH > 0
        	    && $MyID != $myDeptH
		        && $MyID != $myDivH
		        && $MyID != $myGM
              ) //Chk Head of Department
        	{
        		//$NextApproval = $myDeptH;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODeptH('.$myDeptH.', \'Requester\')" type="button"> Send to Head of Department | <i class="fa fa-send"></i></button>';

        	}
        elseif(
        		//$MyID == $myDeptH && 
            $myDivH > 0
		        && $MyID != $myDivH
		        && $MyID != $myGM
              ) //Chk Head of Division
        	{
        		//$NextApproval = $myDivH;
            if($myDIV == 1)
            {
              return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.', \'Requester\')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';
            }
            else
            {
              return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODivH('.$myDivH.',\'Requester\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>';
            }
        		
        	}
        elseif(
          //$MyID == $myDivH && 
            $myGM > 0
		        && $MyID != $myGM
              ) //Chk GM of Division
        	{
        		//$NextApproval = $myGM;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOGM('.$myGM.')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';
        	}
        elseif(
          $MyID == $myGM && 
          $MyID != $myCPDeptH
              ) //Chk GM of C&P Head
        	{
        		//$NextApproval = $myCPDeptH;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.', \'Requester\')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';
        	}
        elseif($MyID == $myCPDeptH) //Chk GM of Division
        	{
        		if($MyID == $myDivH)
        			{ 
        				//$NextApproval = $myGM;
        				return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOGM('.$myGM.')" type="button"> Send to my GM | <i class="fa fa-send"></i></button>'; 

        			}
        		else
        			{ 
        				//$NextApproval = $myDivH; 
        				return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODivH('.$myDivH.',\'Requester\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>';
        			}
        	}
        	
        	else
        	{
        	    	return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODivH('.$myDivH.',\'Requester\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>';
        	}



     }

     function SupervisorNextApproval($MyID, $mySupervisor, $myDeptH, $myDivH, $myCPDeptH, $myGM, $myGMCS, $myGMDD)
     {

     	if(
        		$MyID == $mySupervisor
        		&& $myDeptH > 0
        	    && $MyID != $myDeptH
		        && $MyID != $myDivH
		        && $MyID != $myGM
              ) //Chk Head of Department
        	{
        		//$NextApproval = $myDeptH;
        		return $NextApproval = '<button class="btn btn-success pull-right"  onclick="sendTODeptH('.$myDeptH.', \'Supervisor\')" type="button"> Send to Head of Department | <i class="fa fa-send"></i></button>
         <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';

        		

        	}
        elseif(
        		$MyID == $myDeptH
        		&& $myDivH > 0
		        && $MyID != $myDivH
		        && $MyID != $myGM
              ) //Chk Head of Division
        	{
        		//$NextApproval = $myDivH;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODivH('.$myDivH.',\'Supervisor\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>   <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        	}
        elseif($MyID == $myDivH
        		&& $myGM > 0
		        && $MyID != $myGM
              ) //Chk GM of Division
        	{
        		//$NextApproval = $myGM;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOGM('.$myGM.')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>     <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        	}
        elseif($MyID == $myGM
		        && $MyID != $myCPDeptH
              ) //Chk GM of C&P Head
        	{
        		//$NextApproval = $myCPDeptH;
        		return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button> <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        	}
        elseif($MyID == $myCPDeptH) //Chk GM of Division
        	{
        		if($MyID == $myDivH)
        			{ 
        				//$NextApproval = $myGM;
        				return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTOGM('.$myGM.')" type="button"> Send to my GM | <i class="fa fa-send"></i></button> <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>'; 

        			}
        		else
        			{ 
        				//$NextApproval = $myDivH; 
        				return $NextApproval = '<button class="btn btn-warning pull-right" onclick="sendTODivH('.$myDivH.',\'Supervisor\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button> <button class="btn btn-warning pull-left" onclick="sendBTOUser(\'Supervisor\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        			}
        	}



     }


     function HeadOfDeptNextApproval($MyID, $mySupervisor, $myDeptH, $myDivH, $myCPDeptH, $myGM, $myGMCS, $myGMDD, $DIVID)
     {

     	if(
        		$MyID == $myDeptH
        		&& $myDivH > 0
		        && $MyID != $myDivH
		        && $MyID != $myGM
              ) //Chk Head of Division
        	{
        		//$NextApproval = $myDivH;
        		if($DIVID == 1){
        		$NextApproval .= '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.', \'HOD\')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';
        		}
        		else{
        		$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTODivH('.$myDivH.', \'HOD\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>';
        		}

        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        		}
        		

        	}
        elseif($MyID == $myDivH
        		&& $myGM > 0
		        && $MyID != $myGM
              ) //Chk GM of Division
        	{

        		$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGM('.$myGM.', \'HOD\')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';

        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        		}
        	}
        elseif($MyID == $myGM
		        && $MyID != $myCPDeptH
              ) //Chk GM of C&P Head
        	{
        		
        		$NextApproval .= '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';

        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        		}
        	}
        elseif($MyID == $myCPDeptH) //Chk GM of Division
        	{
        		if($MyID == $myGMCS) //$myGMCS
        			{ 
        				//$NextApproval = $myGM;
        				$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGMCS('.$myGMCS.', \'HOD\')" type="button"> Send to GM Coporate services | <i class="fa fa-send"></i></button>';

		        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
		        		{
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
		        		}
		        		else {
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
		        		}

        			}
        		else
        			{ 
        				$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGM('.$myGM.', \'HOD\')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';

		        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
		        		{
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
		        		}
		        		else {
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
		        		}
        			}
        	}
        	else
        		{ 
        				$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTODivH('.$myDivH.', \'HOD\')" type="button"> Send to Head of Division | <i class="fa fa-send"></i></button>';

		        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
		        		{
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
		        		}
		        		else {
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
		        		}
        		}



     }


      function HeadOfDivNextApproval($MyID, $mySupervisor, $myDeptH, $myDivH, $myCPDeptH, $myGM, $myGMCS, $myGMDD)
     {


     	if(
        		$MyID == $myGM
        		&& $myCPDeptH > 0
		        && $MyID != $myCPDeptH
		       
              ) //Chk Head of Division
        	{
        		//$NextApproval = $myDivH;
        		$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOCnP('.$myCPDeptH.', \'HODiv\')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';

        		if($myDeptH > 0 && ($myDeptH != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
        		}
        		elseif($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HODiv\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			//return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HODiv\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
        		}
        		

        	}
        elseif($MyID == $myDivH
        		&& $myGM > 0
		        && $MyID != $myGM
              ) //Chk GM of Division
        	{

        		$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGM('.$myGM.', \'HOD\')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';

        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			//return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
        		}
        	}
        elseif($MyID == $myGM
		        && $MyID != $myCPDeptH
              ) //Chk GM of C&P Head
        	{
        		
        		$NextApproval .= '<button class="btn btn-warning pull-right" onclick="sendTOCnP('.$myCPDeptH.')" type="button"> Send to Contract and Procurement | <i class="fa fa-send"></i></button>';

        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
        		{
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
        		}
        		else {
        			//return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
        		}
        	}
        elseif($MyID == $myCPDeptH) //Chk GM of Division
        	{
        		if($MyID == $myGMCS) //$myGMCS
        			{ 
        				//$NextApproval = $myGM;
        				$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGMCS('.$myGMCS.', \'HOD\')" type="button"> Send to GM Coporate services | <i class="fa fa-send"></i></button>';

		        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
		        		{
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
		        		}
		        		else {
		        			//return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
		        		}

        			}
        		else
        			{ 
        				$NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGM('.$myGM.', \'HOD\')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';

		        		if($mySupervisor > 0 && ($mySupervisor != $MyID))
		        		{
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
		        		}
		        		else {
		        			//return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
		        			return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
		        		}
        			}
        	}
          else
          {
            $NextApproval .= '<button class="btn btn-info pull-right" onclick="sendTOGM('.$myGM.', \'HOD\')" type="button"> Send to My GM | <i class="fa fa-send"></i></button>';

                if($mySupervisor > 0 && ($mySupervisor != $MyID))
                {
                  return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOSupervisor(\'HOD\')" type="button"> Send back to Supervisor | <i class="fa fa-send"></i></button>';
                }
                else {
                  //return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOUser(\'HOD\')" type="button"> Send back to requester | <i class="fa fa-send"></i></button>';
                  return $NextApproval .= '<button class="btn btn-warning pull-left" onclick="sendBTOHOD(\'HODiv\')" type="button"> Send back to Head of Department | <i class="fa fa-send"></i></button>';
                }
          }






     }


     function getStatus($Approved)
     {
            $Detele = ''; $Edit = '';
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
			        $ApprovedN = "Pending with GM Due Diligence";
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
			        $ApprovedN = "Pending with CnP for Final Close Out";
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
			        $ApprovedN = "Keep In View";
			      }
			      else if ($Approved == 15)
			      {
			        $ApprovedN = "Cancelled";
			      }
			       else if ($Approved == 16)
                    {
                      $ApprovedN = "PO Created";
                    }
            else if ($Approved == 17)
                    {
                      $ApprovedN = "Cash Request Raied";
                    }

		return $ApprovedN;
     }


     function setHistory($ReqID)
     {  
     	$resultREQH = mysql_query("SELECT * FROM poreq WHERE RequestID= '".$ReqID."' AND isActive=1");
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
                        <td><b>GM of Due Dilligence:</b> </td>
                        <td>'.$DDApp.'</td>
                    </tr>
                     <tr>
                        <td><b>GM of Due Dilligence Acted On:</b> </td>
                        <td>'.$DDAppDate.'</td>
                    </tr>
                    <tr>
                        <td><b>GM of Due Dilligence\'s Comment:</b> </td>
                        <td>'.$DDAppComment.'</td>
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

