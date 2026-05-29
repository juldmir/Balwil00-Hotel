<?php
session_start();
// Cek login admin
if (!isset($_SESSION['admin_username'])) {
    header("location:login.php");
    exit();
}
include "../inc/inc_koneksi.php";
include "../inc/inc_fungsi.php";

// Dapatkan nama file saat ini untuk menentukan menu yang aktif
$page_name = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
</head>

<body class="container">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Admin Hotel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav">
                        <a class="nav-link <?php echo ($page_name == 'index.php') ? 'active fw-bold text-primary' : ''; ?>" href="index.php">Dashboard</a>
                        <a class="nav-link <?php echo ($page_name == 'kamar.php' || $page_name == 'kamar_input.php') ? 'active fw-bold text-primary' : ''; ?>" href="kamar.php">Kamar</a>
                        <a class="nav-link <?php echo ($page_name == 'booking.php' || $page_name == 'booking_edit.php') ? 'active fw-bold text-primary' : ''; ?>" href="booking.php">Pemesanan</a>
                        <a class="nav-link <?php echo ($page_name == 'pembayaran.php') ? 'active fw-bold text-primary' : ''; ?>" href="pembayaran.php">Pembayaran</a>
                        <a class="nav-link <?php echo ($page_name == 'promo.php' || $page_name == 'promo_input.php') ? 'active fw-bold text-primary' : ''; ?>" href="promo.php">Promo</a>
                        <a class="nav-link <?php echo ($page_name == 'user.php') ? 'active fw-bold text-primary' : ''; ?>" href="user.php">Tamu</a>
                        <a class="nav-link <?php echo ($page_name == 'review.php') ? 'active fw-bold text-primary' : ''; ?>" href="review.php">Ulasan</a>
                        <a class="nav-link <?php echo ($page_name == 'halaman.php' || $page_name == 'halaman_input.php') ? 'active fw-bold text-primary' : ''; ?>" href="halaman.php">Halaman</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main></main>