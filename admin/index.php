<?php include("inc_header.php")?>

<?php
// PROTEKSI: Cek apakah session admin_username sudah ada. 
// Jika belum login, otomatis tendang balik ke halaman login.php
if (!isset($_SESSION['admin_username'])) {
    header("location:login.php");
    exit();
}

// OPTIMASI SQL: Kapitalisasi keyword SQL untuk performa yang lebih baik

// hitung booking pending yang butuh konfirmasi metode pembayaran
$q_pending = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM booking WHERE status = 'Pending'");
$r_pending = mysqli_fetch_array($q_pending);

// hitung booking menunggu verifikasi yang buktinya sudah dikirim tapi belum dicek resepsionis
$q_verifikasi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM booking WHERE status = 'Menunggu Verifikasi'");
$r_verifikasi = mysqli_fetch_array($q_verifikasi);

// hitung fisik kamar yang statusnya masih tersedia saat ini
$q_kamar = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kamar WHERE status_kamar = 'Tersedia'");
$r_kamar = mysqli_fetch_array($q_kamar);

// hitung total omset pendapatan dari seluruh pesanan yang statusnya sudah Confirmed
$q_pendapatan = mysqli_query($koneksi, "SELECT SUM(total_harga) AS total FROM booking WHERE status = 'Confirmed'");
$r_pendapatan = mysqli_fetch_array($q_pendapatan);
$pendapatan = $r_pendapatan['total'] ?? 0;
?>

<h1>Dashboard</h1>
<p style="margin-bottom: 30px;">
    Selamat datang <b><?php echo $_SESSION['admin_username']?></b> di halaman Administrasi Hotel.
</p>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 40px; font-family: sans-serif;">
    
    <div style="flex: 1; min-width: 220px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #e74c3c;">
        <h4 style="margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase;">Booking Pending</h4>
        <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: #c62828;"><?php echo $r_pending['total'] ?></p>
    </div>
    
    <div style="flex: 1; min-width: 220px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #f39c12;">
        <h4 style="margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase;">Perlu Verifikasi</h4>
        <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: #d35400;"><?php echo $r_verifikasi['total'] ?></p>
    </div>

    <div style="flex: 1; min-width: 220px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #2ecc71;">
        <h4 style="margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase;">Kamar Tersedia</h4>
        <p style="font-size: 32px; font-weight: bold; margin: 10px 0 0 0; color: #27ae60;"><?php echo $r_kamar['total'] ?> <span style="font-size: 16px; color:#999;">/ 100</span></p>
    </div>

    <div style="flex: 1; min-width: 220px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #3498db;">
        <h4 style="margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase;">Total Pendapatan</h4>
        <p style="font-size: 22px; font-weight: bold; margin: 18px 0 0 0; color: #2980b9;">Rp <?php echo number_format($pendapatan, 0, ',', '.') ?></p>
    </div>
</div>

<div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h3>Petunjuk Operasional Resepsionis</h3>
    <p style="line-height: 1.6; margin-top: 10px;">
        Gunakan menu navigasi di atas untuk mengelola data master hotel dan transaksi tamu. Jika angka pada kotak <b>Perlu Verifikasi</b> bertambah, segera masuk ke menu manajemen pembayaran untuk memeriksa dana masuk dan mengubah status booking menjadi <i>Confirmed</i> agar nomor kamar fisik resmi terisi oleh sistem.
    </p>
</div>

<?php include("inc_footer.php")?>