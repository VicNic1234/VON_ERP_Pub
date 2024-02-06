<script type="text/javascript">

      function sendTOSupervisor(rep, actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOSupervisor" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                   '<input type="hidden" name="rep" value="'+rep+'" />'+
                   '<input type="hidden" name="actor" value="'+actor+'" />'+
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Supervisor: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Supervisor';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

               
              
      }
    </script>
    <script type="text/javascript">
      function sendTODeptH(rep, actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOHOD" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                    '<input type="hidden" name="rep" value="'+rep+'" />'+
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Department: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Head of Department';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
    <script type="text/javascript">
      function sendTODivH(rep, actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTODivHead" method="POST" ><div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                    '<input type="hidden" name="rep" value="'+rep+'" />'+
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Head of Division: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send To Head of Division';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
   
     <script type="text/javascript">
      function sendBTOUser(actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBUser" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Requester: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Requester';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
      <script type="text/javascript">
      function sendBTOSupervisor(actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var OptType =   loadAccType(acctclass); //'<?php echo $OptType ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOBSupervisor" method="POST" ><div class="form-group">' +
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message to Supervisor: </label><input type="text" class="form-control" id="eaccCode" name="hodMSG" placeholder=""  value="Kindly update and submit again. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-info pull-right">Send</button><br/></form>';
                  var title = 'Send Back To Supervisor';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }

       function sendTOCnP(rep,actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var GMCSNme = '<?php echo $GMCSNme ?>';
        //var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOCnP" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                     '<input type="hidden" name="rep" value="'+rep+'" />'+
                   '<input type="hidden" name="actor" value="'+actor+'" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send To Contracts & Procurements';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

       function sendTOGMCS(rep,actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        var GMCSNme = '<?php echo $GMCSNme ?>';
        var DivisonName = '<?php echo $DivisonName ?>';
        
          var size='standart';
                  var content = '<form role="form" action="sendTOGMCS" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                     '<input type="hidden" name="rep" value="'+rep+'" />'+
                   '<input type="hidden" name="actor" value="'+actor+'" />'+

                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>GM of CS: </label><input type="text" class="form-control"   value="'+ GMCSNme +'"  readonly ></div>' +
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send To GM of Corporate Services';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }

      function sendTOGM(rep,actor)
      {
      
        var sReqID = '<?php echo $sReqID ?>';
        //var GMCSNme = '<?php echo $GMCSNme ?>';
        //var DivisonName = '<?php echo $DivisonName ?>';
        //alert(sReqID);
          var size='standart';
                  var content = '<form role="form" action="sendTOGM" method="POST" >'+
                  '<div class="form-group">' +
                   '<input type="hidden" value="" id="accID" name="accID" />'+
                   '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>PDF CODE: </label><input type="text" class="form-control"  name="ReqCode" value="'+ sReqID +'"  readonly ></div>' +
                     '<input type="hidden" name="rep" value="'+rep+'" />'+
                   '<input type="hidden" name="actor" value="'+actor+'" />'+
                   
                   
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message: </label><input type="text" class="form-control" id="RecMSG" name="hodMSG" placeholder=""  value="" required ></div><br/>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/>'

                  ;
                  var title = 'Send To GM of Division';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');
      }
    </script> 