<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../kelas.php?error=akses"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kelas = filter_input(INPUT_POST, 'kelas', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan kelas baru
    $query = "DELETE FROM kelas WHERE kelas = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kelas);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar kelas
        header("Location: ../kelas.php?success=hkelas"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan kelas, tampilkan pesan kesalahan
        header("Location: ../kelas.php?error=ghkelas");
        exit();
    }

}
?>
