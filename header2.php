  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | <?php echo $PageTitle; ?></title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
      <link href="../mBOOT/searchstyle.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    
     
  <!-- DatePicker -->
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
<!--
<script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>
-->
 <!-- <script src="../mBOOT/jquery-3.1.1.min.js"></script>-->
   <script src="../mBOOT/jquery-3.3.1.min.js"  type="text/javascript"></script>
  
 <!-- Custom scroll Bar -->
    <link href="../mBOOT/prettify.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="../mBOOT/prettify.js"></script>
	<script type="text/javascript" src="../mBOOT/jquery.slimscroll.js"></script>
<!--Multiple Select TOKIN -->

    <!-- Select 2 -->
     <link href="../mBOOT/select2.css" rel="stylesheet" type="text/css" />
     <script src="../mBOOT/select2.js"></script>
     
   <!--Gant Chart-->
     <!-- jsGanttImproved App -->
      <link href="../mBOOT/jsgantt.css" rel="stylesheet" type="text/css"/>
      <script src="../mBOOT/jsgantt.js" type="text/javascript"></script>

      <style type="text/css">
      	#PrintArea {
      		-webkit-print-color-adjust: exact;
      	}
      </style>
      <style type="text/css">
        .ballboard { -webkit-border-radius: 99px 99px 26px 99px;-moz-border-radius: 99px 99px 26px 99px;border-radius: 99px 99px 26px 99px;border:3px solid #62BF95; font-size:13px; font-weight:700; color:#FFF; padding:10px;}
        .controls { overflow: hidden;
        position: fixed; /* Set the navbar to fixed position */
        top: 0; /* Position the navbar at the top of the page */
        width: 100%; z-index:1000; }
    </style>
    <style>
    

        .stamp {
  transform: rotate(12deg);
	color: #555;
	font-size: 3rem;
	font-weight: 700;
	border: 0.25rem solid #555;
	display: inline-block;
	padding: 0.25rem 1rem;
	text-transform: uppercase;
	border-radius: 1rem;
	font-family: 'Courier';
  	-webkit-mask-image: url('../mBOOT/grunge.png'); 
  -webkit-mask-size: 944px 1204px; 
  mix-blend-mode: multiply;
}

.is-nope {
  color: #D23;
  border: 0.5rem double #D23;
  transform: rotate(3deg);
	-webkit-mask-position: 2rem 3rem;
  font-size: 2rem;  
}

.is-approved {
	color: #0A9928;
	border: 0.5rem solid #0A9928;
	-webkit-mask-position: 13rem 6rem;
	transform: rotate(-10deg);
  border-radius: 0;
} 

.is-draft {
	color: #C4C4C4;
	border: 1rem double #C4C4C4;
	transform: rotate(-5deg);
  font-size: 6rem;
  font-family: "Open sans", Helvetica, Arial, sans-serif;
  border-radius: 0;
  padding: 0.5rem;
} 
    </style>
<script>
	$(document).ready(function(){
		loadMsg();
	var preLoadTimer;
	var interchk = <?php echo $_SESSION['LockDownTime']; ?>;
	$(this).mousemove(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).keypress(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).scroll(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).mousedown(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	//checktime
	setInterval(function()
	{
	preLoadTimer++;
	if (preLoadTimer > 10)
	{
	window.location.href="../lockscreen";
	}
	}, interchk )//30 Secs

	//Notification Reload
	setInterval(function()
	{
	  loadMsg();

	}, 100000 )//30 Secs

});


  function loadMsg()
	{
		//return false;
	 //Ajax to Get All Messages now
	    $.ajax({
	          type: "POST",
	          url: "../utility/getMsg",
	          //data: dataString,
	          cache: false,
	          success: function(html)
	          {
	                var obj = JSON.parse(html);
	                
	                $('#msgBoard').html(obj['msg']);
	                $('#msgNum').html(obj['msgNum']);

	                $('#notifBoard').html(obj['notif']);
	                $('#notifNum').html(obj['notifNum']);

	                $('#taskBoard').html(obj['task']);
	                $('#taskNum').html(obj['taskNum']);

	                $('.slimscroll').slimscroll({
					  height: '140px',
					  size: '10px'
					});

					$('.dropdown-menu').on({
					    "click":function(e){
					      e.stopPropagation();
					    }
					});
	          }
	          
	      });

	}

  function delMSG(elem)
  {
  		$(elem).hide();
  		var msgID = $(elem).attr("msgid");
  		
  		var dataString = 'msgID='+ msgID;
  		//ajax to remove user from seeing msg
  		    $.ajax({
	          type: "POST",
	          url: "../utility/removeMsg",
	          data: dataString,
	          cache: false,
	          success: function(html)
	          {
	          	$('#msg-'+msgID).hide();
	          }
	          
	      });
  

  }

   function gotoAction(elem)
  {
  	var hlink = $(elem).attr("hlink");
  	window.location.href=hlink;
  }

</script>


  </head>