<?php
session_start();
include 'koneksi.php'; // Pastikan nama file koneksi databasenya benar

header('Content-Type: application/json');

// 1. Cek siapa yang lagi login (Biasanya dari session id_user atau username)
// Asumsi: waktu login, kamu menyimpan id_user di $_SESSION['id_user']
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Sesi login tidak ditemukan. Silakan login ulang."]);
    exit;
}

$id_user = $_SESSION['id_user'];

// 2. Ambil data biodata mahasiswa berdasarkan id_user yang login
$queryMhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id_user = '$id_user'");

if ($queryMhs && mysqli_num_rows($queryMhs) > 0) {
    // Tarik datanya jadi array
    $dataMhs = mysqli_fetch_assoc($queryMhs);
    $id_mhs = $dataMhs['id_mhs']; // Kita butuh id_mhs ini buat cari matkul di tabel KRS

    // 3. Ambil data matakuliah yang diambil (JOIN krs dan matakuliah)
    $queryKrs = mysqli_query($conn, "
        SELECT matakuliah.kode_mk, matakuliah.nama_mk 
        FROM krs 
        JOIN matakuliah ON krs.id_mk = matakuliah.id_mk 
        WHERE krs.id_mhs = '$id_mhs'
    ");

    $list_matkul = [];
    if ($queryKrs) {
        while ($row = mysqli_fetch_assoc($queryKrs)) {
            $list_matkul[] = $row; // Masukkan ke dalam daftar
        }
    }

    // 4. Sisipkan daftar matakuliah ke dalam biodata mahasiswa
    $dataMhs['matakuliah'] = $list_matkul;

    // 5. Lempar datanya ke Javascript di depan dalam bentuk JSON
    echo json_encode([
        "status" => "success",
        "data" => $dataMhs
    ]);

} else {
    // Kalau id_user nya gak ketemu di tabel mahasiswa
    echo json_encode([
        "status" => "error", 
        "message" => "Data mahasiswa tidak ditemukan di database."
    ]);
}
?>