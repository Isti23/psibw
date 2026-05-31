<?php
session_start();
header('Content-Type: application/json');

include 'koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode([
        "status" => "error",
        "message" => "Akses ditolak"
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];

$getDosen = $conn->query("
    SELECT id_dosen
    FROM dosen
    WHERE id_user = '$id_user'
");

$dosen = $getDosen->fetch_assoc();
$id_dosen = $dosen['id_dosen'];

$query = "
SELECT
    nim,
    nama_mhs,
    prodi,
    semester
FROM mahasiswa
WHERE id_dosen = '$id_dosen'
ORDER BY nim ASC
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