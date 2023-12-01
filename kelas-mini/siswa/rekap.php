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
          // Ambil nilai parameter kelas dari URL
          $username = $_SESSION['username'];
          $kelas = $_SESSION['kelas'];

          // Query untuk mengambil data tugas berdasarkan kelas
          $queryTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND namaSiswa = ? ORDER BY studiTugas ASC, judulTugas ASC";
          try {
            $stmtTugas = $conn->prepare($queryTugas);
            $stmtTugas->bind_param("ss", $kelas, $username);
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
                Rekap Nilai Siswa - <b><?php echo htmlspecialchars($username) ?: 'Tidak ada data dipilih'; ?></b>
              </div>
              <div class="card-body">
                <table id="rekapTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Mata Pelajaran</th>
                      <th>Judul Tugas</th>
                      <th>Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Tampilkan data siswa dalam tabel
                    while ($rowTugas = $resultTugas->fetch_assoc()) {
                      echo '<tr>
                      <td>' . $rowTugas['studiTugas'] . '</td>
                      <td>' . $rowTugas['judulTugas'] . '</td>
                      <td>' . $rowTugas['nilaiTugas'] . '</td>
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