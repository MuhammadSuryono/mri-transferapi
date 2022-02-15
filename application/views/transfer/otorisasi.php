<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>List Otorisasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Transfer</li>
            <li class="breadcrumb-item active">List Otorisasi</li>
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
            <div class="form-group">
                <label><b>Search : </b></label>
                <form action="<?php echo base_url('transfer/otorisasi')?>" method="get">
                    <input type="date" class="startdate" placeholder="Start Date" id="start_date" name="start_date" >
                    <span> S/D </span>
                    <input type="date" class="enddate" placeholder="End Date" id="end_date" name="end_date">
                    &nbsp;
                    <button class="btn-primary" type="submit">Search</button>
                </form>
            </div>

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
          <!-- /.card-header -->
          <div class="card-body">
            <form action="<?php echo base_url('transfer/prosesotorisasi') ?>" method="post" id="form-delete">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><input type="checkbox" id="check-all" name="check-all"></th>
                      <th>No.</th>
                      <th>Request ID</th>
                      <th>TRF. Type</th>
                      <th>Jenis Pembayaran</th>
                      <th>Jadwal Transfer</th>
                      <th>No. Rekening</th>
                      <th>Jumlah</th>
                      <th>Ket. Transfer</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if( ! empty($getallotorisasi)){
                        $i = 1;
                        // error_reporting(0);
                        foreach($getallotorisasi as $data){

                          if($data->transfer_type == 1){
                          $transfer_type = 'Transfer Schedule';
                          }else if($data->transfer_type == 2){
                            $transfer_type = 'Transfer Manual';
                          }else{
                            $transfer_type = 'Transfer Auto';
                          }

                        echo "<tr>";
                        echo "<td><input type='checkbox' class='check-item' name='transfer_id[]' value='".$data->transfer_id."'></td>";
                        echo "<td>".$i++."</td>";
                        echo "<td>".$data->transfer_req_id."</td>";
                        echo "<td>".$transfer_type."</td>";
                        echo "<td>".$data->jenispembayaran."</td>";
                        echo "<td>".$data->jadwal_transfer."</td>";
                        echo "<td>".$data->norek."</td>";
                        echo "<td>".number_format($data->jumlah, 0 , '' , ',' )."</td>";
                        echo "<td>".$data->ket_transfer."</td>";
                        echo "<td><a class='Update' href='' 

                            data-transferreqid='$data->transfer_req_id'
                            data-transfertype='$transfer_type'
                            data-jenispembayaran='$data->jenispembayaran'
                            data-keterangan='$data->keterangan'
                            data-wakturequest='$data->waktu_request'
                            data-jadwaltransfer='$data->jadwal_transfer'
                            data-norek='$data->norek'
                            data-pemilikrekening='$data->pemilik_rekening'
                            data-bank='$data->bank'
                            data-kodebank='$data->kode_bank'
                            data-jumlah='number_format( $data->jumlah, 0 , '' , ',' )'
                            data-kettransfer='$data->ket_transfer'
                            data-nmpembuat='$data->nm_pembuat'
                            data-nmvalidasi='$data->nm_validasi'
                            data-nmotorisasi='$data->nm_otorisasi'
                            data-nmmanual='$data->nm_manual'
                            data-jenisproject='$data->jenis_project'
                            data-nmproject='$data->nm_project'




                        ><i class='fa fa-eye'></i> view</a></td>";
                        echo "</tr>";
                        }
                      }
                      ?>
                  </tbody>
                </table>
              </div>
            <br>
            <button type="submit" id="btn-delete" name="btn-delete" class="btn btn-success btn-small">Otorisasi</button>
            
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
                                  <input type="text" class="form-control" id="transferreqid">
                                
                              </div>
                              <div class="form-group">
                                  <label for="transfertype">TRF. Type</label>
                                  <input type="text" class="form-control" id="transfertype">
                                
                              </div>
                              <div class="form-group">
                                  <label for="jenispembayaran">Jenis Pembayaran</label>
                                  <input type="text" class="form-control" id="jenispembayaran">
                                
                              </div>
                              <div class="form-group">
                                  <label for="keterangan">Keterangan</label>
                                  <input type="text" class="form-control" id="keterangan">
                                
                              </div>
                              <div class="form-group">
                                  <label for="wakturequest">Waktu Request</label>
                                  <input type="text" class="form-control" id="wakturequest">
                                
                              </div>
                              <div class="form-group">
                                  <label for="jadwaltransfer">Jadwal Transfer</label>
                                  <input type="text" class="form-control" id="jadwaltransfer">
                                
                              </div>
                              <div class="form-group">
                                  <label for="norek">No. Rekening</label>
                                  <input type="text" class="form-control" id="norek">
                                
                              </div>
                              <div class="form-group">
                                  <label for="pemilikrekening">Nama Rekening</label>
                                  <input type="text" class="form-control" id="pemilikrekening">
                                
                              </div>
                              <div class="form-group">
                                  <label for="bank">Bank</label>
                                  <input type="text" class="form-control" id="bank">
                                
                              </div>
                              <div class="form-group">
                                  <label for="kodebank">Kode Bank</label>
                                  <input type="text" class="form-control" id="kodebank">
                                
                              </div>
                              <div class="form-group">
                                  <label for="jumlah">Jumlah</label>
                                  <input type="text" class="form-control" id="jumlah">
                                
                              </div>
                              <div class="form-group">
                                  <label for="kettransfer">Ket. Transfer</label>
                                  <input type="text" class="form-control" id="kettransfer">
                                
                              </div>
                              <div class="form-group">
                                  <label for="nmpembuat">Nama Pembuat</label>
                                  <input type="text" class="form-control" id="nmpembuat">
                                
                              </div>
                              <div class="form-group">
                                  <label for="nmvalidasi">Nama Validasi</label>
                                  <input type="text" class="form-control" id="nmvalidasi">
                                
                              </div>
                              <div class="form-group">
                                  <label for="nmotorisasi">Nama Otorisasi</label>
                                  <input type="text" class="form-control" id="nmotorisasi">
                                
                              </div>
                              <div class="form-group">
                                  <label for="nmmanual">Nama Manual</label>
                                  <input type="text" class="form-control" id="nmmanual">
                                
                              </div>
                              <div class="form-group">
                                  <label for="jenisproject">Jenis Project</label>
                                  <input type="text" class="form-control" id="jenisproject">
                                
                              </div>
                              <div class="form-group">
                                  <label for="nmproject">Nama Project</label>
                                  <input type="text" class="form-control" id="nmproject">
                                
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
