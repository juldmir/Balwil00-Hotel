<?php include("inc_header.php") ?>
<?php
$id_tipe        = "";
$nomor_kamar    = "";
$status_kamar   = "";

$error      = "";
$sukses     = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

// Ambil data kamar kalau mode edit
if($id != ""){
    $sql1   = "select * from kamar where id_kamar = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    
    $id_tipe        = $r1['id_tipe'];
    $nomor_kamar    = $r1['nomor_kamar'];
    $status_kamar   = $r1['status_kamar'];

    if($nomor_kamar == ''){
        $error  = "Data kamar tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $id_tipe        = $_POST['id_tipe'];
    $nomor_kamar    = $_POST['nomor_kamar'];
    $status_kamar   = $_POST['status_kamar'];

    if ($id_tipe == '' or $nomor_kamar == '' or $status_kamar == '') {
        $error     = "Silakan lengkapi semua isian.";
    }

    if (empty($error)) {
        if($id != ""){
            $sql1   = "update kamar set id_tipe = '$id_tipe', nomor_kamar = '$nomor_kamar', status_kamar = '$status_kamar' where id_kamar = '$id'";
        }else{
            $sql1       = "insert into kamar(id_tipe, nomor_kamar, status_kamar) values ('$id_tipe', '$nomor_kamar', '$status_kamar')";
        }
        
        $q1         = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses     = "Sukses menyimpan data kamar fisik";
        } else {
            $error      = "Gagal menyimpan data";
        }
    }
}
?>

<h1>Input Data Kamar Fisik</h1>
<div class="mb-3 row">
    <a href="kamar.php"><< Kembali ke daftar kamar</a>
</div>

<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
<?php } ?>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert"><?php echo $sukses ?></div>
<?php } ?>

<form action="" method="post">
    
    <div class="mb-3 row">
        <label for="id_tipe" class="col-sm-2 col-form-label">Tipe Kamar</label>
        <div class="col-sm-10">
            <select name="id_tipe" class="form-control" id="id_tipe">
                <option value="">- Pilih Tipe Kamar -</option>
                <?php
                // Ambil daftar tipe kamar dari database untuk dropdown
                $sql_tipe = "SELECT id_tipe, nama_tipe FROM tipe_kamar ORDER BY nama_tipe ASC";
                $q_tipe   = mysqli_query($koneksi, $sql_tipe);
                while($r_tipe = mysqli_fetch_array($q_tipe)){
                    $selected = ($id_tipe == $r_tipe['id_tipe']) ? "selected" : "";
                    echo "<option value='".$r_tipe['id_tipe']."' $selected>".$r_tipe['nama_tipe']."</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="nomor_kamar" class="col-sm-2 col-form-label">Nomor Kamar</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nomor_kamar" value="<?php echo $nomor_kamar ?>" name="nomor_kamar" placeholder="Misal: 101, 102, 201A">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="status_kamar" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <select name="status_kamar" class="form-control" id="status_kamar">
                <option value="Tersedia" <?php if($status_kamar == 'Tersedia') echo 'selected' ?>>Tersedia</option>
                <option value="Terisi" <?php if($status_kamar == 'Terisi') echo 'selected' ?>>Terisi</option>
                <option value="Maintenance" <?php if($status_kamar == 'Maintenance') echo 'selected' ?>>Maintenance</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>

<?php include("inc_footer.php") ?>