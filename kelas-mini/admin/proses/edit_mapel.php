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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $mapel = filter_input(INPUT_POST, 'mapel', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk mengupdate data mapel baru
    $query = "UPDATE mapel SET mapel = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $mapel, $id);

    if ($stmt->execute()) {
        // Guru berhasil diupdate, arahkan ke halaman sukses atau daftar mapel
        header("Location: ../mapel.php?success=umapel");
        exit();
    } else {
        // Gagal mengupdate mapel, tampilkan pesan kesalahan
        header("Location: ../mapel.php?error=gumapel");
        exit();
    }

}
?>
