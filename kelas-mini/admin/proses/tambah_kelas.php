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

    // Cek apakah NIP Guru sudah ada dalam database
    $checkQuery = "SELECT kelas FROM kelas WHERE kelas = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $kelas);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // NIP Guru sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../kelas.php?error=kelas");
        exit();
    }

    // Hash password Guru

    // Buat query SQL untuk menambahkan data kelas baru
    $query = "INSERT INTO kelas (kelas) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kelas);

    if ($stmt->execute()) {
        // Guru berhasil ditambahkan, arahkan ke halaman sukses atau daftar kelas
        header("Location: ../kelas.php?success=tkelas");
        exit();
    } else {
        // Gagal menambahkan kelas, tampilkan pesan kesalahan
        header("Location: ../kelas.php?error=gkelas");
        exit();
    }

}
?>
