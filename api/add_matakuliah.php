<?php
header('Content-Type: application/json');
include 'koneksi.php';

$kode_mk = $_POST['kode_mk'] ?? '';
$nama_mk = $_POST['nama_mk'] ?? '';
$sks = $_POST['sks'] ?? 0;
$semester = $_POST['semester'] ?? 0;

if (empty($kode_mk) || empty($nama_mk)) {
    echo json_encode(["status" => "error", "message" => "Kode dan Nama Matakuliah tidak boleh kosong!"]);
    exit;
}

try {
    $cek = $conn->query("SELECT id_mk FROM matakuliah WHERE kode_mk = '$kode_mk'");
    if ($cek->num_rows > 0) {
        throw new Exception("Kode Mata Kuliah sudah terdaftar!");
    }

    $sql = "INSERT INTO matakuliah (kode_mk, nama_mk, sks, semester) VALUES ('$kode_mk', '$nama_mk', '$sks', '$semester')";
    
    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Mata kuliah berhasil ditambahkan!"]);
    } else {
        throw new Exception("Gagal menyimpan data: " . $conn->error);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>