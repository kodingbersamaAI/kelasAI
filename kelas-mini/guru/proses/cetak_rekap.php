<?php 
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or perform other actions
    header("Location: ../../index.php?error=2");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Nilai - KelasAI</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../../adminlte/img/favicon.ico">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        p {
            font-size: 13px;
        }

        /* Set the page size to A4 and adjust margins for printing */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff; /* Set a white background for printing */
            }

            table {
                page-break-inside: auto; /* Allow tables to break across pages */
            }

            h2, p {
                page-break-before: auto; /* Allow headings and paragraphs to break to a new page */
            }

            @page {
                size: A4;
                margin: 20mm; /* Adjust margins for A4 paper */
            }
        }
    </style>

</head>
<body>

<?php

// Check if the required parameters are provided in the URL
if (isset($_GET['judul']) && isset($_GET['kelas'])) {
    // Get the values from the URL
    $judulTugas = $_GET['judul'];
    $kelasSiswa = $_GET['kelas'];

    // Query to retrieve additional data based on the provided parameters
    $queryDetail = "SELECT * FROM tugas WHERE judulTugas = ? AND kelasSiswa = ? AND namaSiswa IS NOT NULL";
    $stmtDetail = $conn->prepare($queryDetail);
    $stmtDetail->bind_param("ss", $judulTugas, $kelasSiswa);
    $stmtDetail->execute();
    $resultDetail = $stmtDetail->get_result();

    // Print the details in an HTML table
    echo '<center><h2>Rekap Nilai ' . $judulTugas . '</h2></center>';
    echo '<center><h3>Kelas ' . $kelasSiswa . '</h3></center>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>  <th style="width: 2%; text-align: center;">No.</th>
                <th style="width: 20%; text-align: center;">Nama</th>
                <th style="text-align: center;">Kelas</th>
                <th style="text-align: center;">Nilai</th>
                <th style="text-align: center;">Catatan</th>
          </tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $serialNumber = 1;
    while ($rowDetail = $resultDetail->fetch_assoc()) {
        echo '<tr>';
        echo '<td style="text-align: center; vertical-align: top;">' . $serialNumber . '</td>';
        echo '<td style="vertical-align: top;">' . $rowDetail['namaSiswa'] . '</td>';
        echo '<td style="text-align: center; vertical-align: top;">' . $rowDetail['kelasSiswa'] . '</td>';
        echo '<td style="text-align: center; vertical-align: top;">' . $rowDetail['nilaiTugas'] . '</td>';
        echo '<td style="text-align: justify; vertical-align: top;">' . $rowDetail['catatanNilai'] . '</td>';
        echo '</tr>';
        $serialNumber++;
    }

    echo '</tbody>';
    echo '</table>';
    // Display the information
    // Query to retrieve additional data based on the provided parameters
    $queryDetail = "SELECT * FROM tugas WHERE judulTugas = ? AND kelasSiswa = ? AND namaSiswa IS NOT NULL";
    $stmtDetail = $conn->prepare($queryDetail);
    $stmtDetail->bind_param("ss", $judulTugas, $kelasSiswa);
    $stmtDetail->execute();
    $resultDetail = $stmtDetail->get_result();

    // Calculate the highest, lowest, and average values
    $highestValue = -1;  // Initialize with a low value
    $lowestValue = PHP_INT_MAX;  // Initialize with a high value
    $totalValues = 0;
    $countValues = 0;

    while ($rowDetail = $resultDetail->fetch_assoc()) {
        $nilai = $rowDetail['nilaiTugas'];

        // Update the highest value
        if ($nilai > $highestValue) {
            $highestValue = $nilai;
        }

        // Update the lowest value
        if ($nilai < $lowestValue) {
            $lowestValue = $nilai;
        }

        // Sum up values for calculating the average
        $totalValues += $nilai;
        $countValues++;
    }

    // Calculate the average value
    $averageValue = ($countValues > 0) ? ($totalValues / $countValues) : 0;

    echo '<h4>Keterangan:</h4>';
    echo '<p><b>- Nilai Tertinggi</b>: ' . $highestValue . '</p>';
    echo '<p><b>- Nilai Terendah</b>: ' . $lowestValue . '</p>';
    echo '<p><b>- Nilai Rata-Rata</b>: ' . $averageValue . '</p>';
    // Close the prepared statement and result set
    $stmtDetail->close();
    $resultDetail->close();

    // Trigger the print dialog using JavaScript
    echo '<script>
            window.onload = function() {
                window.print();
            };
          </script>';

} else {
    // If required parameters are not provided, handle accordingly (redirect or show an error message)
    echo 'Gagal mendapatkan data';
}

// Close the database connection if needed
$conn->close();
?>

</body>
</html>