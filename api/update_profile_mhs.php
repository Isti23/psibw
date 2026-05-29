<?php

session_start();

include 'koneksi.php';

header('Content-Type: application/json');

/* ================= CEK SESSION ================= */

if (!isset($_SESSION['id_user'])) {

    echo json_encode([
        "status" => "error",
        "message" => "Session login tidak ditemukan"
    ]);

    exit;

}

$id_user = $_SESSION['id_user'];

/* ================= AMBIL DATA ================= */

$email = $_POST['email'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$alamat = $_POST['alamat'] ?? '';

/* ================= AMBIL FOTO LAMA ================= */

$query = mysqli_query(
    $conn,
    "SELECT foto FROM mahasiswa WHERE id_user = '$id_user'"
);

$data = mysqli_fetch_assoc($query);

$foto = $data['foto'];

/* ================= UPLOAD FOTO ================= */

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

    $namaFoto = "mhs_" . time() . "." . $ext;

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "../foto/" . $namaFoto
    );

    $foto = $namaFoto;

}

/* ================= UPDATE ================= */

$sql = "

UPDATE mahasiswa SET

email = '$email',
no_hp = '$no_hp',
alamat = '$alamat',
foto = '$foto'

WHERE id_user = '$id_user'

";

if (mysqli_query($conn, $sql)) {

    echo json_encode([

        "status" => "success",

        "message" => "Profil berhasil diperbarui"

    ]);

} else {

    echo json_encode([

        "status" => "error",

        "message" => mysqli_error($conn)

    ]);

}

?>