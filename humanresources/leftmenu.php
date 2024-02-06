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
              <?php if ($_SESSION['Dept'] == "superadmin") { ?>
              <a href="../">
              <?php } else { ?>
              <a href="../">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

            <li class="treeview" onclick="$('#regid').submit();">
            
              <a href="../users/register">
                
                   <i class="fa fa-user text-green"></i> <span> &nbsp; Employee</span></i>
                  
              </a>
            
            </li>
            
            <li class="treeview" onclick="$('#regid').submit();">
            
              <a href="../users/training">
                
                   <i class="fa fa-user text-orange"></i> <span> &nbsp; Training Matrix </span></i>
                  
              </a>
            
            </li>
            

       <!--
            <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="treeview">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve PORequisition</span></i>
              </a>
            </li>

       <?php } ?>

     -->
     
        <li class="treeview">
              <a>
                <i class="fa fa-money text-blue"></i> <span>Payroll</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             
               <li><a href="payrollsettings"> <i class="fa fa-square text-yellow"></i> General Settings</a></li>
               <li><a href="payrollelement"> <i class="fa fa-square text-yellow"></i> Payroll Elements</a></li>
              <!-- <li><a href="deductionssettings"> <i class="fa fa-square text-yellow"></i> Deductions</a></li>
               <li><a href="companycontributions"> <i class="fa fa-square text-yellow"></i> Company Contributions</a></li> -->
            
               <!--<li><a href=""> <i class="fa fa-square text-yellow"></i> Employee Statutory</a></li>-->
               <li><a href="salarypayment"> <i class="fa fa-square text-yellow"></i> Salary Payment</a></li> 
               <!-- <li>
                <a>
                   <i class="fa fa-bar-chart text-blue"></i> <span>Reports</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a> <i class="fa fa-square text-blue"></i> PAYE Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> Pensions Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> NSITF (ECA) Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> ITF Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> NHF Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> NHIS Remittance Schedule </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> RSSS Contributory Levy </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> Salary Advance </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> Loans Report </a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> Salary Schedule </a></li>
                  </ul>
               </li>-->
             
              </ul>
            </li>
			
			  <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>HRMS Settings</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li><a href="aDiv"><i class="fa fa-user"></i> Division</a></li>
               <li><a href="aBus"><i class="fa fa-user"></i> Business Unit</a></li>
               <li><a href="aDept"><i class="fa fa-user"></i> Department</a></li>
               <!--<li><a href="aJobT" target="_blank"><i class="fa fa-user"></i> Job Title</a></li>-->
                <li><a href="aJobP"><i class="fa fa-user"></i> Designation</a></li>
              </ul>
        </li>
			
			 <li class="treeview">
              <a href="#">
                <i class="fa fa-car text-yellow"></i> <span>Travel Management</span></i>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <!--<li><a href="dholiday">Declare Holiday</a></li>-->
               <li><a href="emptravel" target="_blank">Employee Travel Request</a></li>
              </ul>
        </li>

        <li class="treeview">
              <a href="#">
                <i class="fa fa-plane text-blue"></i> <span>Leave Management</span></i>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <!--<li><a href="leavemgt">Leave Management Options</a></li>-->
               <li><a href="empleave" target="_blank">Employee Leave Request</a></li>
                <!--<li><a href="">Add Employee Leave</a></li>-->
              </ul>
        </li>

         <li class="treeview">
              <a href="#">
                <i class="fa fa-car text-aqua"></i> <span>Vehicle Management</span></i>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li><a href="newvehicle"><i class="fa fa-plus text-aqua"></i><span>Add Vehicle</span></a></li>
               <li><a href="vehicles"><i class="fa fa-eye text-aqua"></i><span>View Vehicles</span></a></li>
              </ul>
        </li>

			
			 <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-cog fa-spin fa-fw text-green"></i> <span>Employee Configuration</span></i>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li><a href=""></i>Employee Tabs</a></li>
                <li><a href="">Employee Status</a></li>
                <li><a href="">Remuneration Basis</a></li>
                <li><a href="">Job Tiles</a></li>
                <li><a href="">Positions</a></li>
                <li><a href="">Competency Levels</a></li>
                <li><a href="">Education Levels</a></li>
                <li><a href="">Education Levels</a></li>
                <li><a href="">Languages</a></li>
                <li><a href="">Leave Type</a></li>
                <li><a href="">Attendance Status</a></li>
                <li><a href="">Bank Account Types</a></li>
                <li><a href="">Identity Documents</a></li>
                <li><a href="">EEOC Categories</a></li>
                <li><a href="">Work Eligibility Document Types</a></li>
                <li><a href="">Veteran Status</a></li>
                <li><a href="">Military Service Types</a></li>
              </ul>
        </li> -->
			
                              
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>