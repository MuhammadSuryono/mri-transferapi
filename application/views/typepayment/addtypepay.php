<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Type Payment</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Type Payment</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
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
          </div>
          <div class="card-body">
            <form action="<?php echo base_url('typepay/prosesaddtypepay')?>" method="POST">
            <div class="form-group">
              <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Type Payment:</label>
                      <input type="text" placeholder="Type Payment" class="form-control" name="jenispembayaran" required>
                    </div>

                    <div class="form-group">
                      <label>Max. Transfer :</label>
                      <input type="number" placeholder="Max Transfer" class="form-control" name="max_transfer" required>
                    </div>

                    

                    <br/>

                    <a class="btn btn-small btn-danger" href="<?php echo site_url('typepay/listtypepay') ?>">Back</a>
                    <button type="submit" class="btn btn-success btn-small">Submit</button>
                        
                    </div>
                </div>
            </div>


        </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->


      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
