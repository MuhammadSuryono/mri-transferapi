<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_NAME .": ". ucfirst($this->uri->segment(1)) ." - ". ucfirst($this->uri->segment(2)) ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url() ?>"><b><?php echo SITE_NAME ?></b></a>
  </div>
  <!-- /.login-logo -->

  <?php if ($this->session->flashdata('flash')) : ?>
    <div class="row mt-3">
    <div class="col">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong><?php echo $this->session->flashdata('flash'); ?>.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    </div>
    <?php endif; ?>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Forgot Your Password ?</p>
      <form action="<?php echo base_url('auth/forgot_pass') ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Enter Email Address..." name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-at"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </div>
      </form>
      <p class="text-center">
        <a href="<?php echo base_url('auth') ?>">Back to Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url() ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>dist/js/adminlte.min.js"></script>

</body>
</html>
