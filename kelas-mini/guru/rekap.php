<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rekap Nilai - KelasAI</title>

  <?php include "../universal/head.php" ?>

</head>
<body class="hold-transition sidebar-mini layout-footer-fixed layout-navbar-fixed layout-fixed">
<div class="wrapper">

  <?php include "navbar.php" ?>
  <?php include "sidebar.php" ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php
          // Ambil username dari sesi
          $username = $_SESSION['username'];

          // Ambil data kelas dari tabel guru berdasarkan username
          $queryRekapNilai = "SELECT kelasGuru FROM guru WHERE namaGuru = '$username'";
          $resultRekapNilai = $conn->query($queryRekapNilai);

          if ($resultRekapNilai->num_rows > 0) {
              while ($rowRekapNilai = $resultRekapNilai->fetch_assoc()) {
                  // Pisahkan nilai kelas yang dipisahkan oleh tanda ;
                  $kelasArray = explode(';', $rowRekapNilai['kelasGuru']);

                  // Loop melalui setiap nilai kelas
                  foreach ($kelasArray as $kelas) {

                      // Tampilkan informasi dalam card
                      echo '<div class="col-md-3 col-12">
                              <div class="card card-outline card-primary">
                                <div class="card-header text-center">
                                  Rekap Nilai: <b>' . $kelas . '</b> <br><br> <a href="rekap.php?kelas=' . $kelas . '" class="btn btn-sm btn-primary">Pilih</a>
                                </div>
                              </div>
                            </div>';
                  }
              }
          } else {
              // Jika tidak ada kelas yang ditemukan
              echo '<div class="col-md-3 col-12">
                      <div class="card card-outline card-primary">
                        <div class="card-header">
                          Tidak ada data kelas yang ditemukan.
                        </div>
                      </div>
                    </div>';
          }
          // ... (Code untuk menutup koneksi dan hal lainnya)
          ?>
          <?php
          // Ambil nilai parameter kelas dari URL
          $username = $_SESSION['username'];
          $studi = $_SESSION['studi'];
          $kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

          // Query untuk mengambil data tugas berdasarkan kelas
          $queryTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND namaGuru = ? AND studiTugas = ? AND namaSiswa IS NULL ORDER BY judulTugas ASC";
          try {
            $stmtTugas = $conn->prepare($queryTugas);
            $stmtTugas->bind_param("sss", $kelas, $username, $studi);
            $stmtTugas->execute();
            $resultTugas = $stmtTugas->get_result();
          } catch (Exception $e) {
              // Penanganan kesalahan, misalnya:
            echo "Error: " . $e->getMessage();
              // Exit atau lakukan tindakan lain sesuai kebutuhan
            exit();
          }
          ?>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                Rekap Nilai Siswa - <b><?php echo htmlspecialchars($kelas) ?: 'Tidak ada data dipilih'; ?></b>
              </div>
              <div class="card-body">
                <table id="rekapTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Judul Tugas</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Tampilkan data siswa dalam tabel
                    while ($rowTugas = $resultTugas->fetch_assoc()) {
                      echo '<tr>
                      <td>' . $rowTugas['judulTugas'] . '</td>
                      <td>' . $rowTugas['statusTugas'] . '</td>
                      <td><a href="proses/cetak_rekap.php?judul=' . $rowTugas['judulTugas'] . '&kelas=' . $rowTugas['kelasSiswa'] . '" class="btn btn-sm btn-primary" target="_blank"><li class="fas fa-print"></li> Cetak</a></td>
                      </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <?php
          // ... (Code untuk menutup koneksi dan hal lainnya)
          ?>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Footer -->

  <?php include "../universal/footer.php" ?>

  <!-- /Footer -->

</div>
<!-- ./wrapper -->

<!-- Script -->

<?php include "../universal/script.php" ?>

<script>
  $(function () {
    $("#rekapTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#rekapTable_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- /Script -->
</body>
</html>