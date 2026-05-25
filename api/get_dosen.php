<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Menarik data dosen standar dari database
$query = "SELECT nidn, nama_dosen, email, no_hp, jenis_kelamin, alamat FROM dosen ORDER BY id_dosen DESC";
$result = $conn->query($query);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode(["status" => "success", "data" => $data]);

$conn->close();
?>