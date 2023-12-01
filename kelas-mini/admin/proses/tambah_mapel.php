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

    // Cek apakah NIP Guru sudah ada dalam database
    $checkQuery = "SELECT mapel FROM mapel WHERE mapel = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $mapel);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // NIP Guru sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../mapel.php?error=mapel");
        exit();
    }

    // Hash password Guru

    // Buat query SQL untuk menambahkan data mapel baru
    $query = "INSERT INTO mapel (mapel) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $mapel);

    if ($stmt->execute()) {
        // Guru berhasil ditambahkan, arahkan ke halaman sukses atau daftar mapel
        header("Location: ../mapel.php?success=tmapel");
        exit();
    } else {
        // Gagal menambahkan mapel, tampilkan pesan kesalahan
        header("Location: ../mapel.php?error=gmapel");
        exit();
    }

}
?>
