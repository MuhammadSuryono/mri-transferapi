<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Session Key BCA</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Session Key BCA</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">

        <!-- jquery validation -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input <small>Session key</small></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <?php if ($this->session->flashdata('flash')) : ?>
            <div class="row mt-3">
              <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong><?php echo $this->session->flashdata('flash'); ?>.</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <form role="form" action="<?php echo base_url('token/getsessiontoken') ?>" method="POST">
            <div class="card-body">
              <div class="form-group">
                <label for="client_id">Client ID:</label>
                <input type="password" name="client_id" id="client_id" class="form-control" placeholder="Enter Client ID">
              </div>
              <div class="form-group">
                <label for="client_secret">Client Secret:</label>
                <input type="password" name="client_secret" id="client_secret" class="form-control" placeholder="Enter Client Secret">
              </div>
              <div class="form-group">
                <label for="token">Session Key BCA :</label>
                <input type="password" name="token" id="token" class="form-control" placeholder="Enter Token" required>
              </div>
              <div class="form-group">
                <label for="api_secret">Session API Secret:</label>
                <input type="password" name="api_secret" id="api_secret" class="form-control" placeholder="Enter Api Secret">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a class="btn btn-small btn-danger" href="<?php echo base_url('token/unseter') ?>">Unset Session</a>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">

      </div>
      <!--/.col (right) -->


    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->