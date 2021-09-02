<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Dashboard | Baseline Motion</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
	<meta name="robots" content="noindex,nofollow">
	
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/bootstrap/dist/css/bootstrap.min.css">
	
	<!-- Toastr -->
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/toastr/css/toastr.min.css">
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/font-awesome/css/font-awesome.min.css">
	
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/Ionicons/css/ionicons.min.css">
	
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/jvectormap/jquery-jvectormap.css">
  
	<?php $this->load->view('template/page_level_styles'); ?>
  
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>public/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=base_url()?>public/dist/css/custom.css?751">
	<link rel="stylesheet" href="<?=base_url()?>public/bower_components/select2/dist/css/select2.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  
	<link rel="stylesheet" href="<?=base_url()?>public/dist/css/skins/_all-skins.min.css">
	<link rel="icon" href="<?=base_url()?>public/images/Icon-Black.png" sizes="32x32" />
  
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition sidebar-mini skin-blue-light">
<div class="wrapper">
	<?php $this->load->library('session'); ?>
	<header class="main-header">
	
		<!-- Logo -->
		<a href="<?=base_url()?>dashboard/" class="logo">
			<img src="<?=base_url()?>public/images/logo-white.png" style="max-width:100%;max-height: 100%;"/>
		</a>

		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu" style="display:none;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?php if($this->session->userdata("profile_pic")!="") { ?>
								<img src="<?=base_url()?>public/images/kinetisense/<?= $this->session->userdata("patientid"); ?>/<?= $this->session->userdata("profile_pic"); ?>" class="user-image" alt="<?php print_r($this->session->userdata("username")); ?>">
							<?php } else { ?>
								<img src="<?=base_url()?>public/images/baseline-icon.png" class="user-image" alt="<?php print_r($this->session->userdata("username")); ?>">
							<?php } ?>
							
							<span class="hidden-xs"><?php print_r($this->session->userdata("username")); ?></span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<?php if($this->session->userdata("profile_pic")!="") { ?>
									<img src="<?=base_url()?>public/images/kinetisense/<?= $this->session->userdata("patientid"); ?>/<?= $this->session->userdata("profile_pic"); ?>" class="img-circle" alt="<?php print_r($this->session->userdata("username")); ?>">
								<?php } else { ?>
									<img src="<?=base_url()?>public/images/baseline-icon.png" class="img-circle" alt="<?php print_r($this->session->userdata("username")); ?>">
								<?php } ?>
								<p>
									<?php print_r($this->session->userdata("username")); ?>
								</p>
							</li>
							<!-- Menu Body -->
							<!-- <li class="user-body">
								<div class="row">
								  <div class="col-xs-4 text-center">
									<a href="#">Followers</a>
								  </div>
								  <div class="col-xs-4 text-center">
									<a href="#">Sales</a>
								  </div>
								  <div class="col-xs-4 text-center">
									<a href="#">Friends</a>
								  </div>
								</div>
							</li> -->
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="#" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Logout</a>
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
			<!-- Sidebar user panel -->
			<div class="user-panel" style="display: flex; flex-direction: row; align-items: center;">
				<div class="pull-left image">
					<?php if($this->session->userdata("profile_pic")!="") { ?>
						<img src="<?=base_url()?>public/images/kinetisense/<?= $this->session->userdata("patientid"); ?>/<?= $this->session->userdata("profile_pic"); ?>" class="user-image" alt="User Image">
					<?php } else { ?>
						<img src="<?=base_url()?>public/images/baseline-icon.png" class="user-image" alt="User Image">
					<?php } ?>
				</div>
				<div class="pull-left info">
					<p style="margin-bottom: 0;"><?php print_r($this->session->userdata("username")); ?></p>
					<!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
				</div>
			</div>
			
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<li class="active">
					<a href="<?=base_url()?>dashboard/">
						<span>Dashboard</span>
					</a>
				</li>
				<li id="assesslinkmenu">
					<a href="<?=base_url()?>dashboard/assessments">
						<span>Assessments</span>
					</a>
				</li>
				<li id="videolinkmenu">
					<a href="<?=base_url()?>workout_videos/workouts">
						<span>Video Analysis</span>
					</a>
				</li>
				<li id="workoutlinkmenu">
					<a href="<?=base_url()?>dashboard/workout">
						<span>My Workouts</span>
					</a>
				</li>
				<?php if($this->session->userdata("user_type") == 2){ ?>
					<li id='csvimportmenu'>
						<a href="<?=base_url()?>csv_import">
							<span>Import Scores</span>
						</a>
					</li>
					<li id="videosmenulink">
						<a href="<?=base_url()?>workout_videos">
							<span>Manage Videos</span>
						</a>
					</li>
					<li id="manageworkoutlinkmenu">
						<a href="<?=base_url()?>workouts">
							<span>Manage Workouts</span>
						</a>
					</li>
				<?php } ?>
				<li class="">
					<a style="opacity: 0.6;" href="<?=base_url()?>logout/">
						<span>Logout</span>
					</a>
				</li>
			</ul>
			
		</section>
		<!-- /.sidebar -->
	</aside>
	<script> var selectedlink = ''; </script>