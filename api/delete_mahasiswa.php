<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Menangkap deretan ID dari Javascript berupa format JSON array
$data = json_decode(file_get_contents("php://input"));
$ids = isset($data->ids) ? $data->ids : [];

if (empty($ids)) {
    echo json_encode(["status" => "error", "message" => "Tidak ada data mahasiswa yang dipilih!"]);
    exit;
}

// Membersihkan deretan ID agar aman dari SQL Injection
$ids_clean = array_map('intval', $ids);
$ids_string = implode(',', $ids_clean);

$conn->begin_transaction();

try {
    $res = $conn->query("SELECT id_user FROM mahasiswa WHERE id_mhs IN ($ids_string)");
    $user_ids = [];
    while ($row = $res->fetch_assoc()) {
        $user_ids[] = $row['id_user'];
    }
    $conn->query("DELETE FROM mahasiswa WHERE id_mhs IN ($ids_string)");

    if (!empty($user_ids)) {
        $user_ids_string = implode(',', array_map('intval', $user_ids));
        $conn->query("DELETE FROM users WHERE id_user IN ($user_ids_string)");
    }

        // Sebelum commit, tambahkan pengecekan hasil delete
    $del_mhs = $conn->prepare("DELETE FROM mahasiswa WHERE id_mhs IN ($ids_string)");
    $del_mhs->execute();

    // ✅ Pastikan ada baris yang terhapus
    if ($conn->affected_rows === 0) {
        throw new Exception("Tidak ada data yang dihapus.");
    }

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data mahasiswa terpilih berhasil dihapus dari sistem!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Gagal menghapus data: " . $e->getMessage()]);
}

$conn->close();
?>