<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

include 'koneksi.php';

header('Content-Type: application/json');

/* ================= CEK LOGIN ================= */

if (!isset($_SESSION['id_user'])) {

    echo json_encode([
        "status" => "error",
        "message" => "Belum login"
    ]);

    exit;

}

$id_user = $_SESSION['id_user'];

/* ================= AMBIL ID MAHASISWA ================= */

$queryMhs = mysqli_query(
    $conn,

    "SELECT id_mhs
 FROM mahasiswa
 WHERE id_user = '$id_user'"

);

if (!$queryMhs) {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);

    exit;

}

$dataMhs = mysqli_fetch_assoc($queryMhs);

$id_mhs = $dataMhs['id_mhs'];

/* ================= QUERY JADWAL ================= */

$query = mysqli_query($conn, "

SELECT

j.hari,
j.jam_mulai,
j.jam_selesai,
j.ruangan,

mk.kode_mk,
mk.nama_mk,
mk.sks,

d.nama_dosen

FROM krs k

JOIN jadwal j
ON k.id_jadwal = j.id_jadwal

JOIN matakuliah mk
ON j.id_mk = mk.id_mk

JOIN dosen d
ON j.id_dosen = d.id_dosen

WHERE k.id_mhs = '$id_mhs'

ORDER BY
FIELD(
j.hari,
'Senin',
'Selasa',
'Rabu',
'Kamis',
'Jumat'
),
j.jam_mulai ASC

");

/* ================= CEK QUERY ================= */

if (!$query) {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);

    exit;

}

$data = [];

while ($row = mysqli_fetch_assoc($query)) {

    $data[] = $row;

}

echo json_encode([

    "status" => "success",
    "data" => $data

]);

?>