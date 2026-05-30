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

$id_user = $_SESSION['id_user'];

$getDosen = $conn->query("
    SELECT id_dosen, nama_dosen, foto, nidn, email
    FROM dosen
    WHERE id_user = '$id_user'
");

$dosen = $getDosen->fetch_assoc();

$id_dosen = $dosen['id_dosen'];
$nama_dosen = $dosen['nama_dosen'];
$foto = $dosen['foto'];
$nidn = $dosen['nidn'];
$email = $dosen['email'];

$query = "
SELECT
    j.id_jadwal,
    j.id_mk,
    j.hari,
    j.jam_mulai,
    j.jam_selesai,
    j.ruangan,
    mk.kode_mk,
    mk.nama_mk,
    mk.sks
FROM jadwal j
JOIN matakuliah mk
    ON j.id_mk = mk.id_mk
WHERE j.id_dosen = '$id_dosen'
ORDER BY
FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'),
j.jam_mulai
";

$result = $conn->query($query);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

$totalQuery = "
SELECT COUNT(DISTINCT k.id_mhs) as total
FROM krs k
JOIN jadwal j ON k.id_jadwal = j.id_jadwal
WHERE j.id_dosen = '$id_dosen'
";

$totalResult = $conn->query($totalQuery);
$totalMahasiswa = $totalResult->fetch_assoc()['total'];

echo json_encode([
    "status" => "success",
    "dosen_nama" => $nama_dosen,
    "foto" => $foto,
    "nidn" => $nidn,
    "email" => $email,
    "total_mahasiswa_all" => $totalMahasiswa,
    "data" => $data
]);

$conn->close();
?>