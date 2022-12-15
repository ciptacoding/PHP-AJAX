<?php
require 'koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM jurusan") or die(mysqli_error($conn));
$jurusan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jurusan[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($jurusan);
