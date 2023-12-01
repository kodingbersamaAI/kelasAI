<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php";

// Ambil daftar mata pelajaran dari database
$queryMapel = "SELECT * FROM mapel ORDER BY mapel ASC";
$resultMapel = mysqli_query($conn, $queryMapel);

// Ambil daftar mata pelajaran dari database
$queryJabatan = "SELECT * FROM jabatan";
$resultJabatan = mysqli_query($conn, $queryJabatan);

// Ambil daftar mata pelajaran dari database
$queryEditMapel = "SELECT * FROM mapel ORDER BY mapel ASC";
$resultEditMapel = mysqli_query($conn, $queryEditMapel);

// Ambil daftar jabatan dari database
$queryEditJabatan = "SELECT * FROM jabatan";
$resultEditJabatan = mysqli_query($conn, $queryEditJabatan);

// Ambil daftar kelas dari tabel kelas
$queryKelas = "SELECT kelas FROM kelas ORDER BY kelas ASC";
$resultKelas = mysqli_query($conn, $queryKelas);

// Ambil daftar kelas dari tabel kelas
$queryEditKelas = "SELECT kelas FROM kelas ORDER BY kelas ASC";
$resultEditKelas = mysqli_query($conn, $queryEditKelas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guru - KelasAI</title>

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
                Daftar Guru
              </div>
              <div class="card-body">
                <table id="guruTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Bidang Studi</th>
                      <th>Kontak</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil daftar guru dari database
                  $queryGuru = "SELECT * FROM guru";
                  $resultGuru = mysqli_query($conn, $queryGuru);

                  if ($resultGuru->num_rows > 0) {
                    while ($row = $resultGuru->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td><img src='" . $row['fotoGuru'] . "'style='max-height:3cm'></td>";
                      echo "<td>" . $row["nipGuru"] . "</td>";
                      echo "<td>" . $row["namaGuru"] . "</td>";
                      echo "<td>" . $row["jabatanGuru"] . "</td>";
                      echo "<td>" . $row["studiGuru"] . "</td>";
                      echo '<td><a href="mailto:' . $row["emailGuru"] . '" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer"><li class="fas fa-envelope"></li></a> <a href="https://wa.me/' . $row["hpGuru"] . '" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer"><li class="fas fa-phone"></li></a></td>';
                      echo "<td>" . $row["alamatGuru"] . "</td>";
                      echo "<td><a href='guru.php?nip=" . $row['nipGuru'] . "' class='btn btn-sm btn-success'><li class='fas fa-edit'></li></a> <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDelete" . $row["nipGuru"] . "' alt='Hapus Data Pengguna'><i class='fas fa-trash'></i></button></td>";
                      // Modal untuk Hapus Data Pengguna
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDelete" . $row["nipGuru"] . "'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <div class='modal-title'>Hapus Data</div>
                          </div>
                          <div class='modal-body'>
                            <form action='proses/hapus_guru.php' method='POST'>
                            <div class='form-group'>
                              <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                              <input type='hidden' class='form-control' id='nipGuru' name='nipGuru' value='" . $row["nipGuru"] . "'>
                              <p>Anda akan menghapus data: <b>" . $row["namaGuru"] . "</b><p>
                              
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
                Tambah Guru
              </div>
              <div class="card-body">
                <form action="proses/tambah_guru.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="fotoGuru">Foto Guru:</label>
                    <input type="text" class="form-control" id="fotoGuru" name="fotoGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="nipGuru">NIP Guru:</label>
                    <input type="number" class="form-control" id="nipGuru" name="nipGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="passwordGuru">Password Guru:</label>
                    <input type="text" class="form-control" id="passwordGuru" name="passwordGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="namaGuru">Nama Guru:</label>
                    <input type="text" class="form-control" id="namaGuru" name="namaGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="jabatanGuru">Jabatan Guru:</label>
                    <select class="form-control" id="jabatanGuru" name="jabatanGuru" required>
                      <option value="" selected disabled>Pilih Jabatan</option>
                      <?php while($rowJabatan = mysqli_fetch_assoc($resultJabatan)): ?>
                      <option value="<?php echo $rowJabatan['jabatan']; ?>"><?php echo $rowJabatan['jabatan']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="studiGuru">Studi Guru:</label>
                    <select class="form-control" id="studiGuru" name="studiGuru" required>
                      <option value="" selected disabled>Pilih Studi</option>
                      <?php while($rowMapel = mysqli_fetch_assoc($resultMapel)): ?>
                      <option value="<?php echo $rowMapel['mapel']; ?>"><?php echo $rowMapel['mapel']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="kelasGuru">Kelas Guru:</label>
                    <?php
                    while ($rowKelas = mysqli_fetch_assoc($resultKelas)) {
                      $kelasArray = explode(";", $rowKelas['kelas']);
                      foreach ($kelasArray as $kelasValue) {
                        echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kelasGuru[]" value="' . $kelasValue . '">
                        <label class="form-check-label">' . $kelasValue . '</label>
                        </div>';
                      }
                    }
                    ?>
                  </div>
                  <div class="form-group">
                    <label for="hpGuru">No. HP Guru:</label>
                    <input type="text" class="form-control" id="hpGuru" name="hpGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="emailGuru">Email Guru:</label>
                    <input type="text" class="form-control" id="emailGuru" name="emailGuru" required>
                  </div>
                  <div class="form-group">
                    <label for="alamatGuru">Alamat Guru:</label>
                    <textarea class="form-control" id="alamatGuru" name="alamatGuru" rows="3" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Tambah Data</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Edit Guru
              </div>
              <div class="card-body">
                <?php
                // Periksa apakah parameter id ada pada URL
                if (isset($_GET['nip'])) {
                    $nipGuru = $_GET['nip'];

                    // Query untuk mengambil data guru berdasarkan id
                    $queryEditGuru = "SELECT * FROM guru WHERE nipGuru = '$nipGuru'";
                    $resultEditGuru = mysqli_query($conn, $queryEditGuru);

                    // Periksa apakah data guru ditemukan
                    if (mysqli_num_rows($resultEditGuru) > 0) {
                        $dataEditGuru = mysqli_fetch_assoc($resultEditGuru);
                ?>
                <form action="proses/edit_guru.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <input type="hidden" name="id" value="<?php echo $dataEditGuru['id']; ?>">
                  <div class="form-group">
                    <label for="fotoGuru">Foto Guru:</label>
                    <input type="text" class="form-control" id="fotoGuru" name="fotoGuru" value="<?php echo $dataEditGuru['fotoGuru']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="nipGuru">NIP Guru:</label>
                    <input type="number" class="form-control" id="nipGuru" name="nipGuru" value="<?php echo $dataEditGuru['nipGuru']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="passwordGuru">Password Guru:</label>
                    <input type="text" class="form-control" id="passwordGuru" name="passwordGuru">
                  </div>
                  <div class="form-group">
                    <label for="namaGuru">Nama Guru:</label>
                    <input type="text" class="form-control" id="namaGuru" name="namaGuru" value="<?php echo $dataEditGuru['namaGuru']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="jabatanGuru">Jabatan Guru:</label>
                    <select class="form-control" id="jabatanGuru" name="jabatanGuru" required>
                      <option value="" selected disabled>Pilih Jabatan</option>
                      <?php while($rowEditJabatan = mysqli_fetch_assoc($resultEditJabatan)): ?>
                        <option value="<?php echo $rowEditJabatan['jabatan']; ?>" <?php echo ($rowEditJabatan['jabatan'] == $dataEditGuru['jabatanGuru']) ? 'selected' : ''; ?>>
                            <?php echo $rowEditJabatan['jabatan']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="studiGuru">Studi Guru:</label>
                    <select class="form-control" id="studiGuru" name="studiGuru" required>
                      <option value="" selected disabled>Pilih Studi</option>
                      <?php while($rowEditMapel = mysqli_fetch_assoc($resultEditMapel)): ?>
                        <option value="<?php echo $rowEditMapel['mapel']; ?>" <?php echo ($rowEditMapel['mapel'] == $dataEditGuru['studiGuru']) ? 'selected' : ''; ?>>
                            <?php echo $rowEditMapel['mapel']; ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="kelasGuru">Kelas Guru:</label>
                    <?php
                    while ($rowEditKelas = mysqli_fetch_assoc($resultEditKelas)) {
                      $kelasArray = explode(";", $rowEditKelas['kelas']);
                      foreach ($kelasArray as $kelasValue) {
                        $isChecked = in_array($kelasValue, explode(";", $dataEditGuru['kelasGuru'])) ? 'checked' : '';
                        echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kelasGuru[]" value="' . $kelasValue . '" ' . $isChecked . '>
                        <label class="form-check-label">' . $kelasValue . '</label>
                        </div>';
                      }
                    }
                    ?>
                  </div>
                  <div class="form-group">
                    <label for="hpGuru">No. HP Guru:</label>
                    <input type="text" class="form-control" id="hpGuru" name="hpGuru" value="<?php echo $dataEditGuru['hpGuru']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="emailGuru">Email Guru:</label>
                    <input type="text" class="form-control" id="emailGuru" name="emailGuru" value="<?php echo $dataEditGuru['emailGuru']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="alamatGuru">Alamat Guru:</label>
                    <textarea class="form-control" id="alamatGuru" name="alamatGuru" rows="3" required><?php echo $dataEditGuru['alamatGuru']; ?></textarea>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </form>
                <?php
                  } else {
                      // Jika data guru tidak ditemukan
                      ?>
                      <p>Tidak ada data guru yang ditemukan untuk NIP <?php echo $nipGuru; ?></p>
                      <?php
                  }
              } else {
                  // Jika parameter nip tidak ada
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
    $("#guruTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#guruTable_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- /Script -->
</body>
</html>