<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/libs/cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/libs/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link href="<?php echo base_url(); ?>assets/libs/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/libs/jquery-timepicker-1.3.5/jquery.timepicker.js"></script>
    <link href="<?php echo base_url(); ?>assets/libs/jquery-timepicker-1.3.5/jquery.timepicker.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="alert-dlg" hidden>
    </div>
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>TB</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Team Building</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"> Last Login : <i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <!--
            <li>
              <a href="<?php echo base_url(); ?>dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-plane"></i>
                <span>New Task</span>
              </a>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-ticket"></i>
                <span>My Tasks</span>
              </a>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level One
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li class="treeview">
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>
            -->
            <?php
            if($role == ROLE_ADMIN || $role == ROLE_GAMEMASTER)
            {
            ?>
            <li>
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Users</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>zoomAccountListing" >
                <i class="fa fa-files-o"></i>
                <span>Zoom Accounts</span>
              </a>
            </li>
            <li class="treeview menu-open">
              <a href="#" >
                <i class="fa fa-files-o"></i>
                <span>Zoom Rooms</span>
                <?php
                if (isset($allZoomAccounts) && count($allZoomAccounts) > 0)
                {
                ?>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                <?php
                }
                ?>
              </a>
              <ul class="treeview-menu" style="display:block;">
                <?php
                if (isset($allZoomAccounts) && count($allZoomAccounts) > 0)
                {
                  foreach ($allZoomAccounts as $k => $record)
                  {
                ?>
                    <li><a href="<?php echo base_url(); ?>zoomRoomListing/<?php echo $record->id . "/" . ($k+1) ?>"><i class="fa fa-circle-o"></i>Zoom Account <?php echo ($k+1) . "<br><center>(" . $record->account_name . ")</center>" ?></a></li>
                <?php
                  }
                }
                ?>
              </ul>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>schoolListing" >
                <i class="fa fa-files-o"></i>
                <span>Schools</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>groupListing" >
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
              </a>
            </li>
            <?php
            }
            ?>
            <li>
              <a href="<?php echo base_url(); ?>manageHunt/0" >
                <i class="fa fa-files-o"></i>
                <span>Hunt Management</span>
              </a>
            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>