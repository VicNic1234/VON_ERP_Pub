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
            <li class="treeview">
              
              <?php if ($_SESSION['Dept'] == "superadmin") { ?>
              <a href="../">
              <?php } else { ?>
              <a href="../">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
 <li><a href="stations"><i class="fa fa-map-marker text-aqua"></i> 
                   <span>Set Locations </span> <small class="label pull-right bg-green">On</small></a></li>
             <li><a href="newhir"><i class="fa fa-xing text-red"></i>
                   <span>Hazard ID Reports</span> <small class="label pull-right bg-green">On</small></a></li>
                <li><a href="hirs"><i class="fa fa-xing text-red"></i>
                   <span>View Hazard ID Rpts</span> <small class="label pull-right bg-green">On</small></a></li>

             <!--<li><a href=""><i class="fa fa-graduation-cap text-yellow"></i> 
                   <span>HSE Inductions</span> <small class="label pull-right bg-red">Off</small></a></li>-->

              <li><a href="newjha"><i class="fa fa-bolt text-aqua"></i> 
                   <span>Job Harzad Analysis</span> <small class="label pull-right bg-green">On</small></a></li>

                <li><a href="jhas"><i class="fa fa-bolt text-aqua"></i> 
                   <span>View Job Harzad</span> <small class="label pull-right bg-green">On</small></a></li>



            <li class="treeview">
              <a>
                <i class="fa fa-pie-chart text-green"></i> <span>KPI</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li><a href="hsekpi"><i class="fa fa-bar-chart text-aqua"></i> 
                   <span>KPIs</span> <small class="label pull-right bg-green">On</small></a></li>


                  <li><a href="reckpi"><i class="fa fa-edit text-aqua"></i> 
                   <span>Record KPI Data</span> <small class="label pull-right bg-green">On</small></a></li>
                 </ul>
            </li>

          <!--  <li class="treeview">
              <a href="#">
                <i class="fa fa-anchor text-aqua"></i> <span>PPE Renewal</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="ppekit"><i class="fa fa-edit text-aqua"></i> 
                   <span>PPE Kits</span> <small class="label pull-right bg-green">On</small></a></li>
                  <li><a href="ppe"><i class="fa fa-edit text-aqua"></i> 
                   <span>Request PPE Kit</span> <small class="label pull-right bg-red">Off</small></a></li>

                

              </ul> 
        </li> -->
			
      
     
		               
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
