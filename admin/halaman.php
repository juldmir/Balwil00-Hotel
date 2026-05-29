<?php include("inc_header.php"); ?>
<?php
$sukses = "";
// Amankan input pencarian
$katakunci = (isset($_GET['katakunci'])) ? mysqli_real_escape_string($koneksi, $_GET['katakunci']) : "";
$op = (isset($_GET['op'])) ? $_GET['op'] : "";

// Logika Hapus
if ($op == 'delete') {
    // Amankan parameter ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql_del = "DELETE FROM halaman WHERE id = '$id'";
    $q_del = mysqli_query($koneksi, $sql_del);
    if ($q_del) {
        $sukses = "Data berhasil dihapus.";
    }
}
?>

<h1>Halaman Admin</h1>
<p>
    <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Buat halaman baru">
    </a>
</p>

<?php if ($sukses) { ?>
    <div class="alert alert-success"><?php echo $sukses; ?></div>
<?php } ?>

<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" name="katakunci" class="form-control" placeholder="Masukkan kata kunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari" class="btn btn-secondary">
    </div>
</form>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Judul</th>
            <th>Kutipan</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for($x=0; $x<count($array_katakunci); $x++){
                $sqlcari[] = "(judul like '%" . $array_katakunci[$x] . "%' or kutipan like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan = " WHERE " . implode(" or ", $sqlcari);
        }
        
        $sql1 = "SELECT * FROM halaman " . $sqltambahan . " ORDER BY id DESC";
        $q1 = mysqli_query($koneksi, $sql1);
        $nomor = 1;
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $r1['judul']; ?></td>
                <td><?php echo $r1['kutipan']; ?></td>
                <td>
                    <a href="halaman_input.php?id=<?php echo $r1['id']; ?>" class="text-decoration-none">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>
                    
                    <a href="halaman.php?op=delete&id=<?php echo $r1['id']; ?>" class="text-decoration-none" onclick="return confirm('Yakin hapus data?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php include("inc_footer.php"); ?>