<?php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT id_mk, kode_mk, nama_mk, sks, semester FROM matakuliah ORDER BY id_mk DESC";
$result = $conn->query($query);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(["status" => "success", "data" => $data]);
$conn->close();
?>