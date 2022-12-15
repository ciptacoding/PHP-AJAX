<?php
include 'koneksi.php';

$nama       = $_POST['nama'];
$nim        = $_POST['nim'];
$email      = $_POST['email'];
$jurusan    = $_POST['jurusan'];

if (isset($_FILES['foto']['name'])) {
    $fileName = $_FILES['foto']['name'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $foto = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], APP_ROOT . '//uploads/' . $foto);

    if (!empty($_POST['fotoLama'])) {
        $fotoLama = $_POST['fotoLama'];
        if ($fotoLama != 'default.jpg') {
            $file = APP_ROOT . '//uploads/' . $fotoLama;
            if (file_exists($file))
                unlink($file);
        }
    }
} else {
    $foto = empty($_POST['fotoLama']) ? 'default.jpg' : $_POST['fotoLama'];
}

if (empty($_POST['id'])) {
    $query = "INSERT INTO mahasiswa (nama, nim, email, id_jurusan, foto) 
                VALUES ('$nama', '$nim', '$email', '$jurusan', '$foto')";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if ($result) {
        echo 'Data berhasil disimpan!';
    }
} else {
    $id = $_POST['id'];
    $query  = "UPDATE 
                    mahasiswa 
                SET 
                    nama = '$nama', 
                    nim = '$nim', 
                    email = '$email', 
                    id_jurusan = '$jurusan', 
                    foto = '$foto' 
                WHERE 
                    id = $id";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if ($result) {
        echo 'Data berhasil diupdate!';
    }
}
