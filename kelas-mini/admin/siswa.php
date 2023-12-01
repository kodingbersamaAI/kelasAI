<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php";

// Ambil daftar mata pelajaran dari database
$queryKelas = "SELECT * FROM kelas ORDER BY kelas ASC";
$resultKelas = mysqli_query($conn, $queryKelas);

// Ambil daftar kelas dari database
$queryEditKelas = "SELECT * FROM kelas ORDER BY kelas ASC";
$resultEditKelas = mysqli_query($conn, $queryEditKelas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa - KelasAI</title>

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
                Daftar Siswa
              </div>
              <div class="card-body">
                <table id="siswaTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>NISN</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Kontak</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil daftar siswa dari database
                  $querySiswa = "SELECT * FROM siswa";
                  $resultSiswa = mysqli_query($conn, $querySiswa);

                  if ($resultSiswa->num_rows > 0) {
                    while ($row = $resultSiswa->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td><img src='" . $row['fotoSiswa'] . "'style='max-height:3cm'></td>";
                      echo "<td>" . $row["nisnSiswa"] . "</td>";
                      echo "<td>" . $row["namaSiswa"] . "</td>";
                      echo "<td>" . $row["kelasSiswa"] . "</td>";
                      echo '<td><a href="mailto:' . $row["emailSiswa"] . '" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer"><li class="fas fa-envelope"></li></a> <a href="https://wa.me/' . $row["hpSiswa"] . '" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer"><li class="fas fa-phone"></li></a></td>';
                      echo "<td>" . $row["alamatSiswa"] . "</td>";
                      echo "<td><a href='siswa.php?nisn=" . $row['nisnSiswa'] . "' class='btn btn-sm btn-success'><li class='fas fa-edit'></li></a> <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDelete" . $row["nisnSiswa"] . "' alt='Hapus Data Pengguna'><i class='fas fa-trash'></i></button></td>";
                      // Modal untuk Hapus Data Pengguna
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDelete" . $row["nisnSiswa"] . "'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <div class='modal-title'>Hapus Data</div>
                          </div>
                          <div class='modal-body'>
                            <form action='proses/hapus_siswa.php' method='POST'>
                            <div class='form-group'>
                              <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                              <input type='hidden' class='form-control' id='nisnSiswa' name='nisnSiswa' value='" . $row["nisnSiswa"] . "'>
                              <p>Anda akan menghapus data: <b>" . $row["namaSiswa"] . "</b><p>
                              
                            </div>
                              <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                              <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Batal</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>";
                    }
                  } else {
                      echo '<tr><td colspan="6">Tidak ada data.</td></tr>';
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
                Tambah Siswa
              </div>
              <div class="card-body">
                <form action="proses/tambah_siswa.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="fotoSiswa">Foto Siswa:</label>
                    <input type="text" class="form-control" id="fotoSiswa" name="fotoSiswa" required>
                  </div>
                  <div class="form-group">
                    <label for="nisnSiswa">NISN Siswa:</label>
                    <input type="number" class="form-control" id="nisnSiswa" name="nisnSiswa" required>
                  </div>
                  <div class="form-group">
                    <label for="passwordSiswa">Password Siswa:</label>
                    <input type="text" class="form-control" id="passwordSiswa" name="passwordSiswa" required>
                  </div>
                  <div class="form-group">
                    <label for="namaSiswa">Nama Siswa:</label>
                    <input type="text" class="form-control" id="namaSiswa" name="namaSiswa" required>
                  </div>
                  <div class="form-group">
                    <label for="kelasSiswa">Kelas Siswa:</label>
                    <select class="form-control" id="kelasSiswa" name="kelasSiswa" required>
                      <option value="" selected disabled>Pilih Kelas</option>
                      <?php while($rowKelas = mysqli_fetch_assoc($resultKelas)): ?>
                      <option value="<?php echo $rowKelas['kelas']; ?>"><?php echo $rowKelas['kelas']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hpSiswa">No. HP Siswa:</label>
                    <input type="text" class="form-control" id="hpSiswa" name="hpSiswa" placeholder="+62" required>
                  </div>
                  <div class="form-group">
                    <label for="emailSiswa">Email Siswa:</label>
                    <input type="text" class="form-control" id="emailSiswa" name="emailSiswa" required>
                  </div>
                  <div class="form-group">
                    <label for="alamatSiswa">Alamat Siswa:</label>
                    <textarea class="form-control" id="alamatSiswa" name="alamatSiswa" rows="3" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Tambah Data</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Edit Siswa
              </div>
              <div class="card-body">
                <?php
                // Periksa apakah parameter id ada pada URL
                if (isset($_GET['nisn'])) {
                    $nisnSiswa = $_GET['nisn'];

                    // Query untuk mengambil data siswa berdasarkan id
                    $queryEditSiswa = "SELECT * FROM siswa WHERE nisnSiswa = '$nisnSiswa'";
                    $resultEditSiswa = mysqli_query($conn, $queryEditSiswa);

                    // Periksa apakah data siswa ditemukan
                    if (mysqli_num_rows($resultEditSiswa) > 0) {
                        $dataEditSiswa = mysqli_fetch_assoc($resultEditSiswa);
                ?>
                <form action="proses/edit_siswa.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <input type="hidden" name="id" value="<?php echo $dataEditSiswa['id']; ?>">
                  <div class="form-group">
                    <label for="fotoSiswa">Foto Siswa:</label>
                    <input type="text" class="form-control" id="fotoSiswa" name="fotoSiswa" value="<?php echo $dataEditSiswa['fotoSiswa']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="nisnSiswa">NISN Siswa:</label>
                    <input type="number" class="form-control" id="nisnSiswa" name="nisnSiswa" value="<?php echo $dataEditSiswa['nisnSiswa']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="passwordSiswa">Password Siswa:</label>
                    <input type="text" class="form-control" id="passwordSiswa" name="passwordSiswa">
                  </div>
                  <div class="form-group">
                    <label for="namaSiswa">Nama Siswa:</label>
                    <input type="text" class="form-control" id="namaSiswa" name="namaSiswa" value="<?php echo $dataEditSiswa['namaSiswa']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="kelasSiswa">Kelas Siswa:</label>
                    <select class="form-control" id="kelasSiswa" name="kelasSiswa" required>
                      <option value="" selected disabled>Pilih Kelas</option>
                      <?php while($rowEditKelas = mysqli_fetch_assoc($resultEditKelas)): ?>
                        <option value="<?php echo $rowEditKelas['kelas']; ?>" <?php echo ($rowEditKelas['kelas'] == $dataEditSiswa['kelasSiswa']) ? 'selected' : ''; ?>>
                            <?php echo $rowEditKelas['kelas']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hpSiswa">No. HP Siswa:</label>
                    <input type="text" class="form-control" id="hpSiswa" name="hpSiswa" value="<?php echo $dataEditSiswa['hpSiswa']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="emailSiswa">Email Siswa:</label>
                    <input type="text" class="form-control" id="emailSiswa" name="emailSiswa" value="<?php echo $dataEditSiswa['emailSiswa']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="alamatSiswa">Alamat Siswa:</label>
                    <textarea class="form-control" id="alamatSiswa" name="alamatSiswa" rows="3" required><?php echo $dataEditSiswa['alamatSiswa']; ?></textarea>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </form>
                <?php
                  } else {
                      // Jika data siswa tidak ditemukan
                      ?>
                      <p>Tidak ada data siswa yang ditemukan untuk NISN <?php echo $nisnSiswa; ?></p>
                      <?php
                  }
              } else {
                  // Jika parameter nisn tidak ada
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
    $("#siswaTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#siswaTable_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- /Script -->
</body>
</html>