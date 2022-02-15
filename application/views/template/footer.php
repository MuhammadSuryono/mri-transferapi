<footer class="main-footer">
  <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo site_url() ?>"><?php echo SITE_NAME ?></a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- SweetAlert -->
<script src="<?php echo base_url('plugins/sweet/') ?>js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url('dist/') ?>js.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<script src="<?php echo base_url('plugins/')?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('plugins/')?>bootstrap-datepicker/js/costum.js"></script>
<script>
  $(document).ready(function(){
      setDatePicker()
      setDateRangePicker(".startdate", ".enddate")
      setMonthPicker()
      setYearPicker()
      setYearRangePicker(".startyear", ".endyear")
  })

  $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
              $("#check-all").click(function(){ // Ketika user men-cek checkbox all
                if($(this).is(":checked")) // Jika checkbox all diceklis
                  $(".check-item").prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
                else // Jika checkbox all tidak diceklis
                  $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
              });

              $("#btn-delete").click(function(){ // Ketika user mengklik tombol delete
                var confirm = window.confirm("Apakah Anda yakin?"); // Buat sebuah alert konfirmasi

                if(confirm) // Jika user mengklik tombol "Ok"
                  $("#form-delete").submit(); // Submit form
              });
            });
  
  $('.form-check-input').on('click', function(){
        const roleid = $(this).data('roleid');
        const menuid = $(this).data('menuid');
        const submenuid = $(this).data('submenuid');

        $.ajax({
            url: "<?php echo base_url('role/changeaccess'); ?>",
            type: 'post',
            data: {
                roleid:roleid,
                menuid:menuid,
                submenuid:submenuid
            },
            success: function() {
                document.location.href = "<?php echo base_url('role/aksesrole/'); ?>" + roleid;
            }
        })
    })


  $(function () {
        $("a[class='Update']").click(function () {
            $('#myModal').modal("show");

            var transferreqid = $(this).attr('data-transferreqid')
            var transfertype = $(this).attr('data-transfertype')
            var jenispembayaran = $(this).attr('data-jenispembayaran')
            var keterangan = $(this).attr('data-keterangan')
            var wakturequest = $(this).attr('data-wakturequest')
            var jadwaltransfer = $(this).attr('data-jadwaltransfer')
            var norek = $(this).attr('data-norek')
            var pemilikrekening = $(this).attr('data-pemilikrekening')
            var bank = $(this).attr('data-bank')
            var kodebank = $(this).attr('data-kodebank')
            var jumlah = $(this).attr('data-jumlah')
            var kettransfer = $(this).attr('data-kettransfer')
            var nmpembuat = $(this).attr('data-nmpembuat')
            var nmvalidasi = $(this).attr('data-nmvalidasi')
            var nmotorisasi = $(this).attr('data-nmotorisasi')
            var nmmanual = $(this).attr('data-nmmanual')
            var jenisproject = $(this).attr('data-jenisproject')
            var nmproject = $(this).attr('data-nmproject')
            $('#transferreqid').val(transferreqid)
            $('#transfertype').val(transfertype)
            $('#jenispembayaran').val(jenispembayaran)
            $('#keterangan').val(keterangan)
            $('#wakturequest').val(wakturequest)
            $('#jadwaltransfer').val(jadwaltransfer)
            $('#norek').val(norek)
            $('#pemilikrekening').val(pemilikrekening)
            $('#bank').val(bank)
            $('#kodebank').val(kodebank)
            $('#jumlah').val(jumlah)
            $('#kettransfer').val(kettransfer)
            $('#nmpembuat').val(nmpembuat)
            $('#nmvalidasi').val(nmvalidasi)
            $('#nmotorisasi').val(nmotorisasi)
            $('#nmmanual').val(nmmanual)
            $('#jenisproject').val(jenisproject)
            $('#nmproject').val(nmproject)
            return false
      })

  })


</script>

</body>
</html>
