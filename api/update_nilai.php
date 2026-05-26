<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'dosen') {
    echo json_encode([
        "status" => "error",
        "message" => "Akses ditolak."
    ]);
    exit;
}

$id_krs_arr = $_POST['id_krs'] ?? [];
$nilai_arr = $_POST['nilai'] ?? [];

if (empty($id_krs_arr)) {
    echo json_encode([
        "status" => "error",
        "message" => "Tidak ada data nilai."
    ]);
    exit;
}

$conn->begin_transaction();

try {

    $stmt = $conn->prepare("
        UPDATE krs 
        SET nilai = ?
        WHERE id_krs = ?
    ");

    for ($i = 0; $i < count($id_krs_arr); $i++) {

        $id_krs = intval($id_krs_arr[$i]);

        if ($nilai_arr[$i] === '') {
            $nilai = null;
        } else {
            $nilai = floatval($nilai_arr[$i]);
        }

        $stmt->bind_param("di", $nilai, $id_krs);

        if (!$stmt->execute()) {
            throw new Exception("Gagal update nilai.");
        }
    }

    $conn->commit();

    echo json_encode([
        "status" => "success",
        "message" => "Nilai berhasil disimpan."
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>