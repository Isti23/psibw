<?php
header('Content-Type: application/json');
include 'koneksi.php';

$id_mk = $_POST['id_mk'] ?? '';
$kode_mk = $_POST['kode_mk'] ?? '';
$nama_mk = $_POST['nama_mk'] ?? '';
$sks = $_POST['sks'] ?? 0;
$semester = $_POST['semester'] ?? 0;

if (empty($id_mk) || empty($kode_mk) || empty($nama_mk)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap!"]);
    exit;
}

try {
    $sql = "UPDATE matakuliah SET 
            kode_mk = '$kode_mk', 
            nama_mk = '$nama_mk', 
            sks = '$sks', 
            semester = '$semester' 
            WHERE id_mk = '$id_mk'";
            
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Data mata kuliah berhasil diperbarui!"]);
    } else {
        throw new Exception("Gagal memperbarui data.");
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>