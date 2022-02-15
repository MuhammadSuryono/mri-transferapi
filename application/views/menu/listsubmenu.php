<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List SubMenu</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List SubMenu</li>
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
            <a href="<?php echo base_url('user/adduser') ?>" data-toggle="modal" data-target="#newModal">
                <i class="fas fa-plus"></i> Add New</a>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>No.</th>
                <th>Menu</th>
                <th>Sub Menu</th>
                <th>URL</th>
                <th>Icon</th>
                <th>Active</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($listsubmenu as $key) {
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $key['menu']; ?></td>
                  <td><?php echo $key['sub_menu']; ?></td>
                  <td><?php echo $key['url']; ?></td>
                  <td><?php echo $key['icon']; ?></td>
                  <td><?php echo $key['is_active']; ?></td>
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


<!-- Modal -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('menu/prosesaddmenu')?>" method="POST">
            <div class="form-group">
                <input type="text" placeholder="Menu" class="form-control" id="menu" name="menu" required>
            </div>
            <div class="form-group">
                <input type="text" placeholder="URL" class="form-control" id="url" name="url" required>
            </div>
            <div class="form-group">
                <input type="text" placeholder="Icon" class="form-control" id="icon" name="icon" required>
            </div>
            <div class="form-group">
                <select id="is_active" name="is_active" class="form-control" required>
                    <option value="1">Aktif</option>
                    <option value="2">Nonaktif</option>

                </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
      </div>
    </div>
  </div>
</div>
