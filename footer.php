<footer class="main-footer no-print">
        <div class="pull-right hidden-xs">
          <b>Version</b> <?php echo $_SESSION['version']; ?>
        </div>
        <strong>Copyright &copy; 2014-2023 <a href="http://elchabod.com">Elchabod Tech.</a>.</strong> All rights reserved.
</footer>
<div>
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                       <center><h4 style="display:inline-block" class="modal-title" id="myModalLabel"></h4> </center>
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
          <!-- Elchabod Modal -->
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

	function changePws1()
	{

	}

	function changePws(){

        var title = '<center>Change Password</center>';
        var size='large';
        var content = '<form id="UpUser" method="post" action="https://elshcon.space/users/updUserPassword">'+
          '<center><label id="msg1"></label></center>'+
          '<div class="form-group has-feedback">'+
            '<label>Old Password</label>'+
            '<input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="" required />'+
            
            '<span class="glyphicon glyphicon-key form-control-feedback"></span>'+
          '</div>'+
           
         '<div class="form-group has-feedback">'+
            '<label>New Password</label>'+
            '<input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="" required />'+
            
            '<span class="glyphicon glyphicon-key form-control-feedback"></span>'+
          '</div>'+

          '<div class="row">'+
            '<!-- /.col -->'+
            '<div class="col-xs-4 pull-right">'+
              '<button type="submit" class="btn btn-success btn-block btn-flat">Update</button>'+
            '</div>'+
          '</div>'+
        '</form>';
       // onclick="upDateUserPws();"
        var footer = '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>';

              setModalBox(title,content,footer,size);
              $('#myModal').modal('show');
             
        //var Countries = getCountries();

        
      }

      function upDateUserPws(){
      	var oldpassword = $('#oldpassword').val();
      	var newpassword = $('#newpassword').val();
      	if(oldpassword == "" || newpassword == "") { $('#msg1').html("Fill form compeletly. Thanks!"); return false; } else {  $('#msg1').html("Updating ..."); }
      	var datafrm = { oldpassword:oldpassword, newpassword:newpassword };
      	//var url = "http://localhost/elshcon/users/updatepwsd"; //alert(url);
      	var url = "https://www.elshcon.space/users/updatepwsd"; //alert(url);
         $.ajax({ url: url, method: 'POST', data: datafrm }).then(
         	function(data){ 
         		$('#msg1').html(data);
         		if(data == "Updated") { 
         			$('#oldpassword').val("");
      	            $('#newpassword').val("");
         			$('#myModal').modal('hide'); 
         		}
         	}, 

         	function(data){ alert('No Connection'); });

      }
</script>

<script>
     $('.select2').select2({
      width: 'resolve', theme: 'classic'
    });
    // $('.srcselect').select2();
</script>