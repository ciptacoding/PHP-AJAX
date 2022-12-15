<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = "SELECT mhs.*, jrs.nama nama_jurusan
          FROM mahasiswa mhs
          JOIN jurusan jrs ON mhs.id_jurusan = jrs.id
          WHERE mhs.id = $id";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$mhs = mysqli_fetch_assoc($result);
?>

<img src="<?= URL_ROOT ?>/uploads/<?= $mhs['foto'] ?>" alt="mhs-image" class="img-thumbnail mb-3 w-25">
<ul class="list-group">
    <li class="list-group-item"><?= $mhs['nama'] ?></li>
    <li class="list-group-item"><?= $mhs['nim'] ?></li>
    <li class="list-group-item"><?= $mhs['email'] ?></li>
    <li class="list-group-item"><?= $mhs['nama_jurusan'] ?></li>
</ul>