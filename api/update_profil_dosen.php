<?php

include "koneksi.php";
session_start();

$id_user = $_SESSION['id_user'];

$nama = $_POST['nama'];
$email = $_POST['email'];
$hp = $_POST['hp'];
$jk = $_POST['jk'];
$alamat = $_POST['alamat'];

mysqli_query($conn, "
UPDATE dosen SET
nama_dosen='$nama',
email='$email',
no_hp='$hp',
jenis_kelamin='$jk',
alamat='$alamat'
WHERE id_user='$id_user'
");

echo json_encode([
  "status" => "success",
  "message" => "Profil berhasil diperbarui"
]);