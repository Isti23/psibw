<?php
// ✅ Tambahkan pengecekan session di SEMUA file API
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Akses ditolak."]);
    exit;
}

header('Content-Type: application/json');
include 'koneksi.php';
// ... sisa kode sama

$totalMhs = $conn->query("SELECT COUNT(*) as total FROM mahasiswa")->fetch_assoc()['total'];
$totalDosen = $conn->query("SELECT COUNT(*) as total FROM dosen")->fetch_assoc()['total'];
$totalMK = $conn->query("SELECT COUNT(*) as total FROM matakuliah")->fetch_assoc()['total'];

$listMhs = $conn->query("SELECT nim, nama_mhs FROM mahasiswa ORDER BY id_mhs DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
$listDosen = $conn->query("SELECT nidn, nama_dosen FROM dosen ORDER BY id_dosen DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);
$listMK = $conn->query("SELECT kode_mk, nama_mk FROM matakuliah ORDER BY id_mk DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    "status" => "success",
    "counts" => [
        "mahasiswa" => $totalMhs,
        "dosen" => $totalDosen,
        "matakuliah" => $totalMK
    ],
    "latest" => [
        "mahasiswa" => $listMhs,
        "dosen" => $listDosen,
        "matakuliah" => $listMK
    ]
]);
?>