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

           
            <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="treeview">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve PORequisition</span></i>
              </a>
            </li>

       <?php } ?>
       <li class="treeview">
              <a href="../qmi/bulkupload" target="_blank">
                   <i style="color:#00F600" class="fa fa-upload"></i><span>Import History</span></i>
              </a>
        </li>
        <li class="treeview">
              <a href="../qmi/viewhistory" target="_blank">
                   <i style="color:blue" class="fa fa-download"></i><span>View Data History</span></i>
              </a>
        </li>
      
       <li class="treeview">
              <a href="#">
                <i class="fa fa-cog text-yellow"></i> <span>QMI</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php
               if ($_SESSION['rptQMI'] == 1) { ?>
            <li>
              <a href="../qmi/internalsalesrpt" target="_blank">
                   <i style="color:#00CC00" class="fa fa-bar-chart"></i><span>Report QMI</span></i>
              </a>
            </li>
             <?php } ?>
            <?php 
             if ($_SESSION['viewQMI'] == 1) { ?>
            <li>
              <a href="../qmi/internalsalesview" target="_blank">
                   <i style="color:#FF6600" class="fa fa-eye"></i><span>view QMI</span></i>
              </a>
            </li>
            <?php } ?>

             </ul>
        </li>
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
			      <li>
              <a href="RFQ">
                   <i class="fa fa-download"></i><span>Receive RFQ</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="addLi">
                   <i class="fa fa-plus"></i><span>Add Line Item</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="sndRFQ">
                   <i class="fa fa-upload"></i><span>Send RFQ</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="LineItems">
                   <i class="fa fa-edit"></i> <span>Unattended Line Items</span>
              </a>
            </li>
			<li class="treeview">
              <a href="Q">
                   <i class="fa fa-bolt"></i> <span>Quote Item(s)</span>
              </a>
            </li>
			
			<li class="treeview">
              <a href="printQ">
                  <i class="fa fa-print"></i> <span>Print Quotation</span>
              </a>
			 
            </li>
			
            <li><a target="_blank" href="http://support.elchabod.com/ticket?project_code=5a8c7aa1372a0"><i class="fa fa-briefcase text-yellow"></i> <span>Support</span></a></li>
              
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
