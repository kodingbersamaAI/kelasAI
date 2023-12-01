<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../siswa.php?error=akses"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fotoSiswa = filter_input(INPUT_POST, 'fotoSiswa', FILTER_SANITIZE_STRING);
    $nisnSiswa = filter_input(INPUT_POST, 'nisnSiswa', FILTER_SANITIZE_NUMBER_INT);
    $passwordSiswa = filter_input(INPUT_POST, 'passwordSiswa', FILTER_SANITIZE_STRING);
    $namaSiswa = filter_input(INPUT_POST, 'namaSiswa', FILTER_SANITIZE_STRING);
    $kelasSiswa = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING);
    $hpSiswa = filter_input(INPUT_POST, 'hpSiswa', FILTER_SANITIZE_STRING);
    $emailSiswa = filter_input(INPUT_POST, 'emailSiswa', FILTER_SANITIZE_STRING);
    $alamatSiswa = filter_input(INPUT_POST, 'alamatSiswa', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Cek apakah NIP Siswa sudah ada dalam database
    $checkQuery = "SELECT nisnSiswa FROM siswa WHERE nisnSiswa = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $nisnSiswa);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // NIP Siswa sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../siswa.php?error=nisn");
        exit();
    }

    // Hash password Siswa
    $hashedPasswordSiswa = password_hash($passwordSiswa, PASSWORD_DEFAULT);

    // Buat query SQL untuk menambahkan data siswa baru
    $query = "INSERT INTO siswa (fotoSiswa, nisnSiswa, passwordSiswa, namaSiswa, kelasSiswa, hpSiswa, emailSiswa, alamatSiswa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissssss", $fotoSiswa, $nisnSiswa, $hashedPasswordSiswa, $namaSiswa, $kelasSiswa, $hpSiswa, $emailSiswa, $alamatSiswa);

    if ($stmt->execute()) {
        // Siswa berhasil ditambahkan, arahkan ke halaman sukses atau daftar siswa
        header("Location: ../siswa.php?success=tsiswa");
        exit();
    } else {
        // Gagal menambahkan siswa, tampilkan pesan kesalahan
        header("Location: ../siswa.php?error=gsiswa");
        exit();
    }

}
?>
