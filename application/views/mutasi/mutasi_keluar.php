<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mutasi Keluar</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Mutasi</li>
            <li class="breadcrumb-item active">Mutasi Keluar</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="callout callout-info">
            <h5>Saldo : <?php echo 'Rp. ' . number_format( $infobal['saldo'], 0 , '' , ',' ); ?></h5>
        </div>
        <div class="card">
          <!-- <div class="card-header">
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
          </div> -->
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-hover" >
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Request ID</th>
                  <th>Jenis Pembayaran</th>
                  <th>Nama</th>
                  <th>Bank</th>
                  <th>No. Rekening</th>
                  <th>Saldo Awal</th>
                  <th>Jumlah Transfer</th>
                  <th>Biaya Transfer</th>
                  <th>Saldo Akhir</th>
                  <th>Ket. Transfer</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  error_reporting(0);
                  foreach ($getalltransfer as $data):
                  ?>
                  <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo $data['transfer_req_id'] ?></td>
                    <td><?php echo $data['jenispembayaran'] ?></td>
                    <td><?php echo $data['pemilik_rekening'] ?></td>
                    <td><?php echo $data['bank'] ?></td>
                    <td><?php echo $data['norek'] ?></td>
                    <td><?php echo number_format( $data['saldo_awal'], 0 , '' , ',' ); ?></td>
                    <td><?php echo number_format( $data['jumlah'], 0 , '' , ',' ); ?></td>
                    <td><?php echo number_format( $data['biaya_trf'], 0 , '' , ',' ); ?></td>
                    <td><?php echo number_format( $data['saldo_akhir'], 0 , '' , ',' ); ?></td>
                    <td><?php echo $data['ket_transfer'] ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

              
            </div>
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
