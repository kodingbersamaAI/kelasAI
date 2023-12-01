<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../nilai.php?error=akses&kelas=$kelasSiswa&tugas=$judulTugas"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kelasSiswa = filter_input(INPUT_POST, 'kelasSiswa', FILTER_SANITIZE_STRING);
    $judulTugas = filter_input(INPUT_POST, 'judulTugas', FILTER_SANITIZE_STRING);
    $namaSiswa = filter_input(INPUT_POST, 'namaSiswa', FILTER_SANITIZE_STRING);
    $nilaiTugas = filter_input(INPUT_POST, 'nilaiTugas', FILTER_SANITIZE_STRING);
    $catatanNilai = filter_input(INPUT_POST, 'catatanNilai', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Buat query SQL untuk memberikan nilai tugas
    $query = "UPDATE tugas SET statusTugas = 'Dinilai', nilaiTugas = ?, catatanNilai = ? WHERE kelasSiswa = ? AND judulTugas = ? AND namaSiswa = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $nilaiTugas, $catatanNilai, $kelasSiswa, $judulTugas, $namaSiswa);

    if ($stmt->execute()) {
        // Nilai tugas berhasil diberikan, arahkan ke halaman nilai.php dengan parameter sukses=unilai dan parameter kelas, tugas, siswa yang tetap
        header("Location: ../nilai.php?success=unilai&kelas=$kelasSiswa&tugas=$judulTugas");
        exit();
    } else {
        // Gagal memberikan nilai tugas, arahkan ke halaman nilai.php dengan parameter error=nilai dan parameter kelas, tugas, siswa yang tetap
        header("Location: ../nilai.php?error=gunilai&kelas=$kelasSiswa&tugas=$judulTugas");
        exit();
    }
}
?>
