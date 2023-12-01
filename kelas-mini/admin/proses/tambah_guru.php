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
    $fotoGuru = filter_input(INPUT_POST, 'fotoGuru', FILTER_SANITIZE_STRING);
    $nipGuru = filter_input(INPUT_POST, 'nipGuru', FILTER_SANITIZE_NUMBER_INT);
    $passwordGuru = filter_input(INPUT_POST, 'passwordGuru', FILTER_SANITIZE_STRING);
    $namaGuru = filter_input(INPUT_POST, 'namaGuru', FILTER_SANITIZE_STRING);
    $jabatanGuru = filter_input(INPUT_POST, 'jabatanGuru', FILTER_SANITIZE_STRING);
    $studiGuru = filter_input(INPUT_POST, 'studiGuru', FILTER_SANITIZE_STRING);
    $hpGuru = filter_input(INPUT_POST, 'hpGuru', FILTER_SANITIZE_STRING);
    $emailGuru = filter_input(INPUT_POST, 'emailGuru', FILTER_SANITIZE_STRING);
    $alamatGuru = filter_input(INPUT_POST, 'alamatGuru', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Cek apakah NIP Guru sudah ada dalam database
    $checkQuery = "SELECT nipGuru FROM guru WHERE nipGuru = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $nipGuru);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // NIP Guru sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../guru.php?error=nip");
        exit();
    }

    // Hash password Guru
    $hashedPasswordGuru = password_hash($passwordGuru, PASSWORD_DEFAULT);

    // Gabungkan array kelasGuru menjadi string dengan tanda ;
    $kelasGuru = implode(";", $_POST['kelasGuru']);

    // Buat query SQL untuk menambahkan data guru baru
    $query = "INSERT INTO guru (fotoGuru, nipGuru, passwordGuru, namaGuru, jabatanGuru, studiGuru, hpGuru, emailGuru, alamatGuru, kelasGuru) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissssssss", $fotoGuru, $nipGuru, $hashedPasswordGuru, $namaGuru, $jabatanGuru, $studiGuru, $hpGuru, $emailGuru, $alamatGuru, $kelasGuru);

    if ($stmt->execute()) {
        // Guru berhasil ditambahkan, arahkan ke halaman sukses atau daftar guru
        header("Location: ../guru.php?success=tguru");
        exit();
    } else {
        // Gagal menambahkan guru, tampilkan pesan kesalahan
        header("Location: ../guru.php?error=gguru");
        exit();
    }

}
?>
