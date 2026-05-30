<?php

session_start();

include 'koneksi.php';

header('Content-Type: application/json');

/* ================= VALIDASI LOGIN ================= */

if(!isset($_SESSION['id_user'])){

    echo json_encode([
        'status' => 'error',
        'message' => 'Belum login'
    ]);

    exit;

}

$id_user = $_SESSION['id_user'];

/* ================= AMBIL ID MAHASISWA ================= */

$queryMhs = mysqli_query($conn, "

SELECT id_mhs

FROM mahasiswa

WHERE id_user = '$id_user'

");

$dataMhs = mysqli_fetch_assoc($queryMhs);

$id_mhs = $dataMhs['id_mhs'];

/* ================= QUERY NILAI ================= */

$queryNilai = mysqli_query($conn, "

SELECT

    matakuliah.kode_mk,
    matakuliah.nama_mk,
    dosen.nama_dosen,
    krs.nilai_akhir,
    krs.huruf_mutu

FROM krs

JOIN jadwal
ON krs.id_jadwal = jadwal.id_jadwal

JOIN matakuliah
ON jadwal.id_mk = matakuliah.id_mk

JOIN dosen
ON jadwal.id_dosen = dosen.id_dosen

WHERE krs.id_mhs = '$id_mhs'

");

/* ================= ARRAY DATA ================= */

$data = [];

while($row = mysqli_fetch_assoc($queryNilai)){

    $data[] = $row;

}

/* ================= RESPONSE JSON ================= */

echo json_encode([

    'status' => 'success',
    'data' => $data

]);

?>
