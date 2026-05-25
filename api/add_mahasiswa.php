<?php
session_start();
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Akses ditolak."]);
    exit;
}

header('Content-Type: application/json');
include 'koneksi.php';

// 1. Tangkap semua data
$nim = $_POST['nim'] ?? '';
$nama_mhs = $_POST['nama_mhs'] ?? '';
$email = $_POST['email'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$semester = $_POST['semester'] ?? '';
$fakultas = $_POST['fakultas'] ?? '';
$jurusan = $_POST['jurusan'] ?? ''; // <-- Tambahan Jurusan
$prodi = $_POST['prodi'] ?? '';

if(empty($nim) || empty($nama_mhs)) {
    echo json_encode(["status" => "error", "message" => "NIM dan Nama tidak boleh kosong."]);
    exit;
}

// 2. Logika bikin password otomatis
$nama_depan = strtolower(explode(' ', trim($nama_mhs))[0]);
$tiga_angka_nim = substr($nim, -3);
$password = $nama_depan . $tiga_angka_nim;
$role = 'mahasiswa';

// 3. Insert ke database
$query_user = "INSERT INTO users (username, password, role) VALUES ('$nim', '$password', '$role')";

if ($conn->query($query_user) === TRUE) {
    $id_user = $conn->insert_id;

    // Foto otomatis 'default.jpg' dan IPK otomatis 0.00
    $query_mhs = "INSERT INTO mahasiswa (id_user, nim, nama_mhs, email, jenis_kelamin, tempat_lahir, tanggal_lahir, semester, fakultas, jurusan, prodi, ipk, foto) 
                  VALUES ('$id_user', '$nim', '$nama_mhs', '$email', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$semester', '$fakultas', '$jurusan', '$prodi', 0.00, 'default.jpg')";
    
    if ($conn->query($query_mhs) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data berhasil ditambahkan!"]);
    } else {
        $conn->query("DELETE FROM users WHERE id_user = '$id_user'");
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan biodata: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Gagal membuat akun login: " . $conn->error]);
}

$conn->close();
?>