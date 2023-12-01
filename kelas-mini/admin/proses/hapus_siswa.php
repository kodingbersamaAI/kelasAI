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
    $nisnSiswa = filter_input(INPUT_POST, 'nisnSiswa', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan siswa baru
    $query = "DELETE FROM siswa WHERE nisnSiswa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nisnSiswa);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar siswa
        header("Location: ../siswa.php?success=hsiswa"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan siswa, tampilkan pesan kesalahan
        header("Location: ../siswa.php?error=ghsiswa");
        exit();
    }

}
?>
