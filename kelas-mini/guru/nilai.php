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
  <title>Nilai - KelasAI</title>

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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                Daftar Pengumpulan Tugas: <b><?php echo isset($_GET['tugas']) ? htmlspecialchars($_GET['tugas']) : 'Tidak ada data yang dipilih'; ?></b> - Kelas: <b><?php echo isset($_GET['kelas']) ? htmlspecialchars($_GET['kelas']) : 'Tidak ada data yang dipilih'; ?></b>
              </div>
              <div class="card-body">
                <table id="nilaiTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nama Siswa</th>
                      <th>Waktu Pengumpulan</th>
                      <th>Nilai</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil username dari sesi
                  $username = $_SESSION['username'];
                  $studi = $_SESSION['studi'];

                  // Query SQL untuk mengambil data tugas berdasarkan kelas, judul tugas, dan nama guru
                  $queryDaftarTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ? AND namaGuru = ? AND studiTugas = ? AND namaSiswa IS NOT NULL ORDER BY namaSiswa ASC";
                  $stmtDaftarTugas = $conn->prepare($queryDaftarTugas);
                  $stmtDaftarTugas->bind_param("ssss", $_GET['kelas'], $_GET['tugas'], $username, $studi);
                  $stmtDaftarTugas->execute();
                  $resultDaftarTugas = $stmtDaftarTugas->get_result();

                  if ($resultDaftarTugas->num_rows > 0) {
                    while ($row = $resultDaftarTugas->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["namaSiswa"] . "</td>";
                      $deadlineFormatted = date("j F Y", strtotime($row["deadlineTugas"]));
                      echo "<td>" . $deadlineFormatted . "</td>";
                      echo "<td>" . $row["nilaiTugas"] . "</td>";
                      echo "<td><a href='nilai.php?kelas=" . $_GET['kelas'] . "&tugas=" . $_GET['tugas'] . "&siswa=" . $row['namaSiswa'] . "' class='btn btn-sm btn-success'>Beri Nilai</a></td>";
                    }
                  } else {
                      echo '<tr><td colspan="4">Tidak ada data.</td></tr>';
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                Penilaian Untuk Tugas: <b><?php echo isset($_GET['tugas']) ? htmlspecialchars($_GET['tugas']) : 'Tidak ada data yang dipilih'; ?></b> - Kelas: <b><?php echo isset($_GET['kelas']) ? htmlspecialchars($_GET['kelas']) : 'Tidak ada data yang dipilih'; ?></b> - Siswa <b><?php echo isset($_GET['siswa']) ? htmlspecialchars($_GET['siswa']) : 'Tidak ada data yang dipilih'; ?></b>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <?php
                    // Ambil daftar nilai dari database
                    $queryFile = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ? AND namaSiswa = ?";
                    $stmtFile = $conn->prepare($queryFile);
                    $stmtFile->bind_param("sss", $_GET['kelas'], $_GET['tugas'], $_GET['siswa']);
                    $stmtFile->execute();
                    $resultFile = $stmtFile->get_result();

                    // Check apakah ada data nilai
                    if ($resultFile->num_rows > 0) {
                        // Looping untuk menampilkan data nilai
                        while ($row = $resultFile->fetch_assoc()) {
                            $fileTugas = $row['fileTugas'];
                            
                            // Check apakah fileTugas tidak kosong
                            if (!empty($fileTugas)) {
                                // Tampilkan file dengan menggunakan tag <iframe>
                                echo '<iframe src="' . $fileTugas . '" width="90%" height="400px"></iframe>';
                                echo '<br>';
                                echo 'Jika tidak termuat dengan baik, klik tombol berikut.';
                                echo '<br>';
                                echo '<a href="' . $fileTugas . '" class="btn btn-sm btn-primary" target="_blank">File Tugas</a>';
                            } else {
                                // Tampilkan pesan jika fileTugas kosong
                                echo '<p>File Tugas tidak tersedia.</p>';
                            }
                        }
                    } else {
                        // Tampilkan pesan jika tidak ada data
                        echo 'Tidak ada data dipilih.';
                    }
                    ?>
                  </div>
                  <div class="col-md-6 col-12">
                    <?php
                    // Ambil data tugas
                    $queryTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ? AND namaSiswa = ?";
                    $stmtTugas = $conn->prepare($queryTugas);
                    $stmtTugas->bind_param("sss", $_GET['kelas'], $_GET['tugas'], $_GET['siswa']);
                    $stmtTugas->execute();
                    $resultTugas = $stmtTugas->get_result();

                    if ($resultTugas->num_rows > 0) {
                      $dataTugas = $resultTugas->fetch_assoc();
                      ?>

                      <form action="proses/tambah_nilai.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="kelasSiswa" value="<?php echo $_GET['kelas']; ?>">
                        <input type="hidden" name="judulTugas" value="<?php echo $_GET['tugas']; ?>">
                        <input type="hidden" name="namaSiswa" value="<?php echo $_GET['siswa']; ?>">
                        <div class="form-group">
                          <label for="nilaiTugas">Nilai Tugas:</label>
                          <input type="number" class="form-control" id="nilaiTugas" name="nilaiTugas" value="<?php echo $dataTugas['nilaiTugas']; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="catatanNilai">Catatan Tugas:</label>
                          <textarea class="form-control" id="catatanNilai" name="catatanNilai" rows="4"><?php echo $dataTugas['catatanNilai']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Submit Nilai</button>
                      </form>

                      <?php
                    } else {
                    // Tampilkan pesan jika data tugas tidak ditemukan
                      echo 'Tidak ada data dipilih.';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    $("#nilaiTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>