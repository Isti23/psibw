<?php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT * FROM mahasiswa ORDER BY id_mhs DESC";
$result = $conn->query($query);

$data = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

$conn->close();
?>