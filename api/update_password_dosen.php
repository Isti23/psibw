<?php

include "koneksi.php";
session_start();

$id_user = $_SESSION['id_user'];

$password = $_POST['password'];

mysqli_query($conn, "
UPDATE users SET
password='$password'
WHERE id_user='$id_user'
");

echo json_encode([
  "status" => "success",
  "message" => "Password berhasil diubah"
]);