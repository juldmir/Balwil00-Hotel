<?php include("inc_header.php") ?>
<?php
$sukses = "";
// Amankan input kata kunci pencarian
$katakunci = (isset($_GET['katakunci'])) ? mysqli_real_escape_string($koneksi, $_GET['katakunci']) : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Proses Hapus Data Kamar Fisik
if ($op == 'delete') {
    // Amankan ID sebelum masuk ke query
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql1   = "delete from kamar where id_kamar = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil menghapus data kamar";
    }
}
?>
<h1>Data Kamar Fisik Hotel</h1>
<p>
    <a href="kamar_input.php">
        <input type="button" class="btn btn-primary" value="Tambah Kamar Baru" />
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
        <input type="text" class="form-control" placeholder="Cari Nomor/Tipe Kamar" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Kamar" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Nomor Kamar</th>
            <th>Tipe Kamar</th>
            <th>Status</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 10; // Dibikin 10 karena jumlah kamar biasanya banyak
        
        // Pencarian menggunakan JOIN agar bisa mencari berdasarkan nama tipe juga
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(kamar.nomor_kamar like '%" . $array_katakunci[$x] . "%' or tipe_kamar.nama_tipe like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        
        // Query menggunakan LEFT JOIN untuk menggabungkan tabel kamar dan tipe_kamar
        $sql1   = "select kamar.*, tipe_kamar.nama_tipe from kamar left join tipe_kamar on kamar.id_tipe = tipe_kamar.id_tipe $sqltambahan";
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        
        // Order by PK id_kamar
        $sql1   = $sql1." order by kamar.id_kamar desc limit $mulai,$per_halaman";

        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><b><?php echo $r1['nomor_kamar'] ?></b></td>
                <td><?php echo $r1['nama_tipe'] ?></td>
                <td>
                    <?php 
                    // Memberikan warna badge sesuai status kamar
                    if($r1['status_kamar'] == 'Tersedia'){
                        echo '<span class="badge bg-success">Tersedia</span>';
                    } elseif($r1['status_kamar'] == 'Terisi') {
                        echo '<span class="badge bg-danger">Terisi</span>';
                    } else {
                        echo '<span class="badge bg-warning text-dark">Maintenance</span>';
                    }
                    ?>
                </td>
                <td>
                    <a href="kamar_input.php?id=<?php echo $r1['id_kamar']?>" class="text-decoration-none">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>

                    <a href="kamar.php?op=delete&id=<?php echo $r1['id_kamar'] ?>" class="text-decoration-none" onclick="return confirm('Yakin mau menghapus data kamar ini?')">
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
        $cari = isset($_GET['cari'])? $_GET['cari'] : "";

        for($i=1; $i <= $pages; $i++){
            ?>
            <li class="page-item">
                <a class="page-link" href="kamar.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>