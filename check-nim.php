<?php
include 'koneksi.php';

$error = "";

if (empty($error)) {
    $nim = $_POST['nim'];
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $query .= " AND id != $id";
    }

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
        $error = "Nim sudah digunakan!";
    } else {
        $error = "";
    }
}

echo $error;
