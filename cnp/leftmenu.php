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


            <?php if($_SESSION['HDept'] == 1 && (strpos($_SESSION['AccessModule'], "Treat Procurement") !== false))  { ?>
                  <li><a href="../requisition/cnpppor" target="_blank"><i class="fa fa-edit text-aqua"></i> <span>Pending PDF Approvals</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>

            <?php if((strpos($_SESSION['AccessModule'], "Warehouse") !== false)) { ?>
                  <li><a href="../warehouse"><i class="fa fa-bank text-yellow"></i> <span>Warehouse</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>

 <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Process Contract</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a> 
              <ul class="treeview-menu">

           <?php if((strpos($_SESSION['AccessModule'], "Raise Contract") !== false)) { ?>
                  <li><a href="newcontract"><i class="fa fa-anchor text-blue"></i> <span>Raise Contract</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>

            <?php if((strpos($_SESSION['AccessModule'], "Raise Contract") !== false)) { ?>
                  <li><a href="contracts"><i class="fa fa-anchor text-blue"></i> <span>View Contracts</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
                </ul>
</li>

<li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Process PO</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             <?php if((strpos($_SESSION['AccessModule'], "Treat Procurement") !== false)) { ?>
                  <li><a href="newpo"><i class="fa fa-cog text-white"></i> <span>Raise PO</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            
            <?php if((strpos($_SESSION['AccessModule'], "Process PO") !== false)) { ?>
                  <li><a href="purchaseorders"><i class="fa fa-cog text-white"></i> <span>View PO</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
               </ul>
</li>

<li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Process Invoice</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
             <?php if((strpos($_SESSION['AccessModule'], "Treat Procurement") !== false)) { ?>
                  <li><a href="newinvoice"><i class="fa fa-cog text-green"></i> <span>Register Invoice</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            
            <?php if((strpos($_SESSION['AccessModule'], "Process PO") !== false)) { ?>
                  <li><a href="invoicespaid"><i class="fa fa-money text-green"></i> <span>Paid Invoice</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            
             <?php if((strpos($_SESSION['AccessModule'], "Process PO") !== false)) { ?>
                  <li><a href="invoices"><i class="fa fa-cog text-yellow"></i> <span>Treat Invoice</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            
              <?php if((strpos($_SESSION['AccessModule'], "Process PO") !== false)) { ?>
                  <li><a href="invoicespro"><i class="fa fa-cog text-info"></i> <span>Processing Invoice</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            </ul>
</li>

            <?php if((strpos($_SESSION['AccessModule'], "Treat Procurement") !== false) || (strpos($_SESSION['AccessModule'], "Warehouse") !== false) )  { ?>
                  <li><a href="../requisition/allmat" target="_blank"><i class="fa fa-check text-lemon"></i> <span>All PDFs</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>
            
            <?php if((strpos($_SESSION['AccessModule'], "Treat Procurement") !== false))  { ?>
                  <li><a href="treatpdf"><i class="fa fa-check text-blue"></i> <span>Treat PDFs</span> <small class="label pull-right bg-green">On</small></a></li>
            <?php } ?>

            

        
			
		<!--	<li class="treeview">
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
           -->   
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
