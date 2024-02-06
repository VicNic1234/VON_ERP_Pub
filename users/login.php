<?php
session_start();
error_reporting(0);
$G = $_SESSION['ErrMsg'];
$_SESSION['ErrMsg'] = "";
 $_SESSION['uid'] = "";
      $_SESSION['SurName'] = "";
      $_SESSION['Firstname'] = "";
      $_SESSION['Gender'] = "";
      $_SESSION['StaffID'] = "";
      $_SESSION['DateReg'] = "";
      $_SESSION['Email'] = "";
      $_SESSION['Phone'] = "";
      $_SESSION['DoB'] = "";
      $_SESSION['Picture'] = "";
      $_SESSION['Role'] = "";
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ELSHCON ERP | version 0.1</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
	<link href="css/style.css" rel='stylesheet' type='text/css'/>
	<link href="css/font-awesome.min.css" rel='stylesheet' type='text/css'/>
	<link href="//fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<script src="js/jquery.min.js"></script>
</head>
<body>
<div class="b-con">

<div class="content-agile">
	<div class="social-left-agileits" style="background:#ff6200; border-radius: 20px;">
		<ul>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
        </ul>
	</div>
	<div class="profile-agileinfo" style="border-radius: 10px;">
		<div class="pr-inner">
			<!--<img src="../mBOOT/plant.png" alt=" " />-->
			<h2>ELSHCON ERP</h2>
			<h3><i class="fa fa-cog fa-spin fa-1x fa-fw"></i> GLOBAL DATAWARE HOUSE | version 0.1</h3>
                        <br/> 
			<div class="col-md-12 skills-right">

				
             <div class="form-box" id="login-box">
                <!--<div class="header"><i class="fa fa-cog fa-spin fa-1x fa-fw"></i> DATA WAREHOUSE | version 2.1</div>-->
                        <form action="chklog" method="post">
                            <div class="body bg-gray">
                                <div class="form-group">
                                    <input type="text" name="Uname" class="form-control" placeholder="Staff ID / E-mail" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pwd" class="form-control" placeholder="Password" required />
                                </div>
                            </div>
                            <div class="footer">
                                <button type="submit" class="btn bg-olive btn-block">SIGN IN</button>
                                <br/>
                                
                                <?php if ($G == "") {} else { 
                                    echo '<h3 style="color:red; font-weight:700">'.$G.'</h3>';
                                    $_SESSION['ErrMsg'] = ""; } ?>
                            </div>
                        </form>
                        <br/> <br/> <br/>
                <div class="margin text-center">
                </div>
            </div>
			</div>
		</div>
	</div>
	<div class="social-right-w3-agile" style="background:#ff6200; border-radius: 20px;">
        <ul>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
        </ul>
		<!--<ul>
			<li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
			<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
			<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
			<li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
		</ul>-->
	</div>
	<div class="clear"></div>
</div>
<div class="footer-w3l">
	<p class="agileinfo"> &copy; 2018 ELSHCON NIG. LIMITED. All Rights Reserved </p>
</div>
</div>
<script src="js/bars.js"></script>	
</body>
</html>