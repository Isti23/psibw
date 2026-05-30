<?php

session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if(!isset($_SESSION['id_user'])){
    echo json_encode([
        "status" => "error",
        "message" => "Belum login"
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];

$query = $conn->query("
SELECT * FROM mahasiswa
WHERE id_user = '$id_user'
");

$data = $query->fetch_assoc();

$foto = $data['foto'];
$id_mhs = $data['id_mhs'];

if($foto != 'default.jpg'){
    $path = "../foto/" . $foto;
    if(file_exists($path)){
        unlink($path);
    }
}

$update = $conn->query("
    UPDATE mahasiswa
    SET foto = 'default.jpg'
    WHERE id_mhs = '$id_mhs'
");

if($update){
    echo json_encode([
        "status" => "success",
        "message" => "Foto profil berhasil dihapus"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menghapus foto"
    ]);
}

?>