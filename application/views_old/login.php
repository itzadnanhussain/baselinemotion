<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in | Baseline Motion</title>
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
  <style>
    label#acceptterms-error {
        padding-top: 2px;
        padding-left: 0;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?=base_url(); ?>public/images/logo-black.png" alt="Baseline Motion" style="max-width:100%;"/></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- <h3 class="login-box-msg primary-color">Client Login</h3> -->
    <?php
    $attributes = array('class' => 'login-form', 'id' => 'login-form');
    echo form_open('login/validate', $attributes);
    ?>
    <?php 
    echo form_error('password'); 
    echo form_error('email');
    echo form_error('user_fname'); 
    echo form_error('user_lname');
    echo form_error('user_email');
    echo form_error('username');
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
			$t = get_cookie('actx_username');
			$t1 = get_cookie('actx_password');
			
			if($t != "")
				$username = set_value('username', $t);
			else
				$username = set_value('username', NULL);
			
            echo form_input(array('name' => 'username', 'class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off', 'required' => 'required'), $username);
            ?>
            <!-- <input type="email" class="form-control" placeholder="Email"> -->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
        <?php
			if($t != "")
				$password = set_value('password', $t1);
			else
				$password = set_value('password', NULL);
			
            echo form_password(array('id' => 'password', 'name' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off', 'required' => 'required'), $password);
            ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
		<div class="row">
			<div class="col-xs-12">
              <div class="checkbox icheck">
                <label>
                  <?php echo form_checkbox(array('name' => 'acceptterms', 'value' => '1', 'required' => 'required')); ?>  Please accept the <a data-toggle="modal" data-target="#modal-default"> Privacy Policy</a>
				</label>
              </div>
            </div>
		</div>
        <div class="row">
            <div class="col-xs-6">
              <div class="checkbox icheck">
                <label>
                  <?php echo form_checkbox(array('name' => 'remember', 'value' => '1')); ?>  Remember Me
                </label>
              </div>
            </div>
        <!-- /.col -->
            <div class="col-xs-6 pull-right text-right" style="padding: 10px 15px; margin-bottom: 10px;">
				<a href="<?=base_url()?>login/forgotpassword" class="underlineborder">Forgot Password?</a>
            </div>
        <!-- /.col -->

    </div>
	<div class="row text-center">
		<div class="col-xs-6 col-xs-offset-3">
            <?php echo form_submit(array('id' => 'signin_submit', 'value' => 'Sign In', 'class' => 'btn btn-primary btn-block btn-flat')); ?>
        </div>
	</div>
    <?php echo form_close(); ?>
	
	<hr>
	
	<p class="text-center">If you do not have an account,<br/> please reach out to us <a href="<?=base_url()?>login/signupreq" class="underlineborder">here</a>.</p>
    <!-- /.social-auth-links -->
	<div class="modal fade" id="modal-default" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content" style="color:black;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h4 class="modal-title">Web Site Privacy Policy</h4>
				</div>
				<div class="modal-body">
					<p>Baselinemotion.com ('Company') is committed to protecting the privacy of our customer's personal information. This statement applies with respect to the information that we collect from the Company Web site, located at <a href="https://baselinemotion.com/" target="_blank">www.baselinemotion.com</a>. Amendments to this statement will be posted at this URL and will be effective when posted. Your continued use of this site following the posting of any amendment, modification or change shall constitute your acceptance thereof.</p>
					
					<p><b>I. INFORMATION COLLECTED</b></p>
					
					<p>We collect non-personally identifiable information about you in a number of ways, including tracking your activities through your IP address, computer settings or most-recently visited URL. We may also ask you to provide certain non-personally identifiable information about yourself, such as your age, household income, buying preferences, etc. We do not collect any personally identifiable information about you unless you voluntarily submit such information to us, by, for example, filling out a survey or registration form. The types of information that may be requested include your name, address, e-mail address, and telephone number.</p>

					<p><b>II. USE OF INFORMATION</b></p>

					<p>In general, we will only use the information you provide to us for the purpose for which such information was provided. We may also use this information to deliver to you information about our company and promotional material from some of our partners, trend analysis, pattern detection, and site administration. Your information may also be used to contact you when necessary and may be shared with other companies that may want to contact you with offers consistent with your stated preferences. Users may opt-out of receiving future mailings from Company and other entities by following the instructions set forth in the opt-out section below.</p>
					<p>Non-personal demographic and profile data is used to tailor your experience at our site, showing you content we think you might be interested in. This information may also be shared with advertisers on an aggregate non-personal basis.</p>

					<p><b>III. USE OF IP ADDRESSES</b></p>

					<p>We use your IP Address to help diagnose problems with our server, and to administer our Web site.</p>

					<p><b>IV. USE OF COOKIES</b></p>

					<p>When you view our Web site we might store some information on your computer. This information will be in the form of a "cookie" or similar file. Cookies are small pieces of information stored on your hard drive, not on our site. Cookies do not spy on you or otherwise invade your privacy, and they cannot invade your hard drive and steal information. Rather, they help you navigate a Web site as easily as possible. We use cookies to deliver content specific to your interests and to prevent you from reentering all your registration data at each connection.</p>
					<p>We use an outside advertisement server company to display ads on our site. These ads may contain cookies. The advertisement server company may collect cookies received with outside banner ads. We do not have access to information that would confirm the use of cookies by the advertisement server company.</p>

					<p><b>V. SECURITY</b></p>

					<p>Our site has industry standard security measures in place to protect the loss, misuse and alteration of the information under our control. While there is no such thing as "perfect security" on the Internet, we will take all reasonable steps to insure the safety of your personal information.</p>

					<p><b>VI. OTHER WEB SITES; LINKS</b></p>

					<p>Our Web site contains links to other Web sites. Baseline Motion is not responsible for the privacy practices or the content of such Web sites.</p>

					<p><b>VII. CORRECT; UPDATE</b></p>

					<p>Baseline Motion allows its users the option to change or modify information previously provided. This may be done through the following methods:</p>

					<ul>
						<li>e-mail the information to <a href="mailto:derek@baselinemotion.com">derek@baselinemotion.com</a></li>
						<li>visit the Customer Service section of the site and follow the appropriate instructions.</li>
					</ul>

					<p>Unfortunately, to the extent that such information is also stored in other databases, we cannot always ensure that such corrections or deletions will reach the other databases. We will use all reasonable efforts to ensure that your information is removed from or corrected in our records.</p>

					<p><b>VIII. CHOICE; OPT OUT</b></p>

					<p>You may opt-out of receiving communications from our partners, and from us, by the following means:</p>

					<ul>
						<li>send an e-mail to <a href="mailto:derek@baselinemotion.com">derek@baselinemotion.com</a></li>
						<li>visit the Customer Service section of the site and follow the appropriate instructions.</li>
					</ul>

					<p><b>IX. PUBLIC FORUMS</b></p>

					<p>This site makes chat rooms, forums, message boards, and/or news groups available to its users. Please remember that any information that is disclosed in these areas becomes public information and you should exercise caution when deciding to disclose your personal information.</p>



					<h3>Privacy Policy Notice for Children Under 13 Years Old</h3>


					<p>We at Baseline Motion want everyone's visit here to be enjoyable and safe. This statement (the "Policy") tells you what information we collect from the www.baselinemotion.com Web site (the "Site"), and how we maintain and use such information. Except for material changes to this policy (in which case we will notify you personally), if we make any changes to this Policy, they will be posted on this page and will be effective when posted. Your continued use of this Site following the posting of any change shows your acceptance of the changes.</p>

					<p><b>KIDS!!</b></p>

					<p>In order to participate in certain areas on our Site, you may be asked to provide certain information about yourself. Depending on the activity that you want to participate in, you may first be required to get your parent's permission. At the time you sign up to participate in a certain activity, you will be told whether or not you need permission. When you send us a question or comment, we will only use your e-mail address to respond to you. Once we respond to you, we will delete your e-mail address from our files. If you are ever unsure about using this Site or any other Web Site, be sure to check with your parent or guardian.</p>

					<p>Remember, always check with your parent or guardian when surfing the net!</p>

					<p><b>PARENTS NOTICE</b></p>

					<p>It is important for you to talk with your child about using the Internet safely. Here are just a few things to keep in mind when talking to your kids about the Internet:</p>
					<ul>
						<li>Remind your child to never give out his or her full name, address, or phone number without your permission.</li>
						<li>Tell your child that if he or she receives something that he or she is not sure about, to let you know.</li>
						<li>Impress upon your child the importance of never engaging others in a communication that would put him or her at risk, such as agreeing to meet someone he or she has been "chatting" with, but never met.</li>
					</ul>

					<p>We will not condition a child's participation in a certain activity on the site on the child's providing more personal information than is necessary in order to allow such participation.</p>

					<p><b>OUR GENERAL PRIVACY POLICY</b> <a target="_blank" href="http://baselinemotion.com/privacy">www.baselinemotion.com/privacy</a></p>

					<p><b>Contacting us:</b></p>

					<p>If you have any questions about this privacy statement, the practices of this site, or your dealings with this Web site, you can contact us at <a href="mailto:derek@baselinemotion.com">derek@baselinemotion.com</a>.</p>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  </div>
  
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url()?>public/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url()?>public/bower_components/validate/jquery.validate.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
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

<script>
  jQuery(document).ready(function(){
    jQuery("#login-form").validate({
      errorPlacement: function(error, element) {
            if (element[0].name == 'acceptterms') {
                error.appendTo(element.closest('label'));
            }
            else {
                error.insertAfter(element);
            }
        }
    });
  });
</script>
</body>
</html>