<?php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "
    SELECT 
        j.id_jadwal, j.hari, j.jam_mulai, j.jam_selesai, j.ruangan,
        j.id_mk, j.id_dosen,
        m.kode_mk, m.nama_mk, m.sks, m.semester,
        d.nama_dosen, d.nidn
    FROM jadwal j
    LEFT JOIN matakuliah m ON j.id_mk = m.id_mk
    LEFT JOIN dosen d ON j.id_dosen = d.id_dosen
    ORDER BY j.id_jadwal DESC
";

$result = $conn->query($query);
$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode(["status" => "success", "data" => $data]);
$conn->close();
?>