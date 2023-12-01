<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../guru.php?error=akses"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nipGuru = filter_input(INPUT_POST, 'nipGuru', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan guru baru
    $query = "DELETE FROM guru WHERE nipGuru = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nipGuru);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar guru
        header("Location: ../guru.php?success=hguru"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan guru, tampilkan pesan kesalahan
        header("Location: ../guru.php?error=ghguru");
        exit();
    }

}
?>
