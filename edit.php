<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = "SELECT * FROM mahasiswa WHERE id = $id";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$mhs = mysqli_fetch_assoc($result);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($mhs);
