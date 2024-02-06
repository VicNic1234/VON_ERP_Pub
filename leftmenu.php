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
              <a href="./">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
			
		
        
         <!--   <?php 
          if ($_SESSION['porA'] == 1) { ?>
           <li class="treeview">
              <a href="../requisition/APOR" target="_blank">
                   <i style="color:#0066FF" class="fa fa-cog"></i><span>Approve PORequisition</span></i>
              </a>
            </li>

       <?php } ?>

     -->
       <!--
       <?php 
       if ($_SESSION['rptQMI'] == 1) { ?>
           <li class="treeview">
              <a href="qmi" target="_blank">
                   <i style="color:#00CC00" class="fa fa-bar-chart"></i><span>Report QMI</span></i>
              </a>
            </li>

       <?php } ?>
        <?php 
       if ($_SESSION['viewQMI'] == 1) { ?>
           <li class="treeview">
              <a href="qmi/view" target="_blank">
                   <i style="color:#FF6600" class="fa fa-eye"></i><span>view QMI</span></i>
              </a>
            </li>

       <?php } ?>
     -->

       <?php if($_SESSION['CEO'] == 1) { ?>
      <li class="treeview">
              <a href="ceo">
                   <i class="fa fa-desktop text-aqua"></i><span>CEO's Dashboard </span> 
                   <small class="label pull-right bg-green">On</small>
              </a>
            </li>
   
      <?php } ?>
      <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Corporate Services</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                 <?php if((strpos($_SESSION['AccessModule'], "HR/Administration") !== false)) { ?>
                  <li><a href="humanresources"><i class="fa fa-users text-green"></i> <span>Human Resources</span> <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>
                 
                  <?php if((strpos($_SESSION['AccessModule'], "Contracts/Procurement") !== false)) { ?>
                  <li><a href="cnp"><i class="fa fa-cogs text-yellow"></i> Contracts & Procurement
                  <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>
                  
                  <?php if((strpos($_SESSION['AccessModule'], "Warehouse") !== false)) { ?>
                  <li><a href="warehouse"><i class="fa fa-bank text-green"></i> Warehouse
                  <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>
                  
                 

                  <!--
                  <?php if((strpos($_SESSION['AccessModule'], "Corporate/Communication") !== false)) { ?>
                  <li><a href=""><i class="fa fa-book text-white"></i> Corporate Communication</a></li>
                  <?php } ?>
-->
                  <?php if((strpos($_SESSION['AccessModule'], "ICT") !== false)) { ?>
                  <li><a href="ict"><i class="fa fa-file text-aqua"></i> ICT <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Legal") !== false)) { ?>
                  <li><a href="legal"><i class="fa fa-file text-green"></i> Legal <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Strategy/Innovation") !== false)) { ?>
                  <li><a href="strategy"><i class="fa fa-pie-chart text-green"></i> Strategy/Innovation
                  <small class="label pull-right bg-green">On</small></a>
                  </li>
                  <?php } ?>
              </ul>
        </li>


        <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Finance/Accounts</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if((strpos($_SESSION['AccessModule'], "Account") !== false)) { ?>
                  <li><a href="accounts"><i class="fa fa-line-chart text-green"></i><span> Accounts/Finance <small class="label pull-right bg-green">On</small></span>
                  </a> </li>
                  <?php } ?>
              </ul>
        </li>

        <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Internal Control/Tax/Risk Mgt</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php if((strpos($_SESSION['AccessModule'], "Internal Audit") !== false)) { ?>
                  <li><a href="internalaudit"><i class="fa fa-edit text-green"></i> Internal Audit <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

              <?php if((strpos($_SESSION['AccessModule'], "Due Diligence") !== false)) { ?>
                  <li><a href="duediligence"><i class="fa fa-edit text-orange"></i> Due Diligence <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>
              </ul>
        </li>


        <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>QHSES</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <?php if((strpos($_SESSION['AccessModule'], "HSE") !== false)) { ?>
                  <li><a href="hse"><i class="fa fa-heart text-blue"></i> HSE <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Security") !== false)) { ?>
                  <li><a href=""><i class="fa fa-key text-green"></i> Security</a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "QA/QC") !== false)) { ?>
                  <li><a href="qaqc"><i class="fa fa-flask text-aqua"></i> QAQC <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Document Control") !== false)) { ?>
                  <li><a href="doccontrol"><i class="fa fa-file text-green"></i> Document Control <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>
              </ul>
        </li>


        <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs text-aqua"></i> <span>Operations</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">

                   <?php if((strpos($_SESSION['AccessModule'], "Bus Dev") !== false)) { ?>
                  <li><a href="busdev"><i class="fa fa-briefcase text-orange"></i> Business Development <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Projects") !== false)) { ?>
                  <li><a href="projects"><i class="fa fa-cogs text-blue"></i> Project Services<small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Asset Management") !== false)) { ?>
                  <li><a href="assetmgt"><i class="fa fa-bank text-aqua"></i> Base & Asset Management<small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Marine/Logistics") !== false)) { ?>
                  <li><a href="marinenlogistics"><i class="fa fa-anchor text-green"></i> Marine & Logistics<small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  <?php if((strpos($_SESSION['AccessModule'], "Deck Mach") !== false)) { ?>
                  <li><a href="deckandmech"><i class="fa fa-magic text-orange"></i> Deck & Machinary<small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

                  
              </ul>
        </li>


    

      
     <?php if((strpos($_SESSION['AccessModule'], "Maintenance") !== false)) { ?>
                  <li><a href="maintain"><i class="fa fa-cog fa-spin fa-1x fa-fw text-green"></i> Maintenance <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

      <?php if((strpos($_SESSION['AccessModule'], "Jetty Services") !== false)) { ?>
                  <li><a href="jettyservices"><i class="fa fa-cog fa-spin fa-1x fa-fw text-aqua"></i> Jetty Services <small class="label pull-right bg-green">On</small></a></li>
                  <?php } ?>

      
      
 

     <?php if((strpos($_SESSION['AccessModule'], "ERP Admin") !== false)) { ?>
      <li class="treeview">
              <a href="users/admin">
                   <i class="fa fa-users text-yellow"></i><span>ERP Admin </span> 
                   <small class="label pull-right bg-green">On</small>
              </a>
            </li>
      <?php } ?>

<!--
     

     

      <?php if((strpos($_SESSION['AccessModule'], "BI") !== false)) { ?>
       <li class="treeview">
              <a href="CEOD">
                   <i class="fa fa-bar-chart"></i><span>CEO's (BI)</span>
              </a>
            </li>
      <?php } ?>
-->
			
			
          <!--  <li><a target="_blank" href="http://support.elchabod.com/ticket?project_code=5a8c7aa1372a0"><i class="fa fa-briefcase text-yellow"></i> <span>Support</span></a></li>-->
           
                              
            <li class="header">USER</li>
            <li><a href="users/mydetails"><i class="fa fa-user text-green"></i> <span>Profile</span></a></li>
            <li><a href="users/logout"></i><i class="fa ion-log-out"></i> <span>Log Out</span></a></li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>