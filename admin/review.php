<?php include("inc_header.php") ?>
<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Proses hapus ulasan jika ada spam atau komentar tidak layak
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "delete from review where id_review = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Ulasan berhasil dihapus";
    }
}
?>
<h1>Ulasan dan Rating Tamu</h1>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php } ?>

<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Cari Nama Tamu / Isi Ulasan" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Ulasan" class="btn btn-secondary" />
    </div>
</form>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Nama Tamu</th>
            <th class="col-2">Rating</th>
            <th>Komentar</th>
            <th>Tanggal Ulasan</th>
            <th class="col-1">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 10;
        
        // Pencarian berdasarkan nama tamu atau isi teks komentar
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(user.nama like '%" . $array_katakunci[$x] . "%' or review.komentar like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        
        // Relasi ganda untuk mendapatkan nama pengguna yang memberikan ulasan
        $sql1   = "select review.*, user.nama 
                   from review 
                   left join booking on review.id_booking = booking.id_booking 
                   left join user on booking.id_user = user.id_user 
                   $sqltambahan";
                   
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        
        $sql1   = $sql1." order by review.id_review desc limit $mulai,$per_halaman";
        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><b><?php echo $r1['nama'] ?? 'Anonim' ?></b></td>
                <td>
                    <?php 
                    // Mengubah nilai angka rating menjadi tampilan visual bintang sederhana
                    $bintang = (int)$r1['rating'];
                    for($i = 1; $i <= 5; $i++){
                        if($i <= $bintang){
                            echo '<span class="text-warning">★</span>';
                        } else {
                            echo '<span class="text-muted">☆</span>';
                        }
                    }
                    echo " (" . $bintang . "/5)";
                    ?>
                </td>
                <td><?php echo $r1['komentar']; ?></td>
                <td><?php echo $r1['tanggal'] ?></td>
                <td>
                    <a href="review.php?op=delete&id=<?php echo $r1['id_review'] ?>" onclick="return confirm('Hapus ulasan dari tamu ini?')" class="badge bg-danger text-decoration-none">
                        Delete
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
                <a class="page-link" href="review.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>