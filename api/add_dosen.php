<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nidn = $_POST['nidn'] ?? '';
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$alamat = $_POST['alamat'] ?? '';

if (empty($nidn) || empty($nama)) {
    echo json_encode(["status" => "error", "message" => "NIDN dan Nama Dosen tidak boleh kosong!"]);
    exit;
}

$conn->begin_transaction();

try {
    $cek = $conn->query("SELECT nidn FROM dosen WHERE nidn = '$nidn'");
    if ($cek->num_rows > 0) {
        throw new Exception("NIDN sudah terdaftar di sistem!");
    }
    $nama_depan = strtolower(explode(' ', trim($nama))[0]);
    $tiga_digit_nidn = substr($nidn, -3);
    $password_otomatis = $nama_depan . $tiga_digit_nidn;

    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$nidn', '$password_otomatis', 'dosen')";
    if (!$conn->query($sql_user)) {
        throw new Exception("Gagal membuat akun user dosen.");
    }

    $id_user = $conn->insert_id;

    $sql_dosen = "INSERT INTO dosen (id_user, nidn, nama_dosen, email, no_hp, jenis_kelamin, alamat, foto) 
                  VALUES ('$id_user', '$nidn', '$nama', '$email', '$no_hp', '$jenis_kelamin', '$alamat', 'default.jpg')";
                  
    if (!$conn->query($sql_dosen)) {
        throw new Exception("Gagal menyimpan biodata dosen.");
    }

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data dosen dan akun berhasil ditambahkan!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>