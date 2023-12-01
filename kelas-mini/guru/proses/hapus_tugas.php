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
    $kelasSiswa = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING);
    $judulTugas = filter_input(INPUT_POST, 'judulTugas', FILTER_SANITIZE_STRING);


    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan judulTugas baru
    $query = "DELETE FROM tugas WHERE judulTugas = ? AND kelasSiswa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $judulTugas, $kelasSiswa);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar judulTugas
        header("Location: ../tugas.php?success=htugas"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan judulTugas, tampilkan pesan kesalahan
        header("Location: ../tugas.php?error=ghtugas");
        exit();
    }

}
?>
