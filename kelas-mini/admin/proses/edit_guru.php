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
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
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

    // Hash password Guru
    $hashedPasswordGuru = password_hash($passwordGuru, PASSWORD_DEFAULT);

    // Gabungkan array kelasGuru menjadi string dengan tanda ;
    $kelasGuru = implode(";", $_POST['kelasGuru']);

    // Buat query SQL untuk mengupdate data guru baru
    $query = "UPDATE guru SET fotoGuru = ?, nipGuru = ?, passwordGuru = ?, namaGuru = ?, jabatanGuru = ?, studiGuru = ?, hpGuru = ?, emailGuru = ?, alamatGuru = ?, kelasGuru = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssi", $fotoGuru, $nipGuru, $hashedPasswordGuru, $namaGuru, $jabatanGuru, $studiGuru, $hpGuru, $emailGuru, $alamatGuru, $kelasGuru, $id);

    if ($stmt->execute()) {
        // Guru berhasil diupdate, arahkan ke halaman sukses atau daftar guru
        header("Location: ../guru.php?success=uguru");
        exit();
    } else {
        // Gagal mengupdate guru, tampilkan pesan kesalahan
        header("Location: ../guru.php?error=guguru");
        exit();
    }

}
?>
