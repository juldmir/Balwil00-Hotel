<?php include("inc_header.php") ?>
<?php
$sukses = "";
// Amankan input katakunci
$katakunci = (isset($_GET['katakunci'])) ? mysqli_real_escape_string($koneksi, $_GET['katakunci']) : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Proses Hapus Data Tipe Kamar
if ($op == 'delete') {
    // Amankan ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil nama file foto buat dihapus dari folder
    $sql1 = "select foto from tipe_kamar where id_tipe = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    if ($r1['foto'] != '') {
        @unlink("../gambar/" . $r1['foto']);
    }

    // Hapus baris data dari tabel
    $sql1 = "delete from tipe_kamar where id_tipe = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil menghapus data tipe kamar";
    }
}
?>
<h1>Data Tipe Kamar Hotel</h1>
<p>
    <a href="tipe_kamar_input.php">
        <input type="button" class="btn btn-primary" value="Tambah Tipe Kamar Baru" />
    </a>
</p>
<?php
if ($sukses) {
    ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
    <?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan Nama Tipe" name="katakunci"
            value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Tipe Kamar" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th class="col-2">Foto</th>
            <th>Nama Tipe</th>
            <th>Harga/Malam</th>
            <th>Stok</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 5;

        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(nama_tipe like '%" . $array_katakunci[$x] . "%' or fasilitas like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan = " where " . implode(" or ", $sqlcari);
        }

        $sql1 = "select * from tipe_kamar $sqltambahan";
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1 = mysqli_query($koneksi, $sql1);
        $total = mysqli_num_rows($q1);
        $pages = ceil($total / $per_halaman);
        $nomor = $mulai + 1;

        // Order data berdasarkan id_tipe yang terbaru
        $sql1 = $sql1 . " order by id_tipe desc limit $mulai,$per_halaman";

        $q1 = mysqli_query($koneksi, $sql1);

        while ($r1 = mysqli_fetch_array($q1)) {
            ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td>
                    <?php if ($r1['foto'] != '') { ?>
                        <img src="../gambar/<?php echo $r1['foto'] ?>"
                            style="max-height:100px;max-width:100px; border-radius:5px;" />
                    <?php } else {
                        echo "-";
                    } ?>
                </td>
                <td><?php echo $r1['nama_tipe'] ?></td>
                <td>Rp <?php echo number_format($r1['harga'], 0, ',', '.') ?></td>
                <td>
                    <?php if ($r1['stok'] == 0) { ?>
                        <span class="badge bg-danger">Habis</span>
                    <?php } else { ?>
                        <span class="badge bg-success"><?php echo $r1['stok']; ?> Tersedia</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="tipe_kamar_input.php?id=<?php echo $r1['id_tipe'] ?>" class="text-decoration-none">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>

                    <a href="tipe_kamar.php?op=delete&id=<?php echo $r1['id_tipe'] ?>" class="text-decoration-none"
                        onclick="return confirm('Yakin mau hapus tipe kamar ini?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
        $cari = isset($_GET['cari']) ? $_GET['cari'] : "";

        for ($i = 1; $i <= $pages; $i++) {
            ?>
            <li class="page-item">
                <a class="page-link"
                    href="tipe_kamar.php?katakunci=<?php echo $katakunci ?>&cari=<?php echo $cari ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>