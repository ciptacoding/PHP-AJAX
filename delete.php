<?php
include 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id = $id");
$mhs = mysqli_fetch_assoc($result);

if ($mhs['foto'] != 'default.jpg') {
    $file = APP_ROOT . '//uploads/' . $mhs['foto'];
    if (file_exists($file))
        unlink($file);
}

$result = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id") or die(mysqli_error($conn));
if ($result) {
    echo 'Data berhasil dihapus!';
}
