// const flashData = $('.flash-data').data('flashdata');

// if (flashData) {
//     Swal({
//         title: 'Data Mahasiswa ',
//         text: 'Berhasil ' + flashData,
//         type: 'success'
//     });
// }

// tombol-hapus
$('#coba').on('click', function () {
    Swal({
        position: 'top-end',
        type: 'success',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 1500
    })

});