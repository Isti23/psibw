<?php

include "koneksi.php";
session_start();

if (!isset($_SESSION['id_user'])) {

    echo json_encode([
        "status" => "error",
        "message" => "Session login tidak ditemukan"
    ]);

    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
SELECT * FROM dosen
WHERE id_user='$id_user'
");

$data = mysqli_fetch_assoc($query);

if ($data) {

    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Data dosen tidak ditemukan"
    ]);
}