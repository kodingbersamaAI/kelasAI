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
    $namaSiswa = filter_input(INPUT_POST, 'namaSiswa', FILTER_SANITIZE_STRING);
    
    // Cek apakah namaSiswa sudah ada
    $checkQuery = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ? AND namaSiswa = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("sss", $kelasSiswa, $judulTugas, $namaSiswa);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Jika namaSiswa sudah ada, arahkan ke halaman tugas.php dengan parameter error=sutugas
        header("Location: ../tugas.php?error=sutugas");
        exit();
    }

    // Ambil data tugas dari database (contoh, sesuaikan dengan metode pengambilan data Anda)
    $getDataQuery = "SELECT * FROM tugas WHERE kelasSiswa = ? AND judulTugas = ?";
    $getDataStmt = $conn->prepare($getDataQuery);
    $getDataStmt->bind_param("ss", $kelasSiswa, $judulTugas);
    $getDataStmt->execute();
    $dataTugas = $getDataStmt->get_result()->fetch_assoc();

    // Lanjutkan dengan data lain jika namaSiswa belum ada
    $fileTugas = filter_input(INPUT_POST, 'fileTugas', FILTER_SANITIZE_STRING);
    $pengumpulanTugas = filter_input(INPUT_POST, 'pengumpulanTugas', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk menambahkan tugas
    $insertQuery = "INSERT INTO tugas (kelasSiswa, judulTugas, namaSiswa, fileTugas, pengumpulanTugas, namaGuru, studiTugas, keteranganTugas, modulTugas, deadlineTugas) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssssssssss", $kelasSiswa, $judulTugas, $namaSiswa, $fileTugas, $pengumpulanTugas, $dataTugas['namaGuru'], $dataTugas['studiTugas'], $dataTugas['keteranganTugas'], $dataTugas['modulTugas'], $dataTugas['deadlineTugas']);

    if ($insertStmt->execute()) {
        // Tugas berhasil ditambahkan, arahkan ke halaman tugas.php dengan parameter success=utugas
        header("Location: ../tugas.php?success=utugas");
        exit();
    } else {
        // Gagal menambahkan tugas, arahkan ke halaman tugas.php dengan parameter error=gutugas
        header("Location: ../tugas.php?error=gutugas");
        exit();
    }
}
?>
