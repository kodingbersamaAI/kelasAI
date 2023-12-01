<?php
// ... (Code untuk koneksi ke database dan fungsi lainnya)

// Ambil username dari sesi
$namaGuru = $_SESSION['username'];

// Query untuk mengambil kelas dari tabel guru sesuai dengan username yang aktif
$queryKelas = "SELECT kelasGuru FROM guru WHERE namaGuru = ?";
$stmtKelas = $conn->prepare($queryKelas);
$stmtKelas->bind_param("s", $namaGuru);  // Ganti $username dengan $namaGuru
$stmtKelas->execute();
$resultKelas = $stmtKelas->get_result();

// Generate dropdown kelas
$options = "";
while ($rowKelas = $resultKelas->fetch_assoc()) {
    // Pecah nilai kelas yang dipisahkan dengan tanda ;
    $kelasArray = explode(";", $rowKelas['kelasGuru']);
    
    // Tampilkan opsi dropdown untuk setiap nilai kelas
    foreach ($kelasArray as $kelasValue) {
        $options .= '<option value="' . $kelasValue . '">' . $kelasValue . '</option>';
    }
}

echo $options;
?>
