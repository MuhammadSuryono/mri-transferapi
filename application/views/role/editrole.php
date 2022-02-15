<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Role</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Role</li>
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
            <form action="<?php echo base_url('role/proseseditrole/'.$getallrolenya['roleid']. '') ?>" method="POST">
            <div class="form-group">
              <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Role Name :</label>
                          <input type="text" class="form-control" name="role" value="<?php echo $getallrolenya['role']; ?>" required>
                        </div>

                        <div class="form-group">
                          <label>Level :</label>
                          <input type="number" class="form-control" name="level" value="<?php echo $getallrolenya['level']; ?>" required>
                        </div>

                        

                    <br/>

                    <a class="btn btn-small btn-danger" href="<?php echo site_url('role/listrole') ?>">Back</a>
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
