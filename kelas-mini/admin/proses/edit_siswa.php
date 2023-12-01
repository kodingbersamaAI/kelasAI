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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $fotoSiswa = filter_input(INPUT_POST, 'fotoSiswa', FILTER_SANITIZE_STRING);
    $nisnSiswa = filter_input(INPUT_POST, 'nisnSiswa', FILTER_SANITIZE_NUMBER_INT);
    $passwordSiswa = filter_input(INPUT_POST, 'passwordSiswa', FILTER_SANITIZE_STRING);
    $namaSiswa = filter_input(INPUT_POST, 'namaSiswa', FILTER_SANITIZE_STRING);
    $kelasSiswa = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING);
    $hpSiswa = filter_input(INPUT_POST, 'hpSiswa', FILTER_SANITIZE_STRING);
    $emailSiswa = filter_input(INPUT_POST, 'emailSiswa', FILTER_SANITIZE_STRING);
    $alamatSiswa = filter_input(INPUT_POST, 'alamatSiswa', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Hash password Siswa
    $hashedPasswordSiswa = password_hash($passwordSiswa, PASSWORD_DEFAULT);

    // Buat query SQL untuk mengupdate data siswa baru
    $query = "UPDATE siswa SET fotoSiswa = ?, nisnSiswa = ?, passwordSiswa = ?, namaSiswa = ?, kelasSiswa = ?, hpSiswa = ?, emailSiswa = ?, alamatSiswa = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssi", $fotoSiswa, $nisnSiswa, $hashedPasswordSiswa, $namaSiswa, $kelasSiswa, $hpSiswa, $emailSiswa, $alamatSiswa, $id);

    if ($stmt->execute()) {
        // Siswa berhasil diupdate, arahkan ke halaman sukses atau daftar siswa
        header("Location: ../siswa.php?success=usiswa");
        exit();
    } else {
        // Gagal mengupdate siswa, tampilkan pesan kesalahan
        header("Location: ../siswa.php?error=gusiswa");
        exit();
    }

}
?>
