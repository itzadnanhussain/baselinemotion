<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Forgot Password | Baseline Motion</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="robots" content="noindex,nofollow">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url()?>public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>public/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>public/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>public/plugins/iCheck/square/blue.css">
  
  <link rel="stylesheet" href="<?=base_url()?>public/dist/css/custom.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">

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
<body class="hold-transition login-page signup-req">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?=base_url(); ?>public/images/logo-black.png" alt="Baseline Motion" style="max-width:100%;"/></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h3 class="login-box-msg primary-color">Forgot Password</h3>
    <?php
    $attributes = array('class' => 'forgetpw-form', 'id' => 'forgetpw-form');
    echo form_open('login/chkEmail', $attributes);
    ?>
    <?php 
    echo form_error('password'); 
    echo form_error('email');
    if ($this->session->flashdata('msg_class') == "success") {
        ?>
        <div class="alert alert-success alert-message">
            <?php echo $this->session->flashdata('msg'); ?>
        </div>

        <?php
    } else if ($this->session->flashdata('msg_class') == "failure") {
        ?>
        <div class="alert alert-danger alert-message">
        <?php echo $this->session->flashdata('msg'); ?>
        </div>
        <?php
    }
    ?>
        <div class="form-group has-feedback">
			<?php
				$username = set_value('email', NULL);
				echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Please enter your email', 'autocomplete' => 'off', 'required' => 'required'), $username);
			?>
            
			<!-- <input type="email" class="form-control" placeholder="Email"> -->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        
	<div class="row text-center">
		<div class="col-xs-6 col-xs-offset-3">
            <?php echo form_submit(array('id' => 'signin_submit', 'value' => 'Submit', 'class' => 'btn btn-primary btn-block btn-flat')); ?>
        </div>
	</div>
    <?php echo form_close(); ?>
	
	<hr>
	
	<p class="text-center">If you already have an account,<br/> please <a href="<?=base_url(); ?>login" class="underlineborder">login</a>.</p>
    <!-- /.social-auth-links -->

  </div>
  
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>
<!-- jQuery 3 -->
<script src="<?=base_url()?>public/bower_components/jquery/dist/jquery.js"></script>
<script src="<?=base_url()?>public/bower_components/validate/jquery.validate.min.js"></script>
<script src="<?=base_url()?>public/bower_components/validate/additional-methods.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Toastr -->
<script src="<?=base_url()?>public/bower_components/toastr/js/toastr.min.js"></script>
<script src="<?=base_url()?>public/bower_components/toastr/js/ui-toastr.min.js"></script>

<script src="<?=base_url()?>public/dist/js/signup.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

<!-- iCheck -->
<script src="<?=base_url()?>public/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154875438-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-154875438-1');
</script>
</body>
</html>