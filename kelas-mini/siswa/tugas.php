<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php";

// Ambil daftar kelas dari tabel kelas
$queryEditKelas = "SELECT kelas FROM kelas ORDER BY kelas ASC";
$resultEditKelas = mysqli_query($conn, $queryEditKelas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tugas - KelasAI</title>

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
                Daftar Tugas - Kelas <b><?php echo $_SESSION['kelas'] ?></b>
              </div>
              <div class="card-body">
                <table id="tugasTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Tugas</th>
                      <th>Mata Pelajaran</th>
                      <th>Kelas</th>
                      <th>Batas Pengumpulan</th>
                      <th>Status</th>
                      <th>Pengerjaan</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil daftar tugas dari database
                  $kelas = $_SESSION['kelas'];
                  $queryTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND namaSiswa IS NULL";
                  $stmtTugas = $conn->prepare($queryTugas);
                  $stmtTugas->bind_param("s", $kelas);
                  $stmtTugas->execute();
                  $resultTugas = $stmtTugas->get_result();

                  if ($resultTugas->num_rows > 0) {
                    while ($row = $resultTugas->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["judulTugas"] . "</td>";
                      echo "<td>" . $row["studiTugas"] . "</td>";
                      echo "<td>" . $row["kelasSiswa"] . "</td>";
                      $deadlineFormatted = date("j F Y", strtotime($row["deadlineTugas"]));
                      echo "<td>" . $deadlineFormatted . "</td>";
                      echo "<td>" . $row["statusTugas"] . "</td>";
                      echo "<td><a href='tugas.php?tugas=" . $row['judulTugas'] . "' class='btn btn-sm btn-primary'>Kerjakan <li class='fas fa-sign-out-alt'></li></a></td>";
                      }
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
                Pengerjaan Tugas: <b><?php echo isset($_GET['tugas']) ? htmlspecialchars($_GET['tugas']) : 'Tidak ada data yang dipilih'; ?></b>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <?php
                    // Ambil daftar nilai dari database
                    $queryFile = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ? AND namaSiswa IS NULL";
                    $stmtFile = $conn->prepare($queryFile);
                    $stmtFile->bind_param("ss", $_SESSION['kelas'], $_GET['tugas']);
                    $stmtFile->execute();
                    $resultFile = $stmtFile->get_result();

                    // Check apakah ada data nilai
                    if ($resultFile->num_rows > 0) {
                        // Looping untuk menampilkan data nilai
                        while ($row = $resultFile->fetch_assoc()) {
                            $modulTugas = $row['modulTugas'];
                            
                            // Check apakah modulTugas tidak kosong
                            if (!empty($modulTugas)) {
                                // Tampilkan file dengan menggunakan tag <iframe>
                                echo '<iframe src="' . $modulTugas . '" width="90%" height="400px"></iframe>';
                                echo '<br>';
                                echo 'Jika tidak termuat dengan baik, klik tombol berikut.';
                                echo '<br>';
                                echo '<a href="' . $modulTugas . '" class="btn btn-sm btn-primary" target="_blank">File Tugas</a>';
                            } else {
                                // Tampilkan pesan jika modulTugas kosong
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
                    $queryTugas = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ?";
                    $stmtTugas = $conn->prepare($queryTugas);
                    $stmtTugas->bind_param("ss", $_SESSION['kelas'], $_GET['tugas']);
                    $stmtTugas->execute();
                    $resultTugas = $stmtTugas->get_result();

                    if ($resultTugas->num_rows > 0) {
                      $dataTugas = $resultTugas->fetch_assoc();
                      ?>

                      <h5>Keterangan:</h5>
                      <p><?php echo $dataTugas['keteranganTugas']; ?></p>
                      <hr>
                      <form action="proses/pengumpulan_tugas.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <input type="hidden" name="kelasSiswa" value="<?php echo $_SESSION['kelas']; ?>">
                        <input type="hidden" name="judulTugas" value="<?php echo $_GET['tugas']; ?>">
                        <input type="hidden" name="namaSiswa" value="<?php echo $_SESSION['username']; ?>">
                        <input type="hidden" name="namaGuru" value=<?php echo $dataTugas['namaGuru']; ?>>
                        <input type="hidden" name="studiTugas" value=<?php echo $dataTugas['studiTugas']; ?>>
                        <input type="hidden" name="keteranganTugas" value=<?php echo $dataTugas['keteranganTugas']; ?>>
                        <input type="hidden" name="modulTugas" value=<?php echo $dataTugas['modulTugas']; ?>>
                        <input type="hidden" name="namaGuru" value=<?php echo $dataTugas['namaGuru']; ?>>
                        <input type="hidden" name="deadlineTugas" value=<?php echo $dataTugas['deadlineTugas']; ?>>
                        
                        <div class="form-group">
                          <label for="fileTugas">File Pengerjaan Tugas:</label>
                          <input type="text" class="form-control" id="fileTugas" name="fileTugas" placeholder="Link File Google Drive" required>
                        </div>
                        <div class="form-group">
                          <label for="pengumpulanTugas">Tanggal Pengumpulan Tugas</label>
                          <input type="date" class="form-control" id="pengumpulanTugas" name="pengumpulanTugas" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Kumpulkan Tugas</button>
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
    $("#tugasTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>