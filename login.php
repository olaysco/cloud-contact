<?php
include_once 'controller/detector.php';
session_start();
if(isset($_SESSION['error'])){
  $error = $_SESSION['error'];
  session_destroy();
}
$max_impact = 2;
$detect = new Detector();
$report = $detect->detect_intrusion($_GET + $_POST + $_REQUEST);
if($detect->impact>$max_impact){
  $_SESSION['report'] = $report;
  header('location: ../error403.php');
  die;
}
?>
<html><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Cloud Contact - login</title>
  <!-- Favicon -->
  <link href="assets//img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets//vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="assets//vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="assets//css/argon.css?v=1.0.0" rel="stylesheet">
  <style>
  .has-error{
	  border:2px solid red;
  }
  </style>
</head><body class="bg-default">
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="" title="About" data-toggle="popover" data-content="CloudContact is a cloud based address book application with inbuilt intrusion detection system that protects the user's data from malicious attack by defined rules" data-placement="bottom">
    <h2 style="color: #fff; text-transform:none;"><i class="fa fa-1x fa-address-book"></i>   CloudContact</h2>
          <!--<img src="assets//img/brand/white.png" class="">-->
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar-collapse-main" style="">
          <!-- Collapse header -->
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a class="navbar-brand" href="" title="About" data-toggle="popover" data-content="CloudContact is a cloud based address book application with inbuilt intrusion detection system that protects the user's data from malicious attack by defined rules" data-placement="bottom">
                 <h2 style="color: #172b4d; text-transform:none;"><i class="fa fa-1x fa-address-book"></i>   CloudContact</h2>
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <!-- Navbar items -->
          <ul class="navbar-nav ml-auto">
            
            
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="register.php">
                <i class="ni ni-user-run"></i>
                <span class="nav-link-inner--text">Register</span>
              </a>
            </li>
            
          </ul>
        </div>
        
        
      </div>
    </nav>
    <!-- Header -->
    
    <!-- Page content -->
    <div class="container " style="
">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8" style="
    margin-top: 150px;
">			<?php if(isset($error['not_match'])) {?>
			<div class="alert alert-warning">
                <strong><?php echo $error['not_match']  ?></strong>
            </div>
        	<?php } ?>
        	<?php if(isset($error['not_found'])) {?>
			<div class="alert alert-danger">
                <strong><?php echo $error['not_found']  ?></strong>
            </div>
        	<?php } ?>
        	<?php if(isset($error['success'])) {?>
			<div class="alert alert-success">
                <strong><?php echo $error['success'] ?></strong>
            </div>
        	<?php } ?>
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-3"><small>Sign in with</small></div>
              <div class="btn-wrapper text-center">
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="assets/img/icons/common/github.svg"></span>
                  <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="assets/img/icons/common/google.svg"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Or sign in with credentials</small>
              </div>
              <form role="form" method="post" action="controller/processor.php">
              	<input type="hidden" name="type" value="login">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative <?php echo (isset($error["email"]))?"has-error":""  ?>">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" name="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative <?php echo (isset($error["password"]))?"has-error":""  ?>">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Sign in</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            © 2018 <a href="github.com/olaysco" class="font-weight-bold ml-1" target="_blank">Olaysco</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="github.com/olaysco" class="nav-link" target="_blank">olaysco</a>
            </li>
            <li class="nav-item">
              <a href="github.com/olaysco" class="nav-link" target="_blank">About Us</a>
            </li>
            
            
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="assets//vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets//vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Argon JS -->
  <script src="assets//js/argon.js?v=1.0.0"></script>

<script>
$(document).ready(function(e) {
	$('[data-toggle="popover"]').click(function(e) {
        e.preventDefault();
    });
    //$('[data-toggle="popover"]').popover();
});
</script>
</body></html>