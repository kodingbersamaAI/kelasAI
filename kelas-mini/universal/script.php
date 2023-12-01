<!-- jQuery -->
<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/jquery/jquery.link.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../adminlte/plugins/moment/moment.min.js"></script>
<script src="../../adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../adminlte/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="../../adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(document).ready(function() {
    var successMessages = {
      'tguru': 'Data Guru berhasil ditambahkan.',
      'uguru': 'Data Guru berhasil diperbarui.',
      'hguru': 'Data Guru berhasil dihapus.',
      'tsiswa': 'Data Siswa berhasil ditambahkan.',
      'usiswa': 'Data Siswa berhasil diperbarui.',
      'hsiswa': 'Data Siswa berhasil dihapus.',
      'tkelas': 'Data Kelas berhasil ditambahkan.',
      'ukelas': 'Data Kelas berhasil diperbarui.',
      'hkelas': 'Data Kelas berhasil dihapus.',
      'tmapel': 'Data Mata Pelajaran berhasil ditambahkan.',
      'umapel': 'Data Mata Pelajaran berhasil diperbarui.',
      'hmapel': 'Data Mata Pelajaran berhasil dihapus.',
      'ttugas': 'Data Tugas berhasil ditambahkan.',
      'utugas': 'Data Tugas berhasil diperbarui.',
      'htugas': 'Data Tugas berhasil dihapus.',
      'tnilai': 'Data Nilai berhasil ditambahkan.',
      'unilai': 'Data Nilai berhasil diperbarui.',
      'hnilai': 'Data Nilai berhasil dihapus.'
    };

    var errorMessages = {
      'peran': 'Peran tidak ditemukan.',
      'password': 'Password Anda salah',
      'username': 'Username Anda salah.',
      'akses': 'Anda tidak memiliki akses.',
      'gguru': 'Data Guru gagal ditambahkan.',
      'guguru': 'Data Guru gagal diperbarui.',
      'ghguru': 'Data Guru gagal dihapus.',
      'gsiswa': 'Data Siswa gagal ditambahkan.',
      'gusiswa': 'Data Siswa gagal diperbarui.',
      'ghsiswa': 'Data Siswa gagal dihapus.',
      'gkelas': 'Data Kelas gagal ditambahkan.',
      'gukelas': 'Data Kelas gagal diperbarui.',
      'ghkelas': 'Data Kelas gagal dihapus.',
      'gmapel': 'Data Mata Pelajaran gagal ditambahkan.',
      'gumapel': 'Data Mata Pelajaran gagal diperbarui.',
      'ghmapel': 'Data Mata Pelajaran gagal dihapus.',
      'gtugas': 'Data Tugas gagal ditambahkan.',
      'gutugas': 'Data Tugas gagal diperbarui.',
      'sutugas': 'Anda sudah mengumpulkan tugas.',
      'ghtugas': 'Data Tugas gagal dihapus.',
      'gnilai': 'Data Nilai gagal ditambahkan.',
      'gunilai': 'Data Nilai gagal diperbarui.',
      'ghnilai': 'Data Nilai gagal dihapus.',
      'nisn': 'NISN Siswa sudah terdaftar.',
      'mapel': 'Mata Pelajaran sudah terdaftar.',
      'kelas': 'Kelas sudah terdaftar.',
      'nip': 'NIP Guru sudah terdaftar.'

    };

    var successParam = new URLSearchParams(window.location.search).get('success');
    var errorParam = new URLSearchParams(window.location.search).get('error');

    // Menampilkan pesan sukses jika ada
    if (successParam && successMessages[successParam]) {
      Swal.fire({
        icon: 'success',
        title: 'Sukses',
        text: successMessages[successParam]
      });
    }

    // Menampilkan pesan kesalahan jika ada
    if (errorParam && errorMessages[errorParam]) {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: errorMessages[errorParam]
      });
    }
  });
</script>
<!-- DataTables  & Plugins -->
<script src="../../adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/jszip/jszip.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="../../adminlte/plugins/select2/js/select2.min.js">