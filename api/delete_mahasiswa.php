<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nim = $_POST['nim'] ?? '';

if (empty($nim)) {
    echo json_encode(["status" => "error", "message" => "NIM mahasiswa tidak diterima sistem!"]);
    exit;
}

$conn->begin_transaction();

try {
    $res = $conn->query("SELECT id_mhs, id_user FROM mahasiswa WHERE nim = '$nim'");
    if ($res->num_rows == 0) {
        throw new Exception("Data mahasiswa tidak ditemukan di database.");
    }
    
    $mhs = $res->fetch_assoc();
    $id_mhs = $mhs['id_mhs'];
    $id_user = $mhs['id_user'];

    $conn->query("DELETE FROM krs WHERE id_mhs = '$id_mhs'");
    $conn->query("DELETE FROM mahasiswa WHERE id_mhs = '$id_mhs'");

    if ($conn->affected_rows === 0) {
        throw new Exception("Gagal menghapus profil mahasiswa.");
    }

    $conn->query("DELETE FROM users WHERE id_user = '$id_user'");
    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data mahasiswa berhasil dihapus dari sistem!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Gagal menghapus data: " . $e->getMessage()]);
}

$conn->close();
?>