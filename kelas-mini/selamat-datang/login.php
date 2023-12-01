<?php
// Sertakan file koneksi dan sesi
include "../server/koneksi.php";
include "../server/sesi.php";

// Periksa apakah sesi sudah aktif
if (isSessionAvailable() && isset($_SESSION['role'])) {
  // Sesuikan halaman tujuan sesuai dengan peran pengguna
  $redirectPage = '';

  switch ($_SESSION['role']) {
    case "Admin":
      $redirectPage = "../admin";
      break;
    case "Guru":
      $redirectPage = "../guru";
      break;
    case "Siswa":
      $redirectPage = "../siswa";
      break;
    // Tambahkan case sesuai dengan peran lainnya jika diperlukan

    default:
      $redirectPage = "index.php";
      break;
  }

  // Redirect ke halaman sesuai peran
  header("Location: $redirectPage");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - KelasAI</title>

  <?php include "../universal/head.php" ?>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="../../adminlte/img/icon.png" style="max-height:80px;"><br>
      <a href="../../index.php" class="h1"><b>Kelas</b>AI</a>
      <a href="https://koding-bersama-ai.great-site.net"></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

      <form action="../server/login.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username / NIP / NISN" id="username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <select class="form-control" id="role" name="role">
            <option value="" selected disabled>Pilih Peran</option>
            <option value="Admin">Admin</option>
            <option value="Guru">Guru</option>
            <option value="Siswa">Siswa</option>
          </select>
        </div>
        <div class="row text-center">
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Masuk <li class="fas fa-sign-in-alt"></li></button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- Script -->

<?php include "../universal/script.php" ?>

</body>
</html>
