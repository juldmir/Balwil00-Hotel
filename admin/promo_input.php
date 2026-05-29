<?php include("inc_header.php") ?>
<?php
$kode_promo     = "";
$diskon         = "";
$berlaku_sampai = "";
$error          = "";
$sukses         = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1   = "select * from promo where id_promo = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $kode_promo     = $r1['kode_promo'];
    $diskon         = $r1['diskon'];
    $berlaku_sampai = $r1['berlaku_sampai'];

    if($kode_promo == ''){
        $error  = "Data promo tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $kode_promo     = $_POST['kode_promo'];
    $diskon         = $_POST['diskon'];
    $berlaku_sampai = $_POST['berlaku_sampai'];
    
    if ($kode_promo == '' or $diskon == '' or $berlaku_sampai == '') {
        $error     = "Silakan masukkan semua data promo dengan lengkap.";
    }

    if (empty($error)) {
        if($id != ""){
            $sql1   = "update promo set kode_promo = '$kode_promo', diskon='$diskon', berlaku_sampai='$berlaku_sampai' where id_promo = '$id'";
        }else{
            $sql1       = "insert into promo(kode_promo, diskon, berlaku_sampai) values ('$kode_promo', '$diskon', '$berlaku_sampai')";
        }
        
        $q1         = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses     = "Sukses menyimpan data promo";
        } else {
            $error      = "Gagal memasukkan data";
        }
    }
}
?>

<h1>Admin Input Data Promo</h1>
<div class="mb-3 row">
    <a href="promo.php"><< Kembali ke daftar promo</a>
</div>

<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
<?php } ?>

<?php if ($sukses) { ?>
    <div class="alert alert-primary" role="alert"><?php echo $sukses ?></div>
<?php } ?>

<form action="" method="post">
    <div class="mb-3 row">
        <label for="kode_promo" class="col-sm-2 col-form-label">Kode Promo</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="kode_promo" value="<?php echo $kode_promo ?>" name="kode_promo" placeholder="Misal: PROMOHEMAT">
        </div>
    </div>
    
    <div class="mb-3 row">
        <label for="diskon" class="col-sm-2 col-form-label">Diskon (%)</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="diskon" value="<?php echo $diskon ?>" name="diskon" placeholder="Misal: 15">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="berlaku_sampai" class="col-sm-2 col-form-label">Berlaku Sampai</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" id="berlaku_sampai" value="<?php echo $berlaku_sampai ?>" name="berlaku_sampai">
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