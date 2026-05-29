<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include 'koneksi.php';

header('Content-Type: application/json');

$query = mysqli_query($conn, "

SELECT 

jadwal.id_jadwal,
matakuliah.kode_mk,
matakuliah.nama_mk,
matakuliah.sks,
jadwal.hari,
jadwal.jam_mulai,
jadwal.jam_selesai,
jadwal.ruangan,
dosen.nama_dosen

FROM jadwal

JOIN matakuliah
ON jadwal.id_mk = matakuliah.id_mk

JOIN dosen
ON jadwal.id_dosen = dosen.id_dosen

");

if(!$query){

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);

    exit;

}

$data = [];

while($row = mysqli_fetch_assoc($query)){

    $data[] = $row;

}

echo json_encode([

    "status" => "success",
    "data" => $data

]);

?>