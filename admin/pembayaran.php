<?php include("inc_header.php") ?>
<?php
$sukses = "";
$error = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Proses mengubah status pembayaran menjadi Lunas
if ($op == 'setlunas') {
    $id = $_GET['id'];
    $sql_lunas = "update pembayaran set status_bayar = 'Lunas', tanggal_bayar = now() where id_bayar = '$id'";
    $q_lunas   = mysqli_query($koneksi, $sql_lunas);
    if ($q_lunas) {
        $sukses = "Status pembayaran berhasil diperbarui menjadi Lunas";
    } else {
        $error = "Gagal memperbarui status pembayaran";
    }
}

// Proses membatalkan status lunas (set menjadi Belum Lunas)
if ($op == 'setbelum') {
    $id = $_GET['id'];
    $sql_belum = "update pembayaran set status_bayar = 'Belum Lunas', tanggal_bayar = NULL where id_bayar = '$id'";
    $q_belum   = mysqli_query($koneksi, $sql_belum);
    if ($q_belum) {
        $sukses = "Status pembayaran berhasil diperbarui menjadi Belum Lunas";
    } else {
        $error = "Gagal memperbarui status pembayaran";
    }
}
?>

<h1>Data Pembayaran Hotel</h1>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php } ?>

<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
<?php } ?>

<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Cari Nama / Metode / Status" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Pembayaran" class="btn btn-secondary" />
    </div>
</form>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>ID Booking</th>
            <th>Nama Tamu</th>
            <th>Metode</th>
            <th>Tanggal Bayar</th>
            <th>Status</th>
            <th class="col-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 10;
        
        // Pencarian berdasarkan nama tamu, metode pembayaran, atau status bayar
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(user.nama like '%" . $array_katakunci[$x] . "%' or pembayaran.metode like '%" . $array_katakunci[$x] . "%' or pembayaran.status_bayar like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        
        // Query menggunakan gabungan dua LEFT JOIN dari pembayaran -> booking -> user
        $sql1   = "select pembayaran.*, user.nama 
                   from pembayaran 
                   left join booking on pembayaran.id_booking = booking.id_booking 
                   left join user on booking.id_user = user.id_user 
                   $sqltambahan";
                   
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        
        $sql1   = $sql1." order by pembayaran.id_bayar desc limit $mulai,$per_halaman";
        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td>#<?php echo $r1['id_booking'] ?></td>
                <td><b><?php echo $r1['nama'] ?? 'Tamu Tidak Diketahui' ?></b></td>
                <td><?php echo $r1['metode'] ?></td>
                <td><?php echo $r1['tanggal_bayar'] ?? '-' ?></td>
                <td>
                    <?php 
                    if($r1['status_bayar'] == 'Lunas'){
                        echo '<span class="badge bg-success">Lunas</span>';
                    } else {
                        echo '<span class="badge bg-danger">Belum Lunas</span>';
                    }
                    ?>
                </td>
                <td>
                    <?php if($r1['status_bayar'] == 'Belum Lunas'){ ?>
                        <a href="pembayaran.php?op=setlunas&id=<?php echo $r1['id_bayar'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pembayaran ini sudah lunas?')">
                            Set Lunas
                        </a>
                    <?php } else { ?>
                        <a href="pembayaran.php?op=setbelum&id=<?php echo $r1['id_bayar'] ?>" class="btn btn-sm btn-warning text-dark" onclick="return confirm('Batalkan status lunas pembayaran ini?')">
                            Set Belum Lunas
                        </a>
                    <?php } ?>
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
                <a class="page-link" href="pembayaran.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>