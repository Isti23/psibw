<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nidn = $_POST['nidn'] ?? '';
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$alamat = $_POST['alamat'] ?? '';

if (empty($nidn) || empty($nama)) {
    echo json_encode(["status" => "error", "message" => "NIDN dan Nama tidak boleh kosong!"]);
    exit;
}

try {
    $sql_update = "UPDATE dosen SET 
                    nama_dosen = '$nama', 
                    email = '$email', 
                    no_hp = '$no_hp', 
                    jenis_kelamin = '$jenis_kelamin', 
                    alamat = '$alamat' 
                   WHERE nidn = '$nidn'";

    if ($conn->query($sql_update)) {
        echo json_encode(["status" => "success", "message" => "Data dosen berhasil diperbarui!"]);
    } else {
        throw new Exception("Gagal memperbarui data di database: " . $conn->error);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>