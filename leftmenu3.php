 <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
             <?php echo '<img src="data:image/jpeg;base64,'. base64_encode($prasa). '" class="img-circle" alt="User Image">'; ?>
            </div>
            <div class="pull-left info">
              <p> <?php echo $_SESSION['SurName']. " ". $_SESSION['Firstname']; ?> </p>

                    
					 
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
              <a href="../">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

             <?php if((strpos($_SESSION['AccessModule'], "admin") !== false)) { ?>
              <li class="treeview">
                      <a href="../users/admin">
                           <i class="fa fa-users text-yellow"></i><span>Admin</span>
                      </a>
                    </li>

               <!--<li class="treeview">
                      <a href="../users/activitylog">
                           <i class="fa fa-cogs text-green"></i><span>Activity Logs</span>
                      </a>
                    </li>-->
              <?php } ?>
			
		<!--
        
            <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="treeview">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve PORequisition</span></i>
              </a>
            </li>

       <?php } ?>
       <?php 
       if ($_SESSION['rptQMI'] == 1) { ?>
           <li class="treeview">
              <a href="../qmi" target="_blank">
                   <i style="color:#00CC00" class="fa fa-bar-chart"></i><span>Report QMI</span></i>
              </a>
            </li>

       <?php } ?>
        <?php 
       if ($_SESSION['viewQMI'] == 1) { ?>
           <li class="treeview">
              <a href="../qmi/view" target="_blank">
                   <i style="color:#FF6600" class="fa fa-eye"></i><span>view QMI</span></i>
              </a>
            </li>

       <?php } ?>

        <?php if((strpos($_SESSION['AccessModule'], "internalsales") !== false)) { ?>
      <li class="treeview">
              <a href="../internalsales">
                   <i class="fa fa-share"></i><span>Internal Sales</span></i>
              </a>
            </li>
      <?php } ?>
			
      <?php if((strpos($_SESSION['AccessModule'], "projectcontrols") !== false)) { ?>
			<li class="treeview">
              <a href="../projectcontrols">
                   <i class="fa fa-cogs"></i><span>Project & Control</span>
              </a>
            </li>
      <?php } ?>

      <?php if((strpos($_SESSION['AccessModule'], "purchasing") !== false)) { ?>
			<li class="treeview">
              <a href="../purchasing">
                  <i class="fa fa-th"></i><span>Purchasing</span>
              </a>
			 
            </li>
      <?php } ?>

      <?php if((strpos($_SESSION['AccessModule'], "logistics") !== false)) { ?>
			<li class="treeview">
              <a href="../logistics">
                   <i class="fa fa-magic"></i><span>Logisitics</span>
              </a>
            </li>
      <?php } ?>

      <?php if((strpos($_SESSION['AccessModule'], "warehousing") !== false)) { ?>
			<li class="treeview">
              <a href="../warehousing">
                   <i class="fa fa-bank"></i><span>Warehousing</span>
              </a>
            </li>
      <?php } ?>
-->
      <?php if((strpos($_SESSION['AccessModule'], "humanresources") !== false)) { ?>
      <li class="treeview">
              <a href="../humanresources">
                   <i class="fa fa-users"></i><span>Human Resources</span>
              </a>
            </li>
      <?php } ?>
<!--
      <?php if((strpos($_SESSION['AccessModule'], "accounts") !== false)) { ?>
      <li class="treeview">
              <a href="../accounts">
                   <i class="fa fa-line-chart"></i><span>Accounts</span>
              </a>
            </li>
      <?php } ?>

     


      <?php if((strpos($_SESSION['AccessModule'], "BI") !== false)) { ?>
       <li class="treeview">
              <a href="../CEOD">
                   <i class="fa fa-bar-chart"></i><span>CEO's (BI)</span>
              </a>
            </li>
      <?php } ?>

			
			
            <li><a target="_blank" href="http://support.elchabod.com/ticket?project_code=5a8c7aa1372a0"><i class="fa fa-briefcase text-yellow"></i> <span>Support</span></a></li>
         -->  
                              
            <li class="header">USER</li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>