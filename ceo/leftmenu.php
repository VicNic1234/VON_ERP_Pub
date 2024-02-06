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
              <a href="../">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>

              </a>
            </li>
              <li class="treeview">
            <a href="./">
                   <i class="fa fa-desktop text-aqua"></i><span>CEO's Dashboard </span> 
                   <small class="label pull-right bg-green">On</small>
              </a>
            </li>

               <li><a href="cashrequest"><i class="fa fa-money text-aqua"></i> <span>Cash Request</span> <small class="label pull-right bg-green">On</small></a></li>

                <li><a href="materialrequest"><i class="fa fa-cogs text-aqua"></i> <span>Material Request</span> <small class="label pull-right bg-green">On</small></a></li>

                 <li><a href="purchaseorders"><i class="fa fa-cogs text-aqua"></i> <span>ENL Purchase Orders </span> <small class="label pull-right bg-green">On</small></a></li>
            <!--
              <li class="treeview">
                  <a href="#">
                    <i class="fa fa-book text-yellow"></i> <span>Activity Report</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                       <li><a href="subjects"><i class="fa fa-eye text-green"></i><span> Subjects <small class="label pull-right bg-green">On</small></span>
                      </a> </li>
                     
                  </ul>
              </li>
            -->
                 
                  <li><a href="contracts"><i class="fa fa-anchor text-blue"></i> <span>View Contracts</span> <small class="label pull-right bg-green">On</small></a></li>

                    <li><a href="viewPO"><i class="fa fa-xing text-aqua"></i>
                   <span>View Customer's PO</span> <small class="label pull-right bg-green">On</small></a></li>
                   
                   <li><a href="invoices"><i class="fa fa-xing text-aqua"></i>
                   <span>View Customer's Invoices</span> <small class="label pull-right bg-green">On</small></a></li>

                  <li><a href="stocks"><i class="fa fa-wrench text-green"></i> <span>View Inventory</span> <small class="label pull-right bg-green">On</small></a></li>

                    <li><a href="equipments"><i class="fa fa-wrench text-green"></i> <span>View Equipments</span> <small class="label pull-right bg-green">On</small></a></li>


                    <li class="treeview">
              <a>
                <i class="fa fa-bar-chart" style="color:#46FFB5"></i> <span>Account Reports</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             
               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>General Ledger</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Mgt. Report </a></li>
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Yearly Report </a></li>
                  </ul>
               </li>

               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Age Analysis</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Receivable Report </a></li>
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Payable Report </a></li>
                  </ul>
               </li>

               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>WHT, VAT</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Receivable Report </a></li>
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Payable Report </a></li>
                  </ul>
               </li>

               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Cost & Revenue Centre</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Divisional Report </a></li>
                  </ul>
               </li>

               <li><a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Bank Reconciliation</span>
               </a></li>

               <li><a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Ledger Reconciliation</span>
               </a></li>

               <li><a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Cash Book</span>
               </a></li>

                <li><a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Working Capital Report</span>
               </a></li>

              </ul>
            </li>

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
