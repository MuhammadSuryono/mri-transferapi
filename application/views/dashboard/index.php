<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info">
            <p>Klik untuk memperbarui saldo <a class="btn" href="<?php echo base_url('dashboard/getInfobal/')  . $item['rekening']; ?> "><i class="fa fa-sync-alt"></i></a></p>
            <?php foreach ($rekening as $item) : ?>
              <?php $saldo = $this->db->query("SELECT saldo FROM saldo WHERE rekening = '$item[rekening]' ORDER BY datetime DESC LIMIT 1")->row_array(); ?>
              <h5>Saldo Rek. <?= $item['rekening'] ?>: <?= (($saldo['saldo']) ?  'Rp. ' . number_format($saldo['saldo'], 0, '', ',') : 'Data tidak ada') ?>
                &nbsp;
              </h5>
            <?php endforeach; ?>
          </div>


          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Antrian : <b><?php echo $sumdatatrf['trx'] ?></b> Transaksi
              </h3>
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                  <b><?php echo 'Rp. ' . number_format($sumdatatrf['total'], 0, '', ','); ?></b>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Request ID</th>
                        <th>TRF. Type</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jadwal Transfer</th>
                        <th>Nama Penerima</th>
                        <th>No. Rekening</th>
                        <th>Nama Bank</th>
                        <th>Jumlah</th>
                        <th>Nama Project</th>
                        <!-- <th>Ket. Transfer</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 1;
                      foreach ($listantri as $data) :
                        if ($data['transfer_type'] == 1) {
                          $transfer_type = 'Transfer Schedule';
                        } else if ($data['transfer_type'] == 2) {
                          $transfer_type = 'Transfer Manual';
                        } else {
                          $transfer_type = 'Transfer Auto';
                        }
                      ?>
                        <tr>
                          <td><?php echo $i++ ?></td>
                          <td><?php echo $data['transfer_req_id'] ?></td>
                          <td><?php echo $transfer_type ?></td>
                          <td><?php echo $data['jenispembayaran'] ?></td>
                          <td><?php echo $data['jadwal_transfer'] ?></td>
                          <td><?php echo $data['pemilik_rekening'] ?></td>
                          <td><?php echo $data['norek'] ?></td>
                          <td><?php echo $data['bank'] ?></td>
                          <td><?php echo number_format($data['jumlah'], 0, '', ','); ?></td>
                          <td><?php echo $data['nm_project'] ?></td>
                          <!-- <td><?php echo $data['ket_transfer'] ?></td> -->
                          <td><a class="Update" href="" data-transferreqid="<?php echo $data['transfer_req_id'] ?>" data-transfertype="<?php echo $transfer_type ?>" data-jenispembayaran="<?php echo $data['jenispembayaran'] ?>" data-keterangan="<?php echo $data['keterangan'] ?>" data-wakturequest="<?php echo $data['waktu_request'] ?>" data-jadwaltransfer="<?php echo $data['jadwal_transfer'] ?>" data-norek="<?php echo $data['norek'] ?>" data-pemilikrekening="<?php echo $data['pemilik_rekening'] ?>" data-bank="<?php echo $data['bank'] ?>" data-kodebank="<?php echo $data['kode_bank'] ?>" data-jumlah="<?php echo number_format($data['jumlah'], 0, '', ','); ?>" data-kettransfer="<?php echo $data['ket_transfer'] ?>" data-nmpembuat="<?php echo $data['nm_pembuat'] ?>" data-nmvalidasi="<?php echo $data['nm_validasi'] ?>" data-nmotorisasi="<?php echo $data['nm_otorisasi'] ?>" data-nmmanual="<?php echo $data['nm_manual'] ?>" data-jenisproject="<?php echo $data['jenis_project'] ?>" data-nmproject='<?php echo $data['nm_project'] ?>'><i class="fa fa-eye"></i> view</a></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>

                  </table>
                </div>

                <!-- Modal -->
                <div id="myModal" class="modal fade">
                  <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Detail</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                      </div>
                      <div class="modal-body">

                        <form>
                          <div class="form-group">
                            <label for="transferreqid">Request ID</label>
                            <input type="text" class="form-control" readonly id="transferreqid">

                          </div>
                          <div class="form-group">
                            <label for="transfertype">TRF. Type</label>
                            <input type="text" class="form-control" readonly id="transfertype">

                          </div>
                          <div class="form-group">
                            <label for="jenispembayaran">Jenis Pembayaran</label>
                            <input type="text" class="form-control" readonly id="jenispembayaran">

                          </div>
                          <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" readonly id="keterangan">

                          </div>
                          <div class="form-group">
                            <label for="wakturequest">Waktu Request</label>
                            <input type="text" class="form-control" readonly id="wakturequest">

                          </div>
                          <div class="form-group">
                            <label for="jadwaltransfer">Jadwal Transfer</label>
                            <input type="text" class="form-control" readonly id="jadwaltransfer">

                          </div>
                          <div class="form-group">
                            <label for="norek">No. Rekening</label>
                            <input type="text" class="form-control" readonly id="norek">

                          </div>
                          <div class="form-group">
                            <label for="pemilikrekening">Nama Rekening</label>
                            <input type="text" class="form-control" readonly id="pemilikrekening">

                          </div>
                          <div class="form-group">
                            <label for="bank">Bank</label>
                            <input type="text" class="form-control" readonly id="bank">

                          </div>
                          <div class="form-group">
                            <label for="kodebank">Kode Bank</label>
                            <input type="text" class="form-control" readonly id="kodebank">

                          </div>
                          <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="text" class="form-control" readonly id="jumlah">

                          </div>
                          <div class="form-group">
                            <label for="kettransfer">Ket. Transfer</label>
                            <input type="text" class="form-control" readonly id="kettransfer">

                          </div>
                          <div class="form-group">
                            <label for="nmpembuat">Nama Pembuat</label>
                            <input type="text" class="form-control" readonly id="nmpembuat">

                          </div>
                          <div class="form-group">
                            <label for="nmvalidasi">Nama Validasi</label>
                            <input type="text" class="form-control" readonly id="nmvalidasi">

                          </div>
                          <div class="form-group">
                            <label for="nmotorisasi">Nama Otorisasi</label>
                            <input type="text" class="form-control" readonly id="nmotorisasi">

                          </div>
                          <div class="form-group">
                            <label for="nmmanual">Nama Manual</label>
                            <input type="text" class="form-control" readonly id="nmmanual">

                          </div>
                          <div class="form-group">
                            <label for="jenisproject">Jenis Project</label>
                            <input type="text" class="form-control" readonly id="jenisproject">

                          </div>
                          <div class="form-group">
                            <label for="nmproject">Nama Project</label>
                            <input type="text" class="form-control" readonly id="nmproject">

                          </div>

                        </form>





                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- End Modal -->



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