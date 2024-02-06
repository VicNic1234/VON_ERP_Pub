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
<html style="">
    <head>
        <meta charset="UTF-8">
        <title>PENL ERP | version 2.1</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../bootstrap/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="">
	<?php if ($G == "")
           {} else
echo

'<br><br><div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<a href=""><button type="submit" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></a>' .
                                        '<b>Alert!</b>  '.  $G.
                                    '</div>' ;
 { 


 $_SESSION['ErrMsg'] = ""; } ?>
        <div class="form-box" id="login-box">
            <div class="header"><i class="fa fa-cog fa-spin fa-1x fa-fw"></i> DATA WAREHOUSE | version 2.1</div>
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

                   

                    
                </div>
            </form>

            <div class="margin text-center">
            </div>
        </div>

        <script src="../bootstrap/jquery.min.js"></script>
        <script src="../bootstrap/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
