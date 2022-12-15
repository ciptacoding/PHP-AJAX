<?php
include 'koneksi.php';

$perPage = isset($_GET['perPage']) ? (int) $_GET['perPage'] : 2;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$query = "SELECT mhs.*, jrs.nama nama_jurusan 
          FROM mahasiswa mhs
          JOIN jurusan jrs ON mhs.id_jurusan = jrs.id";

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
  $keyword = $_GET['keyword'];
  $query .= " WHERE mhs.nama LIKE '%$keyword%' OR
                    mhs.nim LIKE '%$keyword%' OR
                    jrs.nama LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$total = mysqli_num_rows($result);
$pages = ceil($total / $perPage);

$result = mysqli_query($conn, "$query LIMIT $start, $perPage") or die(mysqli_error($conn));

$pageArr = [];
if ($pages > 3) {
  if ($page < 4) {
    for ($count = 1; $count <= 4; $count++) {
      $pageArr[] = $count;
    }
  } else {
    $endLimit = $pages - 3;
    if ($page > $endLimit) {
      for ($count = $endLimit; $count <= $pages; $count++) {
        $pageArr[] = $count;
      }
    } else {
      for ($count = $page - 3; $count <= $page + 3; $count++) {
        $pageArr[] = $count;
      }
    }
  }
} else {
  for ($count = 1; $count <= $pages; $count++) {
    $pageArr[] = $count;
  }
}
?>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) == 0) : ?>
        <tr class="text-nowrap">
          <td colspan="6" class="text-center text-danger">Data tidak ditemukan!</td>
        </tr>
      <?php endif ?>
      <?php $i = $start + 1; ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <th class="align-middle text-nowrap" scope="row"><?= $i++ ?></th>
          <td class="align-middle text-nowrap"><?= $row['nama'] ?></td>
          <td class="align-middle text-nowrap">
            <a href="javascript:void(0)" class="py-0 btn btn-info btn-sm detail-mhs" data-id="<?= $row['id'] ?>" data-toggle="modal" data-target="#detailMhsModal">Detail</a>
            <a href="javascript:void(0)" class="py-0 btn btn-primary btn-sm edit-mhs" data-id="<?= $row['id'] ?>">Edit</a>
            <a href="javascript:void(0)" class="py-0 btn btn-secondary btn-sm delete-mhs" data-id="<?= $row['id'] ?>">Delete</a>
          </td>
        </tr>
      <?php endwhile ?>
    </tbody>
  </table>
</div>

<div class="row justify-content-between align-items-center">
  <div class="col-auto">
    <p class="mb-0">Total: <?= $total ?></p>
  </div>
  <div class="col-auto">
    <nav aria-label="Page navigation">
      <ul class="pagination mb-0">

        <?php if ($page > 1) : ?>
          <li class="page-item"><a href="javascript:void(0)" class="page-link" data-page="1">First</a></li>
          <li class="page-item"><a href="javascript:void(0)" class="page-link" data-page="<?= ($page - 1) ?>">&laquo;</a></li>
        <?php endif ?>

        <?php for ($count = 0; $count < count($pageArr); $count++) : ?>
          <li class="page-item <?= ($page == $pageArr[$count]) ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="page-link" data-page="<?= $pageArr[$count] ?>"><?= $pageArr[$count] ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $pages) : ?>
          <li class="page-item"><a href="javascript:void(0)" class="page-link" data-page="<?= ($page + 1) ?>">&raquo;</a></li>
          <li class="page-item"><a href="javascript:void(0)" class="page-link" data-page="<?= $pages ?>">Last</a></li>
        <?php endif ?>

      </ul>
    </nav>
  </div>
</div>