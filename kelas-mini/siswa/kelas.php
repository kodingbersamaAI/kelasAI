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
          <?php
          // Ambil nilai parameter kelas dari URL
          $kelas = $_SESSION['kelas'];

          // Query untuk mengambil data siswa berdasarkan kelas
          $queryKelas = "SELECT * FROM siswa WHERE kelasSiswa = ?";
          $stmtKelas = $conn->prepare($queryKelas);
          $stmtKelas->bind_param("s", $kelas);
          $stmtKelas->execute();
          $resultKelas = $stmtKelas->get_result();

          ?>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                Daftar Siswa - Kelas <b><?php echo $_SESSION['kelas'] ?></b>
              </div>
              <div class="card-body">
                <table id="siswaTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>NISN</th>
                      <th>Nama</th>
                      <th>Kontak</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Tampilkan data siswa dalam tabel
                    while ($rowKelas = $resultKelas->fetch_assoc()) {
                      echo '<tr>
                      <td>' . $rowKelas['nisnSiswa'] . '</td>
                      <td>' . $rowKelas['namaSiswa'] . '</td>
                      <td>
                      <a href="mailto:' . $rowKelas["emailSiswa"] . '" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer"><i class="fas fa-envelope"></i></a>
                      <a href="https://wa.me/' . $rowKelas["hpSiswa"] . '" class="btn btn-sm btn-secondary" target="_blank" rel="noopener noreferrer"><i class="fas fa-phone"></i></a>
                      </td>
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