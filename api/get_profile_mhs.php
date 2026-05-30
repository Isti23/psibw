<?php

session_start();

include 'koneksi.php';

header('Content-Type: application/json');

/* ================= CEK SESSION ================= */

if (!isset($_SESSION['id_user'])) {

    echo json_encode([
        "status" => "error",
        "message" => "Sesi login tidak ditemukan"
    ]);

    exit;

}

$id_user = $_SESSION['id_user'];

/* ================= QUERY MAHASISWA ================= */

$queryMhs = mysqli_query($conn, "

SELECT 
    mahasiswa.*,
    dosen.nama_dosen

FROM mahasiswa

LEFT JOIN dosen
ON mahasiswa.id_dosen = dosen.id_dosen

WHERE mahasiswa.id_user = '$id_user'

LIMIT 1

");

/* ================= CEK QUERY ================= */

if (!$queryMhs) {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);

    exit;

}

/* ================= CEK DATA ================= */

if (mysqli_num_rows($queryMhs) > 0) {

    $dataMhs = mysqli_fetch_assoc($queryMhs);

    $id_mhs = $dataMhs['id_mhs'];

    /* ================= QUERY MATAKULIAH ================= */

    $queryKrs = $conn->prepare("

        SELECT 
            mk.kode_mk,
            mk.nama_mk,
            mk.sks

        FROM krs k

        JOIN jadwal j
        ON k.id_jadwal = j.id_jadwal

        JOIN matakuliah mk
        ON j.id_mk = mk.id_mk

        WHERE k.id_mhs = ?

    ");

    $queryKrs->bind_param("i", $id_mhs);

    $queryKrs->execute();

    $resultKrs = $queryKrs->get_result();


    $list_matkul = [];

    $total_sks = 0;

    while ($row = $resultKrs->fetch_assoc()) {

        $list_matkul[] = $row;

        $total_sks += $row['sks'];

    }

    /* ================= GABUNG DATA ================= */

    $dataMhs['matakuliah'] = $list_matkul;

    $dataMhs['total_sks'] = $total_sks;

    /* ================= OUTPUT JSON ================= */

    echo json_encode([

        "status" => "success",

        "data" => $dataMhs

    ]);

} else {

    echo json_encode([

        "status" => "error",

        "message" => "Data mahasiswa tidak ditemukan"

    ]);

}

?>