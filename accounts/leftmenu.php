<aside class="main-sidebar no-print">
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
          <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">r
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>-->
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

           
            <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve Requisition</span></i>
              </a>
            </li>

       <?php } ?>
       <!--
          <li class="treeview">
              <a href="#">
                <i class="fa fa-cog text-green"></i> <span>Operational Record</span>
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
        </li>-->
		       <!-- <li class="treeview">
              <a href="Qchk">
                   <i class="fa fa-cog"></i><span>Track Orders</span></i>
              </a>
            </li>-->
        <li class="treeview">
              <a>
                <i class="fa fa-money text-aqua"></i> <span>Banks / Jobs / Budget </span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu"> 
          <li> <a href="banksettings"> <i class="fa fa-bank text-yellow"></i> <span>Banks</span> </a> </li>
          <li> <a href="jobs"> <i class="fa fa-briefcase text-green"></i> <span>Jobs</span> </a> </li>
          <li> <a href="budget_expected"> <i class="fa fa-briefcase text-aqua"></i> <span>Division Budget</span> </a> </li>
          </ul>
        </li>
        
         <li class="treeview">
              <a>
                <i class="fa fa-money text-purple"></i> <span>Imprest & Journal</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
           <li> <a href="processpettycash"> <i class="fa fa-money text-purple"></i> <span>Disburse Imprest</span> </a> </li>
           <li><a href="journal"><i class="fa fa-cog fa-spin fa-fw text-yellow"></i> <span>Raise Journal</span> <small class="label pull-right bg-green">On</small></a></li>
           </ul>
        </li>
           
          <li class="treeview">
              <a href="#">
                <i class="fa fa-line-chart text-yellow"></i> <span>Chart Of Account</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li><a href="chartClass"> <i class="fa fa-square text-orange"></i> Chart Class</a></li>
               <li><a href="chartType"> <i class="fa fa-square text-orange"></i> Chart Type</a></li>
               <li><a href="chartMaster"> <i class="fa fa-square text-orange"></i> Chart Master</a></li>
              </ul>
          </li>
          
          


          
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money text-orange"></i> <span>Trade Payable</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="cheuqes"> <i class="fa fa-cogs text-green"></i>Register Cheque</a></li>
                 
                <li class="treeview">
                      <a href="#">
                        <i class="fa fa-square" style="color:#99FF00"></i> <span>Vendor Invoice</span>
                         <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                          
                          <li><a href="newinvoice"> <i class="fa fa-edit" style="color:#99FF00"></i>Register Invoice</a></li>
                          <li><a href="invoices"> <i class="fa fa-undo" style="color:#99FF00"></i>Treat Invoice</a></li>
                         
                      </ul>
                    </li>
                  
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-money text-orange"></i> <span>Bank Payments</span>
                         <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                          
                         <!--
                         <li><a href="processpettycash"> <i class="fa fa-undo text-orange"></i>Process Petty Cash</a></li>
                         -->
                    
                  
                          <li><a href="processcashNew"> <i class="fa fa-undo text-orange"w></i>Process Payment</a></li>
                          <!--<li><a href="BankPayment"> <i class="fa fa-square text-orange"></i>Bank Payment</a></li>-->
                         
                      </ul>
                    </li>
                 
              </ul>
            </li>
          
            
            <!--<li><a href=""><i class="fa fa-money text-yellow"></i>Credit Note</a></li>-->
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money text-green"></i> <span>Trade Receivable</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li class="treeview">
                    <a>
                      <i class="fa fa-square text-green"></i> <span>ENL Invoice</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                     <ul class="treeview-menu">
                       <li><a href="enlinvoice"> <i class="fa fa-square text-yellow"></i> Raise Invoice</a></li>
                       <li><a href="enlinvoices"> <i class="fa fa-edit text-yellow"></i> Treat Invoice</a></li>
                      </ul>
                  </li>

                  <li><a href="processrecipt"> <i class="fa fa-square text-green"></i>Bank Receipt</a></li>
              </ul>
            </li>
            
            
          
           <li class="treeview">
              <a>
                <i class="fa fa-money text-aqua"></i> <span>Cash Request</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li><a href="pettycash"><i class="fa fa-cog fa-spin fa-fw text-aqua"></i> <span>Treat Cash Request</span> <small class="label pull-right bg-green">On</small></a></li>
              
              <li><a href="pettycashtreated"><i class="fa fa-cog fa-spin fa-fw text-green"></i> <span>Treated Cash Request</span> <small class="label pull-right bg-green">On</small></a></li>
            </ul>
        </li>
            



           

           

            <!--<li class="treeview">
              <a><i class="fa fa-cubes text-white"></i> <span>Staff Advance</span></a>
            </li>-->

           <li class="treeview">
              <a>
                <i class="fa fa-money text-blue"></i> <span>Payroll</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             
               <li><a href="payrollsettings"> <i class="fa fa-square text-yellow"></i> General Settings</a></li>
               <!-- <li><a href="earningssettings"> <i class="fa fa-square text-yellow"></i> Earnings</a></li>
               <li><a href="deductionssettings"> <i class="fa fa-square text-yellow"></i> Deductions</a></li>
               <li><a href="companycontributions"> <i class="fa fa-square text-yellow"></i> Company Contributions</a></li>
            
               <li><a href=""> <i class="fa fa-square text-yellow"></i> Employee Statutory</a></li>-->
               <li><a href="../users/salarypayment"> <i class="fa fa-square text-yellow"></i> Salary Payment</a></li> 
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
              <a>
                <i class="fa fa-bar-chart" style="color:#46FFB5"></i> <span>Account Reports</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <li><a href="trialbalance?EXZ=1"><i class="fa fa-anchor" style="color:#FFFF00"></i> <span>Trial Balance </span> <small class="label pull-right bg-green">On</small></a></li>
               <li>
                <a>
                   <i class="fa fa-file-o" style="color:#46FFB5"></i> <span>General Ledger</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <!--<li><a href="rptGL"> <i class="fa fa-square" style="color:#46FFB5"></i> Mgt. Report </a></li>
                   <li><a href="rptGLY"> <i class="fa fa-square" style="color:#46FFB5"></i> Postings Report </a></li>-->
                    <li><a href="mglreport"> <i class="fa fa-square" style="color:#46FFB5"></i> GL Report </a></li>
                
                   <li><a href="mcusGLY"> <i class="fa fa-square text-yellow" ></i> Customer Ledger Report </a></li>
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
                   <li><a href="cashflow"> <i class="fa fa-square" style="color:#46FFB5"></i> Cash Flow Statement </a></li>
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
                

               <li><a href="bnkrecon">
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

             <li><a href="stocks"><i class="fa fa-bank text-green"></i> <span>Inventory (Warehouse)</span> <small class="label pull-right bg-green">On</small></a></li>

            <li><a href="equipments"><i class="fa fa-bank text-green"></i> <span>Fixed Assets</span> <small class="label pull-right bg-green">On</small></a></li>
            
            <li class="treeview">
              <a>
                <i class="fa fa-cog text-white"></i> <span>Regularization</span>
                 <i class="fa fa-angle-left pull-right"></i> <small class="label pull-right bg-aqua">New</small>
              </a>
              <ul class="treeview-menu">
                <!--  <li>
                <a href="paym">
                   <i class="fa fa-cogs text-green"></i> <span>Over Pay</span>
                </a>
               </li> -->
               <li>
                <a href="allopenbal">
                   <i class="fa fa-cogs text-green"></i> <span>All Open Balances</span>
                </a>
               </li>
               <li>
                <a href="nonbalpost">
                   <i class="fa fa-cogs text-green"></i> <span>Non-Balance Postings</span>
                </a>
               </li>
               <!--
               <li>
                <a href="TCPostings">
                   <i class="fa fa-cogs text-green"></i> <span>Trade Creditor Postings</span>
                </a>
               </li>
                <li>
                <a href="TDPostings">
                   <i class="fa fa-cogs text-green"></i> <span>Trade Debitor Postings</span>
                </a>
               </li> -->
              
              </ul>
            </li>
            
            <li class="treeview">
              <a>
                <i class="fa fa-cog text-blue"></i> <span>Settings</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li>
                <a href="postingsettings">
                   <i class="fa fa-cogs text-green"></i> <span>Posting Settings</span>
                </a>
               </li>
              
               
                 <li>
                <a>
                   <i class="fa fa-bar-chart text-blue"></i> <span>Parameters</span>
                   <i class="fa fa-angle-left pull-right"></i>
                </a>
                  <ul class="treeview-menu">
                   <li><a href="calmethod"> <i class="fa fa-square text-blue"></i> Calculation Method</a></li>
                   <li><a href="earningfrequency"> <i class="fa fa-square text-blue"></i> Earning Frequency</a></li>
                   <li><a> <i class="fa fa-square text-blue"></i> Employee Group</a></li>
                  </ul>
               </li>
              </ul>
            </li>

            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a><i class="fa ion-edit"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
