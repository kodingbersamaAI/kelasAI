<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../tugas.php?error=akses"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $id = $_POST['id'];
    $judulTugas = filter_input(INPUT_POST, 'judulTugas', FILTER_SANITIZE_STRING);
    $kelasSiswa = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING);
    $modulTugas = filter_input(INPUT_POST, 'modulTugas', FILTER_SANITIZE_STRING);
    $keteranganTugas = filter_input(INPUT_POST, 'keteranganTugas', FILTER_SANITIZE_STRING);
    $deadlineTugas = filter_input(INPUT_POST, 'deadlineTugas', FILTER_SANITIZE_STRING);
    $statusTugas = filter_input(INPUT_POST, 'statusTugas', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk mengupdate data tugas
    $query = "UPDATE tugas SET judulTugas=?, kelasSiswa=?, modulTugas=?, keteranganTugas=?, deadlineTugas=?, statusTugas=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $judulTugas, $kelasSiswa, $modulTugas, $keteranganTugas, $deadlineTugas, $statusTugas, $id);

    if ($stmt->execute()) {
        // Tugas berhasil diupdate, arahkan ke halaman sukses atau daftar tugas
        header("Location: ../tugas.php?success=utugas"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal mengupdate tugas, tampilkan pesan kesalahan
        header("Location: ../tugas.php?error=gutugas");
        exit();
    }
}
?>