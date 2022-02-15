<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List User</li>
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
            <a href="<?php echo base_url('user/adduser') ?>"><i class="fas fa-plus"></i> Add New</a>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role Level</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($getlistuser as $key) {
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $key['nama']; ?></td>
                  <td><?php echo $key['username']; ?></td>
                  <td><?php echo $key['user_login']; ?></td>
                  <td><?php echo $key['roleid']; ?></td>
                  <td><a href="<?php echo base_url('user/deleteuser/'.$key['id'].'') ?>"><i class="fa fa-trash"></i>Hapus</a> 
                      <a href="<?php echo base_url('user/edituser/'.$key['id'].'') ?>"><i class="fa fa-edit"></i>Edit</a>
                  </td>
                </tr>
                <?php
                }
                ?>
              </tbody>
              
            </table>
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
