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
  <title>Kelas - KelasAI</title>

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
                Daftar Kelas
              </div>
              <div class="card-body">
                <table id="kelasTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Kelas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Ambil daftar kelas dari database
                  $queryKelas = "SELECT * FROM kelas ORDER BY kelas ASC";
                  $resultKelas = mysqli_query($conn, $queryKelas);

                  if ($resultKelas->num_rows > 0) {
                    while ($row = $resultKelas->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["kelas"] . "</td>";
                      echo "<td><a href='kelas.php?kelas=" . $row['kelas'] . "' class='btn btn-sm btn-success'><li class='fas fa-edit'></li></a> <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDelete" . $row["id"] . "' alt='Hapus Data Pengguna'><i class='fas fa-trash'></i></button></td>";
                      // Modal untuk Hapus Data Pengguna
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDelete" . $row["id"] . "'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <div class='modal-title'>Hapus Data</div>
                          </div>
                          <div class='modal-body'>
                            <form action='proses/hapus_kelas.php' method='POST'>
                            <div class='form-group'>
                              <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                              <input type='hidden' class='form-control' id='kelas' name='kelas' value='" . $row["kelas"] . "'>
                              <p>Anda akan menghapus data: <b>" . $row["kelas"] . "</b><p>
                              
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
                Tambah Kelas
              </div>
              <div class="card-body">
                <form action="proses/tambah_kelas.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="kelas">Kelas:</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" required>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Tambah Data</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Edit Kelas
              </div>
              <div class="card-body">
                <?php
                // Periksa apakah parameter id ada pada URL
                if (isset($_GET['kelas'])) {
                    $kelas = $_GET['kelas'];

                    // Query untuk mengambil data kelas berdasarkan id
                    $queryEditKelas = "SELECT * FROM kelas WHERE kelas = '$kelas'";
                    $resultEditKelas = mysqli_query($conn, $queryEditKelas);

                    // Periksa apakah data kelas ditemukan
                    if (mysqli_num_rows($resultEditKelas) > 0) {
                        $dataEditKelas = mysqli_fetch_assoc($resultEditKelas);
                ?>
                <form action="proses/edit_kelas.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <input type="hidden" name="id" value="<?php echo $dataEditKelas['id']; ?>">
                  <div class="form-group">
                    <label for="kelas">Kelas:</label>
                    <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $dataEditKelas['kelas']; ?>" required>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
                </form>
                <?php
                  } else {
                      // Jika data kelas tidak ditemukan
                      ?>
                      <p>Tidak ada data kelas yang ditemukan</p>
                      <?php
                  }
              } else {
                  // Jika parameter kelas tidak ada
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
    $("#kelasTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#kelasTable_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- /Script -->
</body>
</html>