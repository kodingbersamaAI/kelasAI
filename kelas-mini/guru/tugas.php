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
                Daftar Tugas
              </div>
              <div class="card-body">
                <table id="tugasTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Tugas</th>
                      <th>Kelas</th>
                      <th>Batas Pengumpulan</th>
                      <th>Status</th>
                      <th>Aksi</th>
                      <th>Penilaian</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil daftar tugas dari database
                  $username = $_SESSION['username'];
                  $queryTugas = "SELECT * FROM tugas WHERE namaGuru = ? AND namaSiswa IS NULL";
                  $stmtTugas = $conn->prepare($queryTugas);
                  $stmtTugas->bind_param("s", $username);
                  $stmtTugas->execute();
                  $resultTugas = $stmtTugas->get_result();

                  if ($resultTugas->num_rows > 0) {
                    while ($row = $resultTugas->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["judulTugas"] . "</td>";
                      echo "<td>" . $row["kelasSiswa"] . "</td>";
                      $deadlineFormatted = date("j F Y", strtotime($row["deadlineTugas"]));
                      echo "<td>" . $deadlineFormatted . "</td>";
                      echo "<td>" . $row["statusTugas"] . "</td>";
                      echo "<td><a href='tugas.php?tugas=" . $row['judulTugas'] . "' class='btn btn-sm btn-success'><li class='fas fa-edit'></li></a> <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDelete" . $row["id"] . "' alt='Hapus Data Pengguna'><i class='fas fa-trash'></i></button></td>";
                      echo "<td><a href='nilai.php?kelas=" . $row['kelasSiswa'] . "&tugas=" . $row['judulTugas'] . "' class='btn btn-sm btn-primary'>Nilai <li class='fas fa-sign-out-alt'></li></a></td>";
                      // Modal untuk Hapus Data Pengguna
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDelete" . $row["id"] . "'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <div class='modal-title'>Hapus Data</div>
                          </div>
                          <div class='modal-body'>
                            <form action='proses/hapus_tugas.php' method='POST'>
                            <div class='form-group'>
                              <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                              <input type='hidden' class='form-control' id='judulTugas' name='judulTugas' value='" . $row["judulTugas"] . "'>
                              <input type='hidden' class='form-control' id='kelasSiswa' name='kelasSiswa' value='" . $row["kelasSiswa"] . "'>
                              <p>Anda akan menghapus data: <b>" . $row["judulTugas"] . " - " . $row["kelasSiswa"] . "</b><p>
                              
                            </div>
                              <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                              <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Batal</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>";
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Tambah Tugas
              </div>
              <div class="card-body">
                <form action="proses/tambah_tugas.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="namaGuru">Nama Guru:</label>
                    <input type="text" class="form-control" id="namaGuru" name="namaGuru" value="<?php echo $_SESSION['username']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="studiTugas">Bidang Studi:</label>
                    <input type="text" class="form-control" id="studiTugas" name="studiTugas" value="<?php echo $_SESSION['studi']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="judulTugas">Judul Tugas:</label>
                    <input type="text" class="form-control" id="judulTugas" name="judulTugas" required>
                  </div>
                  <div class="form-group">
                    <label for="kelasSiswa">Kelas Tugas:</label>
                    <?php
                    // Ambil daftar kelas
                    $username = $_SESSION['username'];
                    $queryKelas = "SELECT kelasGuru FROM guru WHERE namaGuru = ?";
                    $stmtKelas = $conn->prepare($queryKelas);
                    $stmtKelas->bind_param("s", $username);
                    $stmtKelas->execute();
                    $resultKelas = $stmtKelas->get_result();

                    while ($rowKelas = $resultKelas->fetch_assoc()) {
                      $kelasArray = explode(";", $rowKelas['kelasGuru']);
                      foreach ($kelasArray as $kelasValue) {
                        ?>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="kelasSiswa[]" value="<?php echo $kelasValue; ?>">
                          <label class="form-check-label"><?php echo $kelasValue; ?></label>
                        </div>
                        <?php
                      }
                    }
                    ?>
                  </div>
                  <div class="form-group">
                    <label for="modullTugas">Modul Tugas:</label>
                    <input type="text" class="form-control" id="modulTugas" name="modulTugas">
                  </div>
                  <div class="form-group">
                    <label for="keteranganlTugas">Keterangan Tugas:</label>
                    <textarea class="form-control" id="keteranganTugas" name="keteranganTugas" rows="5"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="deadlineTugas">Batas Pengumpulan Tugas:</label>
                    <input type="date" class="form-control" id="deadlineTugas" name="deadlineTugas" required>
                  </div>
                  <div class="form-group">
                    <label for="statusTugas">Status Tugas:</label>
                    <select class="form-control" id="statusTugas" name="statusTugas" required>
                      <option value="" selected disabled>Pilih Status</option>
                      <option value="Dinilai">Sudah Dinilai</option>
                      <option value="Belum Dinilai">Belum Dinilai</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Tambah Data</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Edit Tugas
              </div>
              <div class="card-body">
                <?php
                // Periksa apakah parameter id ada pada URL
                if (isset($_GET['tugas'])) {
                    $tugas = $_GET['tugas'];

                    // Query untuk mengambil data tugas berdasarkan id
                    $queryEditTugas = "SELECT * FROM tugas WHERE judulTugas = '$tugas'";
                    $resultEditTugas = mysqli_query($conn, $queryEditTugas);

                    // Periksa apakah data tugas ditemukan
                    if (mysqli_num_rows($resultEditTugas) > 0) {
                        $dataEditTugas = mysqli_fetch_assoc($resultEditTugas);
                ?>
                <form action="proses/edit_tugas.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <input type="hidden" name="id" value="<?php echo $dataEditTugas['id']; ?>">
                  <div class="form-group">
                    <label for="namaGuru">Nama Guru:</label>
                    <input type="text" class="form-control" id="namaGuru" name="namaGuru" value="<?php echo $dataEditTugas['namaGuru']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="studiTugas">Bidang Studi:</label>
                    <input type="text" class="form-control" id="studiTugas" name="studiTugas" value="<?php echo $dataEditTugas['studiTugas']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="judulTugas">Judul Tugas:</label>
                    <input type="text" class="form-control" id="judulTugas" name="judulTugas" value="<?php echo $dataEditTugas['judulTugas']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="kelasSiswa">Kelas Tugas:</label>
                    <input type="text" class="form-control" id="kelasSiswa" name="kelasSiswa" value="<?php echo $dataEditTugas['kelasSiswa']; ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="modullTugas">Modul Tugas:</label>
                    <input type="text" class="form-control" id="modullTugas" name="modullTugas" value="<?php echo $dataEditTugas['modulTugas']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="keteranganTugas">Keterangan Tugas:</label>
                    <textarea class="form-control" id="keteranganTugas" name="keteranganTugas" rows="5"><?php echo $dataEditTugas['keteranganTugas']; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="deadlineTugas">Batas Pengumpulan Tugas:</label>
                    <input type="date" class="form-control" id="deadlineTugas" name="deadlineTugas" value="<?php echo $dataEditTugas['deadlineTugas']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="statusTugas">Status Tugas:</label>
                    <select class="form-control" id="statusTugas" name="statusTugas" required>
                      <option value="" disabled>Pilih Status</option>
                      <option value="Dinilai" <?php if ($dataEditTugas['statusTugas'] == 'Dinilai') echo 'selected'; ?>>Sudah Dinilai</option>
                      <option value="Belum Dinilai" <?php if ($dataEditTugas['statusTugas'] == 'Belum Dinilai') echo 'selected'; ?>>Belum Dinilai</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </form>

                <?php
                  } else {
                      // Jika data tugas tidak ditemukan
                      ?>
                      <p>Tidak ada data tugas yang ditemukan</p>
                      <?php
                  }
              } else {
                  // Jika parameter tugas tidak ada
                  ?>
                  <p>Tidak ada data yang dipilih.</p>
                  <?php
              }
              ?>
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