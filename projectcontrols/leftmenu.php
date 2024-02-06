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
              <a href="./">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

            <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="treeview">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve PORequisition</span>
              </a>
            </li>

       <?php } ?>
      
        <?php 
             if ($_SESSION['viewQMI'] == 1) { ?>
                 <li>
                    <a href="../qmi/projectcontrolview" target="_blank">
                         <i style="color:#FF6600" class="fa fa-eye"></i><span>View Report</span>
                    </a>
                  </li>

             <?php } ?>

        <?php 
            if ($_SESSION['viewQMI'] == 1) { ?>
           <li class="treeview">
              <a href="#">
                <i class="fa fa-cog text-green"></i> <span>Historical Records</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
            <li>
              <a href="../reportlist/aRFQ" target="_blank">
                   <i class="fa fa-cogs"></i><span>All RFQ</span>
              </a>
            </li>
            <li>
              <a href="../reportlist/aSO" target="_blank">
                   <i class="fa fa-cogs"></i><span>All SO</span>
              </a>
            </li>
            <li>
              <a href="../reportlist/aPO" target="_blank">
                   <i class="fa fa-cogs"></i><span>All PO</span>
              </a>
            </li>
            </ul>
        </li>
        <?php } ?>

           <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-cog text-green"></i> <span>Historical Records</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
           <li>
              <a href="../reportlist/aRFQ" target="_blank">
                   <i class="fa fa-cogs"></i><span>All RFQ</span>
              </a>
            </li>
            <li>
              <a href="../reportlist/aSO" target="_blank">
                   <i class="fa fa-cogs"></i><span>All SO</span>
              </a>
            </li>
            <li class="treeview">
                <a href="SalesSO">
                     <i class="fa fa-shopping-cart"></i><span>MRO SO</span>
                </a>
            </li>
            <li class="treeview">
              <a href="ProjectSO">
                   <i class="fa fa-cogs"></i><span>EPC SO</span>
              </a>
            </li>

            <li>
              <a href="../reportlist/aPO" target="_blank">
                   <i class="fa fa-cogs"></i><span>All PO</span>
              </a>
            </li>
              </ul>
            </li> -->

           
            
		        <li class="treeview">
              <a href="Qchk">
                   <i class="fa fa-plus"></i><span>Prepare EPC/MRO SO</span>
              </a>
            </li>

            

			      <li>
              <a href="RaiseQchk">
                   <i class="fa fa-download"></i><span>Raise SO</span>
              </a>
            </li>
			
			       <li class="treeview">
              <a href="EPCMileStone">
                   <i class="fa fa-cubes text-yellow"></i><span>EPC SO MileStones</span>
              </a>
            </li>
			
		               
            <li class="header">USER</li>
            <li><a href="../users/logout"><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
