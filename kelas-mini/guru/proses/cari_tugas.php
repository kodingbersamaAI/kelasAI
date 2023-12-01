<?php
// ... (Code untuk koneksi ke database dan fungsi lainnya)

// Ambil nilai parameter kelas dari URL
$username = $_SESSION['username'];
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Query untuk mengambil judul tugas berdasarkan kelas
$queryTugas = "SELECT judulTugas FROM tugas WHERE kelasSiswa = ? AND namaGuru = $username";
$stmtTugas = $conn->prepare($queryTugas);
$stmtTugas->bind_param("s", $kelas);
$stmtTugas->execute();
$resultTugas = $stmtTugas->get_result();

// Generate dropdown judul tugas
$options = "";
while ($rowTugas = $resultTugas->fetch_assoc()) {
    $options .= '<option value="' . $rowTugas['judulTugas'] . '">' . $rowTugas['judulTugas'] . '</option>';
}

echo $options;
?>
