<?php
session_start();
header('Content-Type: application/json');
include 'koneksi.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap. Harap isi Username dan Password!"]);
    exit;
}

$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {

    $user = $result->fetch_assoc();

    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role']; 

    echo json_encode([
        "status" => "success", 
        "message" => "Login berhasil",
        "role" => $user['role']
    ]);
} else {
 
    echo json_encode(["status" => "error", "message" => "Username atau Password salah!"]);
}

$conn->close();
?>