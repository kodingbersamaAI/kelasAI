<?php
// proses_login.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sertakan file koneksi dan sesi
require "koneksi.php";
require "sesi.php";

// Fungsi untuk membersihkan input dan mencegah SQL injection
function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);
    $role = cleanInput($_POST["role"]);

    // Membuat query sesuai dengan peran (admin, guru, atau siswa)
    $query = "";
    $redirectPage = "";

    switch (strtolower($role)) {
        case "admin":
            $query = "SELECT * FROM admin WHERE usernameAdmin = '$username'";
            $redirectPage = "../admin/dashboard.php";
            break;
        case "guru":
            $query = "SELECT * FROM guru WHERE nipGuru = '$username'";
            $redirectPage = "../guru/dashboard.php";
            break;
        case "siswa":
            $query = "SELECT * FROM siswa WHERE nisnSiswa = '$username'";
            $redirectPage = "../siswa/dashboard.php";
            break;
        default:
            // Redirect ke halaman login jika peran tidak valid
            header("Location: ../selamat-datang/login.php?error=peran");
            exit();
    }

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    // Periksa apakah data pengguna sesuai dengan database
    if ($result && mysqli_num_rows($result) > 0) {
        // Data pengguna ditemukan
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password dengan password_hash
        if (password_verify($password, $row['password'.$role])) {
            // Password sesuai, mulai sesi, simpan informasi pengguna, dan arahkan ke halaman sesuai peran
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['nama'.$role];
            $_SESSION['studi'] = $row['studi'.$role];
            $_SESSION['foto'] = $row['foto'.$role];
            $_SESSION['kelas'] = $row['kelas'.$role];
            $_SESSION['role'] = $role;

            header("Location: $redirectPage");
        } else {
            // Password tidak sesuai, arahkan ke halaman login dengan pesan error
            header("Location: ../selamat-datang/login.php?error=password");
        }
    } else {
        // Data pengguna tidak sesuai, arahkan ke halaman login dengan pesan error
        header("Location: ../selamat-datang/login.php?error=username");
    }
} else {
    // Jika bukan metode POST, arahkan ke halaman login
    header("Location: ../selamat-datang/login.php?error=akses");
}
?>
