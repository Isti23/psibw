<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_GET['id_jadwal'])) {
    echo json_encode([
        "status" => "error",
        "message" => "ID Jadwal tidak ditemukan"
    ]);
    exit;
}

$id_jadwal = $_GET['id_jadwal'];

$query = "
SELECT 
    k.id_krs,
    k.nilai_akhir,
    k.huruf_mutu,
    m.id_mhs,
    m.nim,
    m.nama_mhs
FROM krs k
JOIN mahasiswa m
    ON k.id_mhs = m.id_mhs
WHERE k.id_jadwal = '$id_jadwal'
ORDER BY m.nama_mhs ASC
";

$result = $conn->query($query);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

$conn->close();
?>