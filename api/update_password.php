<?php

session_start();
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {

    echo json_encode([
        "status" => "error",
        "message" => "Silakan login terlebih dahulu"
    ]);
    exit;
}

$id_user = $_SESSION['id_user'];

$password_lama = $_POST['password_lama'] ?? '';
$password_baru = $_POST['password_baru'] ?? '';

if (
    empty($password_lama) ||
    empty($password_baru)
) {

    echo json_encode([
        "status" => "error",
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

/* cek password lama */

$query = mysqli_query(
    $conn,
    "SELECT password
     FROM users
     WHERE id_user = '$id_user'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {

    echo json_encode([
        "status" => "error",
        "message" => "User tidak ditemukan"
    ]);
    exit;
}

/* validasi password lama */

if ($user['password'] != $password_lama) {

    echo json_encode([
        "status" => "error",
        "message" => "Password lama salah"
    ]);
    exit;
}

/* update password */

$update = mysqli_query(
    $conn,
    "UPDATE users
     SET password = '$password_baru'
     WHERE id_user = '$id_user'"
);

if ($update) {

    echo json_encode([
        "status" => "success",
        "message" => "Password berhasil diubah"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Gagal mengubah password"
    ]);
}

$conn->close();

?>