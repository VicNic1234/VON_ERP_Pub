<?php
session_start();
//error_reporting(0);
include ('../DBcon/db_config.php');

$DateG = date("Y/m/d h:i:sa"); 

$Userid = $_SESSION['uid'];
$StaffNme = $_SESSION['SurName'] . " " . $_SESSION['Firstname'];



function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}


//if($_POST)
{
$msgRecord =''; $notifRecord = ''; $taskRecord = '';
$msgNum = 0; $notifNum = 0; $taskNum = 0;

///////////////// MESSAGES /////////////////////////////////////////////////////
$sqlMsg = mysql_query("SELECT * FROM msg WHERE received=0 AND msgtype='message' AND msgid = 0 ORDER BY msgid DESC");
$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 if ($NoRowsqlMsg > 0) {
  while ($row = mysql_fetch_array($sqlMsg)) {
    $msgid = $row['msgid'];
    $msgtype = $row['msgtype'];
    $msgTitle = $row['msgTitle'];
    $msgRep = $row['recipents'];
    $msgLink = $row['hlink'];
    $msg = $row['msg'];
    $mgsstr = str_replace('<br/>', "\n", $msg);
    $mgsstr = str_replace('</div>', "\n", $msg);
    $mgsstr = str_replace('<b>', "::: ", $mgsstr);
    $mgsstr = str_replace('</b>', " ::: ", $mgsstr);
    $mgsstr = str_replace('<div class="rcorners1">', "\n", $mgsstr);
    $mgsstr = substr($mgsstr, 120);
    //Set Time Created
    $timeAgo = timeAgo($row['CreatedOn']);
    //Let's know if this user should see this msg
    $msgUser = explode(",",$msgRep);
    if(in_array($Userid, $msgUser))
    {

      if ($msgNum % 2 == 0) {
         /*$msgRecord .='
 
              <li style="background:#E0E0E0; border-radius: 10px;">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                            <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';*/

              $msgRecord .='<li style="background:#E0E0E0; border-radius: 10px; cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                           <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
              </li>';
        
      }
      else
      {
         /*$msgRecord .='
 
              <li style="background:#F3F3F3; border-radius: 10px;">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                           <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';
          */
         $msgRecord .='<li style="background:#F3F3F3; border-radius: 10px; cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                           <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
              </li>';

      }

     
            $msgNum = $msgNum + 1;
       }   

     }

 }

//////////////// NOTIFICATION ///////////////////////////////////
 $sqlMsg = mysql_query("SELECT * FROM msg WHERE received=0 AND msgtype='notification' AND msgid = 0 ORDER BY msgid DESC");
$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 if ($NoRowsqlMsg > 0) {
  while ($row = mysql_fetch_array($sqlMsg)) {
    $msgid = $row['msgid'];
    $msgtype = $row['msgtype'];
    $msgTitle = $row['msgTitle'];
    $msgRep = $row['recipents'];
    $msgLink = $row['hlink'];
    $msg = $row['msg'];
    $mgsstr = str_replace('<br/>', "\n", $msg);
    $mgsstr = str_replace('<b>', "::: ", $mgsstr);
    $mgsstr = str_replace('</b>', " ::: ", $mgsstr);
    //Set Time Created
    $timeAgo = timeAgo($row['CreatedOn']);
    //Let's know if this user should see this msg
    $msgUser = explode(",",$msgRep);
    if(in_array($Userid, $msgUser))
    {

      if ($notifNum % 2 == 0) {
         $notifRecord .='
 
              <li style="background:#E0E0E0; border-radius: 10px;" id="msg-'.$msgid.'">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                            <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';
        
      }
      else
      {
         $notifRecord .='
 
              <li style="background:#F3F3F3; border-radius: 10px;" id="msg-'.$msgid.'">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                            <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';

      }

     
            $notifNum = $notifNum + 1;
       }   

     }

 }

 ///////////////////////////////// TASK //////////////////////////////////////////////
 $sqlMsg = mysql_query("SELECT * FROM msg WHERE received=0 AND msgtype='task' AND msgid = 0 ORDER BY msgid DESC");
$NoRowsqlMsg = mysql_num_rows($sqlMsg);
 if ($NoRowsqlMsg > 0) {
  while ($row = mysql_fetch_array($sqlMsg)) {
    $msgid = $row['msgid'];
    $msgtype = $row['msgtype'];
    $msgTitle = $row['msgTitle'];
    $msgRep = $row['recipents'];
    $msgLink = $row['hlink'];
    $msg = $row['msg'];
    $mgsstr = str_replace('<br/>', "\n", $msg);
    $mgsstr = str_replace('<b>', "::: ", $mgsstr);
    $mgsstr = str_replace('</b>', " ::: ", $mgsstr);
    //Set Time Created
    $timeAgo = timeAgo($row['CreatedOn']);
    //Let's know if this user should see this msg
    $msgUser = explode(",",$msgRep);
    if(in_array($Userid, $msgUser))
    {

      if ($taskNum % 2 == 0) {
         $taskRecord .='
 
              <li style="background:#E0E0E0; border-radius: 10px;" id="msg-'.$msgid.'">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                           <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';
        
      }
      else
      {
         $taskRecord .='
 
              <li style="background:#F3F3F3; border-radius: 10px;" id="msg-'.$msgid.'">
                    <ul class="menu">
                      <li style="cursor:pointer;">
                        <a>
                          <div title="'.$mgsstr.'" style="width:90%; color:#7E7E7E; font-size:0.9em; font-weight:800; white-space: nowrap; overflow: hidden; text-overflow:ellipsis; ">
                            '.$msgTitle.'
                          </div>
                          <span style="text-align:right; margin-left:55%;">
                           <small style="color:#42A679; font-size:0.79em; font-weight:700;">'.$timeAgo.'</small>
                            <i class="fa fa-trash" title="Mark as read (Delete)" msgid="'.$msgid.'" onClick="delMSG(this)"></i>
                            <i class="fa fa-send" title="Go to action" hlink="'.$msgLink.'" onClick="gotoAction(this)"></i>
                          </span>
                          
                          <div class="slimscroll" style="border-radius: 10px; background:#42A679; color:#FFF; font-size:0.8em; padding:3px; white-space:normal;">'.$msg.'</div>
                        </a>
                      </li>
                    </ul>
              </li>';

      }

     
            $taskNum = $taskNum + 1;
       }   

     }

 }


$msgs = array();
$msgs['msg'] = $msgRecord;
$msgs['msgNum'] = $msgNum;

$msgs['notif'] = $notifRecord;
$msgs['notifNum'] = $notifNum;

$msgs['task'] = $taskRecord;
$msgs['taskNum'] = $taskNum;

echo json_encode($msgs);
/*$rows = array();
while($r = mysql_fetch_assoc($sqldata)) {
  $rows[] = $r;
}


exit;
*/
}

?>
