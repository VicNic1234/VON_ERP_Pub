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

                    
					 
              <a><i class="fa fa-circle text-success"></i> Online</a>
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
              <a href="./">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

              <li class="treeview">
                  <a href="#">
                    <i class="fa fa-book text-yellow"></i> <span>Classification</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                       <li><a href="docclasses"><i class="fa fa-eye text-green"></i><span> Doc. Class <small class="label pull-right bg-green">On</small></span>
                      </a> </li>
                         
                  </ul>
              </li>
                 
                <!--  <li><a href="contracts"><i class="fa fa-anchor text-blue"></i> <span>View Contracts</span> <small class="label pull-right bg-green">On</small></a></li>
                -->

	<!--
			
            <li><a target="_blank" href="http://support.elchabod.com/ticket?project_code=5a8c7aa1372a0"><i class="fa fa-briefcase text-yellow"></i> <span>Support</span></a></li>
           -->   
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
