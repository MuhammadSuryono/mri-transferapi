<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add User</li>
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
            <form action="<?php echo base_url('user/prosesadduser')?>" method="POST">
            <div class="form-group">
              <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>User Name:</label>
                      <input type="text" placeholder="User Name" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                      <label>User Login :</label>
                      <input type="email" placeholder="Email address" class="form-control" name="user_login" required>
                    </div>

                    <div class="form-group">
                      <label>Passowrd :</label>
                      <input type="Password" placeholder="Password" class="form-control" name="user_password" required>
                    </div>

                    <div class="form-group">
                      <label>Role :</label>

                      <select name="roleid" class="form-control" required>
                        <option value="">Pilih</option>
                        <?php 
                        foreach ($typerole as $data):
                        ?>
                        <option value="<?php echo $data['roleid'] ?>"><?php echo $data['role'] ?></option>

                        <?php endforeach; ?>
                      </select>


                    </div>

                    <br/>

                    <a class="btn btn-small btn-danger" href="<?php echo site_url('user/listuser') ?>">Back</a>
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
