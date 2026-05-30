<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Akses ditolak."]);
    exit;
}

header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT id_mhs, nim, nama_mhs, email, jenis_kelamin, tempat_lahir, tanggal_lahir, semester, fakultas, jurusan, prodi, ipk, foto FROM mahasiswa ORDER BY id_mhs DESC";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => "success", "data" => $data]);
$conn->close();
?>