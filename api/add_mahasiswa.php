<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nim = $_POST['nim'] ?? '';
$nama = $_POST['nama'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = !empty($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
$semester = !empty($_POST['semester']) ? intval($_POST['semester']) : 4;
$fakultas = $_POST['fakultas'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$prodi = $_POST['prodi'] ?? '';
$ipk = !empty($_POST['ipk']) ? floatval($_POST['ipk']) : 0.00;

if (empty($nim) || empty($nama)) {
    echo json_encode(["status" => "error", "message" => "NIM dan Nama Mahasiswa wajib diisi!"]);
    exit;
}

$conn->begin_transaction();

try {
    $check_nim = $conn->query("SELECT id_mhs FROM mahasiswa WHERE nim = '$nim'");
    if ($check_nim->num_rows > 0) {
        throw new Exception("NIM sudah terdaftar dalam sistem!");
    }

    $sql_user = "INSERT INTO users (username, password, role) VALUES ('$nim', '$nim', 'mahasiswa')";
    $conn->query($sql_user);
    $id_user = $conn->insert_id;

    $foto = 'default.jpg';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "mhs_" . $nim . "_" . time() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $foto);
    }

    $tgl_lahir_val = $tanggal_lahir ? "'$tanggal_lahir'" : "NULL";
    $sql_mhs = "INSERT INTO mahasiswa (id_user, nim, nama_mhs, tempat_lahir, tanggal_lahir, semester, fakultas, jurusan, prodi, ipk, foto) 
                VALUES ('$id_user', '$nim', '$nama', '$tempat_lahir', $tgl_lahir_val, '$semester', '$fakultas', '$jurusan', '$prodi', '$ipk', '$foto')";
    
    if(!$conn->query($sql_mhs)){
        throw new Exception("Gagal menyimpan ke tabel mahasiswa: " . $conn->error);
    }

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data mahasiswa berhasil ditambahkan!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>