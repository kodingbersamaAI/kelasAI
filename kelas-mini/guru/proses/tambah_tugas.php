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
    $namaGuru = filter_input(INPUT_POST, 'namaGuru', FILTER_SANITIZE_STRING);
    $studiTugas = filter_input(INPUT_POST, 'studiTugas', FILTER_SANITIZE_STRING);
    $judulTugas = filter_input(INPUT_POST, 'judulTugas', FILTER_SANITIZE_STRING);
    $kelasSiswaArray = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

    // Buat query SQL untuk menambahkan tugas baru
    $query = "INSERT INTO tugas (namaGuru, studiTugas, judulTugas, kelasSiswa, modulTugas, keteranganTugas, deadlineTugas, statusTugas) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    foreach ($kelasSiswaArray as $kelasSiswa) {
        $modulTugas = filter_input(INPUT_POST, 'modulTugas', FILTER_SANITIZE_STRING);
        $keteranganTugas = filter_input(INPUT_POST, 'keteranganTugas', FILTER_SANITIZE_STRING);
        $deadlineTugas = filter_input(INPUT_POST, 'deadlineTugas', FILTER_SANITIZE_STRING);
        $statusTugas = filter_input(INPUT_POST, 'statusTugas', FILTER_SANITIZE_STRING);

        // Validasi data jika diperlukan

        $stmt->bind_param("ssssssss", $namaGuru, $studiTugas, $judulTugas, $kelasSiswa, $modulTugas, $keteranganTugas, $deadlineTugas, $statusTugas);

        if (!$stmt->execute()) {
            // Gagal menambahkan tugas, tampilkan pesan kesalahan
            header("Location: ../tugas.php?error=gtugas");
            exit();
        }
    }

    // Semua tugas berhasil ditambahkan, arahkan ke halaman sukses atau daftar tugas
    header("Location: ../tugas.php?success=ttugas"); // Ganti dengan halaman yang sesuai
    exit();
}
?>
