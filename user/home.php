<?php 
// 1. Set nama halaman aktif agar menu 'Beranda' di navbar menyala
$current_page = 'home'; 

// 2. Panggil navbar dari folder includes
include('../includes/navbar.php'); 
?>



<section class="hero-banner">
    <h1 style="color: #ffffff;">Selamat Datang di Balwil Grand Hotel</h1>
    <p style="margin-top: 10px; color: #ffffff; font-size: 18px;">Nikmati Pengalaman Menginap dengan Pemandangan Laut Terbaik</p>
    <br>
    <a href="booking.php" style="display: inline-block; background-color: #ffffff; color: #1ea2ca; padding: 12px 24px; text-decoration: none; font-weight: bold; border-radius: 25px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        Pesan Kamar Sekarang
    </a>
</section>

<?php 
// 3. Panggil footer
include('../includes/footer.php'); 
?>


<div class="foto-pembatas-container">
    <img src="../assets/kolam.jpg" alt="Kolam Renang">
    <img src="../assets/spa.jpg" alt="Restoran Mewah">
    <img src="../assets/makan.jpg" alt="Makan">
</div>

<div class="main-content">
    <h2>A best place to enjoy your life</h2>
    <p style="text-align: center; margin-bottom: 40px; color: #c7a668;">Balwil Grand Hotel menawarkan pelayanan berkualitas</p>

    <div class="fasilitas-container" style="display: flex; justify-content: space-between; gap: 20px;">
             <div class="card-fasilitas" style="flex: 1; background-color: #0b132b; padding: 25px; border-radius: 8px; color: white;">
            <h3 style="color: #c7a668; margin-bottom: 10px;">🏊 Kolam Renang</h3>
            <p style="font-size: 14px; opacity: 0.9;">Kolam renang yang menghadap langsung ke lautan yang sangat indah.</p>
        </div>
        <div class="card-fasilitas" style="flex: 1; background-color: #0b132b; padding: 25px; border-radius: 8px; color: white;">
            <h3 style="color: #c7a668; margin-bottom: 10px;">🍽️ Menu Restoran </h3>
            <p style="font-size: 14px; opacity: 0.9;">Hidangan yang dimasak langsung oleh koki internasional terbaik.</p>
        </div>
        <div class="card-fasilitas" style="flex: 1; background-color: #0b132b; padding: 25px; border-radius: 8px; color: white;">
            <h3 style="color: #c7a668; margin-bottom: 10px;"> ⭐ Fasilitas Terbaik</h3>
            <p style="font-size: 14px; opacity: 0.9;">Memiliki banyak fasilitas seperti spa & massage, gym & yoga, surfing lessons, dll .</p>
        </div>
    </div>
</div>