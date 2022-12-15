<?php
include 'koneksi.php';

$error = "";

if (empty($error)) {
    $email = $_POST['email'];
    $query = "SELECT * FROM mahasiswa WHERE email = '$email'";

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $query .= " AND id != $id";
    }

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
        $error = "Email sudah digunakan!";
    } else {
        $error = "";
    }
}

echo $error;
