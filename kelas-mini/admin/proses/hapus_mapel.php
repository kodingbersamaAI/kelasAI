<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../mapel.php?error=akses"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mapel = filter_input(INPUT_POST, 'mapel', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan mapel baru
    $query = "DELETE FROM mapel WHERE mapel = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $mapel);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar mapel
        header("Location: ../mapel.php?success=hmapel"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan mapel, tampilkan pesan kesalahan
        header("Location: ../mapel.php?error=ghmapel");
        exit();
    }

}
?>
