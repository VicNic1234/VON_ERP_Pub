
      <header class="main-header">

        <!-- Logo -->
        <a href="./" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!--<span class="logo-mini"><img src="mBOOT/plant.png" width="50" height="50" /></span>-->
          <!-- logo for regular state and mobile devices -->
          <!--<span class="logo-lg"> <img src="mBOOT/plant.png" style ="width:40px; height:40px;"/></span>-->
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="../mBOOT/splant.png" style ="width:30px; height:30px;"/><strong><?php echo $_SESSION['CompanyAbbr']; ?></strong> ERP</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="../mBOOT/splant.png" style ="width:30px; height:30px;"/> <strong><?php echo $_SESSION['CompanyAbbr']; ?></strong> ERP</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success" id="msgNum">0</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- <li class="header">Messages</li>
                   inner menu: contains the actual data -->
                  <li>
                    <ul class="menu"  id="msgBoard" style="max-height:490px; overflow-y: scroll;">
                     
                      
                      
                     <!-- <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>-->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
                  <span class="hidden-xs"><?php echo $_SESSION['CusNme']; ?> on PEEL ERP</span>
				  
                </a>
                
              </li>
              <!-- Control Sidebar Toggle Button
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
            </ul>
          </div>

        </nav>
      </header>