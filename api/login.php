<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

// Cuma nangkap 2 data dari form
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Kalau salah satu kosong, kasih tau data tidak lengkap
if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap. Harap isi Username dan Password!"]);
    exit;
}

// Cek ke tabel users apakah akunnya ada
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    // Kalau ketemu, ambil datanya
    $user = $result->fetch_assoc();
    
    // Simpan data ke session biar tetap login pas pindah halaman
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role']; // Role otomatis diambil dari database

    // Kirim balasan sukses ke JavaScript beserta role-nya
    echo json_encode([
        "status" => "success", 
        "message" => "Login berhasil",
        "role" => $user['role']
    ]);
} else {
    // Kalau username atau password salah
    echo json_encode(["status" => "error", "message" => "Username atau Password salah!"]);
}

$conn->close();
?>