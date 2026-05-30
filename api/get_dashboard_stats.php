<?php
header('Content-Type: application/json');
include 'koneksi.php';

try {
    $total_mhs = $conn->query("SELECT COUNT(*) AS total FROM mahasiswa")->fetch_assoc()['total'];
    $total_dosen = $conn->query("SELECT COUNT(*) AS total FROM dosen")->fetch_assoc()['total'];
    $total_mk = $conn->query("SELECT COUNT(*) AS total FROM matakuliah")->fetch_assoc()['total'];

    $res_mhs = $conn->query("SELECT nim, nama_mhs FROM mahasiswa ORDER BY id_mhs DESC LIMIT 5");
    $list_mhs = [];
    while($row = $res_mhs->fetch_assoc()) {
        $list_mhs[] = $row;
    }

    $res_dosen = $conn->query("SELECT nidn, nama_dosen FROM dosen ORDER BY id_dosen DESC LIMIT 5");
    $list_dosen = [];
    while($row = $res_dosen->fetch_assoc()) {
        $list_dosen[] = $row;
    }

    $res_mk = $conn->query("SELECT kode_mk, nama_mk FROM matakuliah ORDER BY id_mk DESC LIMIT 5");
    $list_mk = [];
    while($row = $res_mk->fetch_assoc()) {
        $list_mk[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "totals" => [
            "mahasiswa" => $total_mhs,
            "dosen" => $total_dosen,
            "matakuliah" => $total_mk
        ],
        "mahasiswa" => $list_mhs,
        "dosen" => $list_dosen,
        "matakuliah" => $list_mk
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>