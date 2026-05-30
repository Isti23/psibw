<?php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT id_dosen, nidn, nama_dosen, email, no_hp, jenis_kelamin, alamat, foto FROM dosen"; 
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "data" => $data]);
$conn->close();
?>