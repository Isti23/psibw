<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nidn = $_POST['nidn'] ?? '';

if (empty($nidn)) {
    echo json_encode(["status" => "error", "message" => "NIDN dosen tidak ditemukan!"]);
    exit;
}

$conn->begin_transaction();

try {
    // Cari id_dosen dan id_user terlebih dahulu
    $res = $conn->query("SELECT id_dosen, id_user FROM dosen WHERE nidn = '$nidn'");
    if ($res->num_rows == 0) {
        throw new Exception("Data dosen tidak ditemukan di sistem.");
    }
    
    $dosen = $res->fetch_assoc();
    $id_dosen = $dosen['id_dosen'];
    $id_user = $dosen['id_user'];

    // 1. Hapus jadwal mengajar dosen terlebih dahulu (mencegah error relasi)
    $conn->query("DELETE FROM jadwal WHERE id_dosen = '$id_dosen'");

    // 2. Hapus data utama di tabel dosen
    $conn->query("DELETE FROM dosen WHERE id_dosen = '$id_dosen'");

    if ($conn->affected_rows === 0) {
        throw new Exception("Gagal menghapus data profil dosen.");
    }

    // 3. Hapus akun login di tabel users
    $conn->query("DELETE FROM users WHERE id_user = '$id_user'");

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data dosen berhasil dihapus dari sistem!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Gagal menghapus data: " . $e->getMessage()]);
}

$conn->close();
?>