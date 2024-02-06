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
            <li class="treeview">;
              
              <?php if ($_SESSION['Dept'] == "superadmin") { ?>
              <a href="../cnp">
              <?php } else { ?>
              <a href="./cnp">
              <?php } ?>
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>

			
      <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Goods Stocking</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  
                  <li><a href="stations"><i class="fa fa-map-marker text-green"></i> <span>Locations</span> <small class="label pull-right bg-green">On</small></a></li>
                 
                
                  <li><a href="storages"><i class="fa fa-bank text-yellow"></i> 
                   <span>Storages</span> <small class="label pull-right bg-green">On</small></a></li>
                 
                  <li><a href="bins"><i class="fa fa-database text-white"></i>
                   <span>Bins</span> <small class="label pull-right bg-green">On</small></a></li>

                   <li><a href="itcat"><i class="fa fa-cubes text-blue"></i>
                   <span>Item Categories</span> <small class="label pull-right bg-green">On</small></a></li>

                  <li><a href="stocks"><i class="fa fa-wrench text-white"></i> 
                   <span>Stocks</span> <small class="label pull-right bg-green">On</small></a></li>
                   
                    <li><a href="Sstocks"><i class="fa fa-wrench text-white"></i> 
                   <span>Stocks (Superior)</span> <small class="label pull-right bg-green">On</small></a></li>
                   
                    <li><a href="stockH"><i class="fa fa-edit text-yellow"></i> 
                   <span>Stock History</span> <small class="label pull-right bg-green">On</small></a></li>

              </ul>
        </li> 

          <li><a href="purchaseorders"><i class="fa fa-eye text-aqua"></i> <span>View PO</span> <small class="label pull-right bg-green">On</small></a></li>

          <li><a href="allitems"><i class="fa fa-eye text-yellow"></i> <span>All PO Items</span> <small class="label pull-right bg-green">On</small></a></li>

           <li><a href="newgrnote"><i class="fa fa-file-o text-green"></i> <span>Create Goods Received N.</span> <small class="label pull-right bg-green">On</small></a></li>

            <li><a href="grnotes"><i class="fa fa-eye text-aqua"></i> <span>Goods Recieved Notes</span> <small class="label pull-right bg-green">On</small></a></li>


              <li><a href="newgdnote"><i class="fa fa-file-o text-green"></i> <span>Create Goods Delivery N.</span> <small class="label pull-right bg-green">On</small></a></li>

            <li><a href="gdnote"><i class="fa fa-eye text-aqua"></i> <span>Goods Delivery Notes</span> <small class="label pull-right bg-green">On</small></a></li>
      

      <!--
      <li class="treeview">
              <a href="Qchk">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Track Orders</span>
              </a>
            </li>

        <li class="treeview">
              <a href="dnt">
                   <i class="fa fa-book"></i><span>Delivery Note</span>
              </a>
            </li>

      <li class="treeview">
              <a href="gdn">
                   <i class="fa fa-book"></i><span>Goods Dispatched Note</span>
              </a>
            </li>

      <li class="treeview">
              <a href="grn">
                   <i class="fa fa-book"></i><span>Goods Received Note</span>
              </a>
            </li>
          -->
     <!-- <li class="treeview">
              <a href="msi">
                   <i class="fa fa-book"></i><span>Master Stock Inventory</span></i>
              </a>
            </li>-->
		               
            <li class="header">USER</li>
            <li><a href="../users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            <li><a href="../users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
