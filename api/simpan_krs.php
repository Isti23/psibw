<?php

session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if(!isset($_SESSION['id_user'])){
    echo json_encode([
        "status" => "error",
        "message" => "Session login tidak ditemukan"
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];
$queryMhs = mysqli_query($conn,

"SELECT id_mhs
 FROM mahasiswa
 WHERE id_user = '$id_user'"

);

$dataMhs = mysqli_fetch_assoc($queryMhs);
$id_mhs = $dataMhs['id_mhs'];
$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['jadwal'])){
    echo json_encode([
        "status" => "error",
        "message" => "Tidak ada mata kuliah dipilih"
    ]);
    exit;
}

$jadwalDipilih = $data['jadwal'];

foreach($jadwalDipilih as $id_jadwal){
    $cekDuplicate = mysqli_query($conn,
    "SELECT *
     FROM krs
     WHERE id_mhs = '$id_mhs'
     AND id_jadwal = '$id_jadwal'"
    );
    if(mysqli_num_rows($cekDuplicate) > 0){
        echo json_encode([
            "status" => "error",
            "message" => "Ada mata kuliah yang sudah pernah diambil"
        ]);
        exit;
    }
    $cekKuota = mysqli_query($conn,
    "SELECT COUNT(*) as total
     FROM krs
     WHERE id_jadwal = '$id_jadwal'"
    );

    $dataKuota = mysqli_fetch_assoc($cekKuota);

    if($dataKuota['total'] >= 40){
        echo json_encode([
            "status" => "error",
            "message" => "Salah satu kelas sudah penuh (maksimal 40 mahasiswa)"
        ]);
        exit;
    }
}

foreach($jadwalDipilih as $id_jadwal){
    mysqli_query($conn,
    "INSERT INTO krs(id_mhs, id_jadwal)
     VALUES('$id_mhs', '$id_jadwal')"
    );
}

echo json_encode([
    "status" => "success",
    "message" => "KRS berhasil disimpan"
]);

?>