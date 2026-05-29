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

// hapus data booking
if ($op == 'delete') {
    // Amankan parameter ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // opsional: kalau mau hapus booking, hapus data pembayaran dan review terkait dulu biar gak error foreign key
    @mysqli_query($koneksi, "delete from pembayaran where id_booking = '$id'");
    @mysqli_query($koneksi, "delete from review where id_booking = '$id'");
    
    $sql1   = "delete from booking where id_booking = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil menghapus data pesanan";
    }
}
?>
<h1>Data Booking Hotel</h1>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php } ?>

<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Cari Nama Tamu / Status" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Pesanan" class="btn btn-secondary" />
    </div>
</form>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Nama Tamu</th>
            <th>Kamar</th>
            <th>Tgl Check-in</th>
            <th>Tgl Check-out</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 10;
        
        // pencarian berdasarkan nama tamu atau status booking
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(user.nama like '%" . $array_katakunci[$x] . "%' or booking.status like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        
        // join ke tabel user, kamar, dan tipe_kamar
        $sql1   = "select booking.*, user.nama, kamar.nomor_kamar, tipe_kamar.nama_tipe 
                   from booking 
                   left join user on booking.id_user = user.id_user 
                   left join kamar on booking.id_kamar = kamar.id_kamar 
                   left join tipe_kamar on kamar.id_tipe = tipe_kamar.id_tipe 
                   $sqltambahan";
                   
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        
        $sql1   = $sql1." order by booking.id_booking desc limit $mulai,$per_halaman";
        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><b><?php echo $r1['nama'] ?></b></td>
                <td>
                    <?php echo $r1['nama_tipe'] ?><br>
                    <small class="text-muted">No: <?php echo $r1['nomor_kamar'] ?? 'Belum diset' ?></small>
                </td>
                <td><?php echo $r1['checkin'] ?></td>
                <td><?php echo $r1['checkout'] ?></td>
                <td>Rp <?php echo number_format($r1['total_harga'], 0, ',', '.') ?></td>
                <td>
                    <?php 
                    if($r1['status'] == 'Confirmed'){
                        echo '<span class="badge bg-success">Confirmed</span>';
                    } elseif($r1['status'] == 'Pending') {
                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                    } elseif($r1['status'] == 'Canceled') {
                        echo '<span class="badge bg-danger">Canceled</span>';
                    } else {
                        echo '<span class="badge bg-secondary">'.$r1['status'].'</span>';
                    }
                    ?>
                </td>
                <td>
                    <a href="booking_edit.php?id=<?php echo $r1['id_booking']?>" class="text-decoration-none">
                        <span class="badge bg-primary">Ubah Status</span>
                    </a>

                    <a href="booking.php?op=delete&id=<?php echo $r1['id_booking'] ?>" class="text-decoration-none" onclick="return confirm('Hapus data pesanan ini secara permanen?')">
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
                <a class="page-link" href="booking.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>