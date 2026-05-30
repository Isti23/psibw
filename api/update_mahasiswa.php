<?php
header('Content-Type: application/json');
include 'koneksi.php';

$id_mhs = isset($_POST['id_mhs']) ? intval($_POST['id_mhs']) : 0;
$nim = $_POST['nim'] ?? '';
$nama_mhs = $_POST['nama_mhs'] ?? ''; 
$email = $_POST['email'] ?? ''; 
$jenis_kelamin = $_POST['jenis_kelamin'] ?? ''; 
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = !empty($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
$semester = !empty($_POST['semester']) ? intval($_POST['semester']) : 4;
$fakultas = $_POST['fakultas'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$prodi = $_POST['prodi'] ?? '';

if ($id_mhs == 0 || empty($nim) || empty($nama_mhs)) {
    echo json_encode(["status" => "error", "message" => "ID, NIM, dan Nama tidak boleh kosong!"]);
    exit;
}

$conn->begin_transaction();

try {
    $res = $conn->query("SELECT id_user, foto FROM mahasiswa WHERE id_mhs = '$id_mhs'");
    if ($res->num_rows == 0) {
        throw new Exception("Mahasiswa tidak ditemukan.");
    }
    $mhs_old = $res->fetch_assoc();
    $id_user = $mhs_old['id_user'];
    $foto = $mhs_old['foto'];

    $conn->query("UPDATE users SET username = '$nim' WHERE id_user = '$id_user'");

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = "mhs_" . $nim . "_" . time() . "." . $ext;
        
        move_uploaded_file($_FILES['foto']['tmp_name'], "../foto/" . $foto);
    }

    $tgl_lahir_val = $tanggal_lahir ? "'$tanggal_lahir'" : "NULL";
    
    $sql_update = "UPDATE mahasiswa SET 
                    nim = '$nim', 
                    nama_mhs = '$nama_mhs', 
                    email = '$email',
                    jenis_kelamin = '$jenis_kelamin',
                    tempat_lahir = '$tempat_lahir', 
                    tanggal_lahir = $tgl_lahir_val, 
                    semester = '$semester', 
                    fakultas = '$fakultas', 
                    jurusan = '$jurusan', 
                    prodi = '$prodi', 
                    foto = '$foto' 
                   WHERE id_mhs = '$id_mhs'";
                   
    if(!$conn->query($sql_update)){
        throw new Exception("Gagal update data: " . $conn->error);
    }

    $conn->commit();
    echo json_encode(["status" => "success", "message" => "Data mahasiswa berhasil diperbarui!"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>