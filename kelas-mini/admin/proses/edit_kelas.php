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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $kelas = filter_input(INPUT_POST, 'kelas', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk mengupdate data kelas baru
    $query = "UPDATE kelas SET kelas = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $kelas, $id);

    if ($stmt->execute()) {
        // Guru berhasil diupdate, arahkan ke halaman sukses atau daftar kelas
        header("Location: ../kelas.php?success=ukelas");
        exit();
    } else {
        // Gagal mengupdate kelas, tampilkan pesan kesalahan
        header("Location: ../kelas.php?error=gukelas");
        exit();
    }

}
?>
