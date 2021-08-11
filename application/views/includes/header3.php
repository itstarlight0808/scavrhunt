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

    <link href="<?php echo base_url(); ?>assets/libs/pieceofcake/css/common.css" rel="stylesheet">
    <script>
      $(document).ready(function(){
        let p=3, n=9;
        let m = n*n;
        let html = "<style>";
        for(let i=0; i<n; i++){
          html += `.tile:nth-child(${n}n+${i+1}) { --x : ${i} }`;
          html += `.tile:nth-child(n+${n*i+1}) { --y : ${i} }`;
        }
        html += "</style>";
        html += `<div class="cube" style="--n : ${n}">`;
        for(let i=0; i<p; i++){
          html += `<div class="face" style="${i < p-1 ? "--f:"+i : null}">`;
          for(let j=0; j<m; j++)
            html += "<div class='tile'></div>";
          html += "</div>";
        }
        html += "</div>";
        $(".animated-box").html(html);
      });
    </script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="dot-1 d-none d-lg-block">
      <img src="<?php echo base_url(); ?>assets/images/dot-big.png" alt="banner">           
    </div>
    <div class="dot-2 d-none d-lg-block">
      <img src="<?php echo base_url(); ?>assets/images/dot-big.png" alt="banner">
    </div>
    <div class="dot-3">
      <img src="<?php echo base_url(); ?>assets/images/dot-sm.png" alt="banner">           
    </div>
    <div class="dot-4">
      <img src="<?php echo base_url(); ?>assets/images/dot-sm.png" alt="banner">
    </div>

    <div class="wrapper">
      <div class="animated-box">
      </div>
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SH</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Scavenger Hunt</b></span>
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
                <a class="nav-link" href="<?php echo base_url(); ?>">
                    <span class="link-label">Scavenger Hunt</span>
                </a>
              </li>
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : "Last Login : $last_login"; ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo isset($name) ? $name : ''; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo isset($name) ? $name : ""; ?>
                      <small><?php echo isset($role_text) ? $role_text : ""; ?></small>
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
            <li class="header">HUNT NAVIGATION</li>
            <?php
            //if($role == ROLE_ADMIN || $role == ROLE_GAMEMASTER)
            //{
            ?>
            <li>
              <a href="<?php echo base_url(); ?>">
                <i class="fa fa-users"></i>
                <span>My Team / Play In</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>leaderboard" >
                <i class="fa fa-files-o"></i>
                <span>Leaderboard / Highlight Reel</span>
              </a>
            </li>
            <?php
            //}
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>