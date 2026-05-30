<?php

header('Content-Type: application/json');

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_krs = $_POST['id_krs'];
    $nilai = $_POST['nilai'];

    for ($i = 0; $i < count($id_krs); $i++) {

        $idkrs = $id_krs[$i];
        $nilaimhs = intval($nilai[$i]);

        if ($nilaimhs >= 85) {
            $grade = "A";
        } elseif ($nilaimhs >= 80) {
            $grade = "A-";
        } elseif ($nilaimhs >= 75) {
            $grade = "B+";
        } elseif ($nilaimhs >= 70) {
            $grade = "B";
        } elseif ($nilaimhs >= 65) {
            $grade = "B-";
        } elseif ($nilaimhs >= 60) {
            $grade = "C+";
        } elseif ($nilaimhs >= 55) {
            $grade = "C";
        } elseif ($nilaimhs >= 40) {
            $grade = "D";
        } else {
            $grade = "E";
        }

        $query = "
            UPDATE krs
            SET 
                nilai_akhir = '$nilaimhs',
                huruf_mutu = '$grade'
            WHERE id_krs = '$idkrs'
        ";

        mysqli_query($conn, $query);
    }

    echo json_encode([
        "status" => "success",
        "message" => "Nilai berhasil disimpan"
    ]);
}
?>