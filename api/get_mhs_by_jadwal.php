<?php
session_start();
header('Content-Type: application/json');

include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session habis"
    ]);
    exit;
}

$id_jadwal = $_GET['id_jadwal'] ?? '';

if ($id_jadwal == '') {
    echo json_encode([
        "status" => "error",
        "message" => "ID jadwal kosong"
    ]);
    exit;
}

$query = "
SELECT
    k.id_krs,
    k.nilai,
    m.nim,
    m.nama_mhs
FROM krs k
JOIN mahasiswa m
    ON k.id_mhs = m.id_mhs
WHERE k.id_jadwal = '$id_jadwal'
ORDER BY m.nim ASC
";

$result = $conn->query($query);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
    exit;
}

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