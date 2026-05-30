<?php
session_start();
include "koneksi.php"; 

if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Sesi habis, silakan login ulang."]);
    exit;
}

$id_user = $_SESSION['id_user']; 
$pass_lama = isset($_POST['password_lama']) ? $_POST['password_lama'] : '';
$pass_baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';

if (empty($pass_baru)) {
    echo json_encode(["status" => "error", "message" => "Password baru tidak boleh kosong!"]);
    exit;
}

$sql = "SELECT * FROM users WHERE id_user = '$id_user' AND role = 'dosen'";
$query = $conn->query($sql);

if (!$query) {
    echo json_encode(["status" => "error", "message" => "Error DB: " . $conn->error]);
    exit;
}

$data = $query->fetch_assoc();

if ($data) {
    $password_di_db = $data['password']; 

    if ($password_di_db === $pass_lama || $password_di_db === md5($pass_lama)) {

        $id_user = $data['id_user'];

        $sql_update = "UPDATE users SET password = '$pass_baru' WHERE id_user = '$id_user'";
        $update = $conn->query($sql_update);
        
        if ($update) {
            echo json_encode(["status" => "success", "message" => "Password berhasil diperbarui!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal menyimpan ke database: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Password lama yang kamu masukkan salah!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data akun tidak ditemukan di tabel users."]);
}
