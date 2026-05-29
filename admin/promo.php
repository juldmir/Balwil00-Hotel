<?php include("inc_header.php") ?>
<?php
$sukses = "";
// Amankan input pencarian
$katakunci = (isset($_GET['katakunci'])) ? mysqli_real_escape_string($koneksi, $_GET['katakunci']) : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Proses delete disesuaikan dengan primary key id_promo
if ($op == 'delete') {
    // Amankan parameter ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql1   = "delete from promo where id_promo = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil hapus data promo";
    }
}
?>
<h1>Data Promo Hotel</h1>
<p>
    <a href="promo_input.php">
        <input type="button" class="btn btn-primary" value="Buat Promo Baru" />
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
        <input type="text" class="form-control" placeholder="Masukkan Kode Promo" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Promo" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Kode Promo</th>
            <th>Diskon (%)</th>
            <th>Berlaku Sampai</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 5; // dibikin 5 aja biar halamannya gak terlalu cepet pindah
        
        // Pencarian disesuaikan ke kolom kode_promo
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(kode_promo like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        
        $sql1   = "select * from promo $sqltambahan";
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        
        // Order by PK id_promo
        $sql1   = $sql1." order by id_promo desc limit $mulai,$per_halaman";
        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['kode_promo'] ?></td>
                <td><?php echo $r1['diskon'] ?></td>
                <td><?php echo $r1['berlaku_sampai'] ?></td>
                
                <td>
                    <a href="promo_input.php?id=<?php echo $r1['id_promo']?>" class="text-decoration-none">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>

                    <a href="promo.php?op=delete&id=<?php echo $r1['id_promo'] ?>" class="text-decoration-none" onclick="return confirm('Yakin mau hapus promo ini?')">
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
                <a class="page-link" href="promo.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>