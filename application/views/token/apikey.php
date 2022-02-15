<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>API Key</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">API Key</li>
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
            <h3 class="card-title">Input <small>API key</small></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
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
          <form role="form" action="<?php echo base_url('token/prosestoken') ?>" method="POST">
            <div class="card-body">
              <div class="form-group">
                <label for="client_id">Client ID:</label>
                <input type="password" name="client_id" id="client_id" class="form-control" placeholder="Enter Client ID">
              </div>
              <div class="form-group">
                <label for="token">Key BCA:</label>
                <input type="password" name="token" id="token" class="form-control" placeholder="Enter Token">
              </div>
              <div class="form-group">
                <label for="client_secret">Client Secret:</label>
                <input type="password" name="client_secret" id="client_secret" class="form-control" placeholder="Enter Client Secret">
              </div>
              <div class="form-group">
                <label for="api_secret">API Secret:</label>
                <input type="password" name="api_secret" id="api_secret" class="form-control" placeholder="Enter Api Secret">
              </div>
              <div class="form-group">
                <label for="corporate_id">Corporate ID:</label>
                <input type="password" name="corporate_id" id="corporate_id" class="form-control" placeholder="Enter Corporate ID">
              </div>
              <!-- <div class="form-group">
                <label for="account_number">Account Number:</label>
                <input type="password" name="account_number" id="account_number" class="form-control" placeholder="Enter Account Number">
              </div> -->
              <div class="form-group">
                <label for="channel_id">Channel ID:</label>
                <input type="password" name="channel_id" id="channel_id" class="form-control" placeholder="Enter Channel ID">
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <a class="tombol-hapus btn btn-small btn-danger" href="<?php echo base_url('token/delete') ?>">Delete</a>
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