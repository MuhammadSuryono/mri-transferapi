<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List Role Akses</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List Role Akses</li>
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
            <h5>Role : <?php echo ucwords($role['role']); ?></h5>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No</th>
                <th>Menu</th>
                <th>SubMenu</th>
                <th>Access</th>
              </tr>
              </thead>
              <tbody>
               
                <tr>
                  <?php
                  $i=1;
                  foreach ($listmenu as $m) {
                  ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo ucwords($m['menu']); ?></td>
                    <td><?php echo ucwords($m['sub_menu']); ?></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?php echo check_access($role['roleid'], $m['menuid'], $m['submenuid']); ?> 
                            data-roleid = "<?php echo $role['roleid'];?>" 
                            data-menuid = "<?php echo $m['menuid'];?>" 
                            data-submenuid = "<?php echo $m['submenuid'];?>">
                        </div>
                    </td>
                  </tr>
                  <?php
                  }
                  ?>
                </tr>
                
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