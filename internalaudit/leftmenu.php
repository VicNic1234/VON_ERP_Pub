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
                    <i class="fa fa-book text-yellow"></i> <span>Activity Report</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                       <li><a href="subjects"><i class="fa fa-eye text-green"></i><span> Subjects <small class="label pull-right bg-green">On</small></span>
                      </a> </li>
                       <!--  <li><a href="meetings"><i class="fa fa-edit text-blue"></i><span> Meetings <small class="label pull-right bg-green">On</small></span>
                      </a> </li> -->
                  </ul>
              </li>
                 
                  <li><a href="contracts"><i class="fa fa-anchor text-blue"></i> <span>View Contracts</span> <small class="label pull-right bg-green">On</small></a></li>

                  <li><a href="stocks"><i class="fa fa-bank text-green"></i> <span>Inventory (Ware House)</span> <small class="label pull-right bg-green">On</small></a></li>

                  <!-- <li><a href="equipments"><i class="fa fa-bank text-green"></i> <span>Inventory (Assets)</span> <small class="label pull-right bg-green">On</small></a></li> -->
                   
                    <li class="treeview">
              <a>
                <i class="fa fa-bank" style="color:#46FFB5"></i> <span>Inventory (Fixed Assets)</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             
                <li><a href="stations"><i class="fa fa-map-marker text-aqua"></i> <span>Equipment Locations</span> <small class="label pull-right bg-green">On</small></a></li>
                 <li><a href="category"><i class="fa fa-cubes text-red"></i> <span>Equipment Category</span> <small class="label pull-right bg-green">On</small></a></li>
                  <li><a href="subcat"><i class="fa fa-circle text-yellow"></i> <span>Equipment Type</span> <small class="label pull-right bg-green">On</small></a></li>
                 <li><a href="manufacturers"><i class="fa fa-cogs text-aqua"></i> <span>Manufacturers</span> <small class="label pull-right bg-green">On</small></a></li>
                   <li><a href="newequipment"><i class="fa fa-wrench text-green"></i> <span>Add Equipment</span> <small class="label pull-right bg-green">On</small></a></li>

              <li><a href="equipments"><i class="fa fa-cogs text-aqua"></i> <span>View Equipments</span> <small class="label pull-right bg-green">On</small></a></li>

              

               
              

            

              

             


              
              

              </ul>
            </li>

 
            <li class="treeview">
              <a>
                <i class="fa fa-bar-chart" style="color:#46FFB5"></i> <span>Account Reports</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="trialbalance"><i class="fa fa-anchor" style="color:#FFFF00"></i> <span>Trial Balance </span> <small class="label pull-right bg-green">On</small></a></li>
               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>General Ledger</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <!--<li><a href="rptGL"> <i class="fa fa-square" style="color:#46FFB5"></i> Mgt. Report </a></li>-->
                   <li><a href="rptGLY"> <i class="fa fa-square" style="color:#46FFB5"></i> GL Report </a></li>
                   <li><a href="cusGLY"> <i class="fa fa-square text-yellow" ></i> Customer Ledger Report </a></li>
                   <li><a href="venGLY"> <i class="fa fa-square text-blue" ></i> Vendor Ledger Report </a></li>
                  
                  </ul>
               </li>

               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Financial Statement</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a href="incomestatement?EXZ=1"> <i class="fa fa-square" style="color:#46FFB5"></i> Income Statement </a></li>
                   <li><a href="balancesheet?EXZ=1"> <i class="fa fa-square" style="color:#46FFB5"></i> Balance Sheet </a></li>
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Cash Flow Statement </a></li>
                   <li><a> <i class="fa fa-square" style="color:#46FFB5"></i> Changes in Equity </a></li>
                  </ul>
               </li>

               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>Age Analysis</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a href="receivableaging"> <i class="fa fa-square" style="color:#46FFB5"></i> Receivable Report </a></li>
                   <li><a href="payableaging"> <i class="fa fa-square" style="color:#46FFB5"></i> Payable Report </a></li>
                  </ul>
               </li>

                <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>WHT, VAT</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a href="VATR"> <i class="fa fa-square" style="color:#46FFB5"></i> VAT Receivable </a></li>
                   <li><a href="VATP"> <i class="fa fa-square" style="color:#46FFB5"></i> VAT Payable </a></li>
                   <li><a href="WHTR"> <i class="fa fa-square text-blue"></i> WHT Receivable </a></li>
                   <li><a href="WHTP"> <i class="fa fa-square text-blue"></i> WHT Payable </a></li>
                  </ul>
               </li>
               
                <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>NCD, Carbotage</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a href="NCDR"> <i class="fa fa-square" style="color:#46FFB5"></i> NCD Deductions </a></li>
                   <li><a href="NCDP"> <i class="fa fa-square" style="color:#46FFB5"></i> NCD Payable </a></li>
                   <li><a href="CABR"> <i class="fa fa-square text-blue"></i> CARB Deductions </a></li>
                   <li><a href="CABP"> <i class="fa fa-square text-blue"></i> CARB Payable </a></li>
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
