<?php
// Memanggil navigasi dari folder includes
include '../includes/navbar.php';

// Simulasi mengambil data langsung dari tabel database review yang kita buat tadi
// (Nantinya bagian ini akan ditarik menggunakan query SELECT dari MySQL)
$data_review = [
    [
        'nama' => 'Ahmad Fauzi', // Simulasi join tabel untuk ambil nama tamu
        'tipe_kamar' => 'Standard Room',
        'rating' => 5,
        'komentar' => 'Kamarnya bersih, pelayanan ramah, fasilitasnya oke banget.',
        'tanggal' => '04 Juni 2026'
    ],
    [
        'nama' => 'Azrel',
        'tipe_kamar' => 'Deluxe Room',
        'rating' => 5,
        'komentar' => 'Sangat puas menginap di tipe deluxe, dapet kamar yang view-nya bagus.',
        'tanggal' => '07 Juni 2026'
    ]
];
?>

<div class="main-content">
    <h2 class="review-title">Ulasan & Testimoni Tamu</h2>
    <p class="review-subtitle">Apa kata mereka yang telah merasakan pengalaman menginap mewah di Balwil Grand Hotel?</p>

    <div class="reviews-grid">
        
        <?php foreach ($data_review as $rev) : ?>
            <div class="review-card">
                <div class="review-header">
                    <div class="user-info">
                        <h3><?php echo $rev['nama']; ?></h3>
                        <span class="stayed-room">🛋️ Menginap di <?php echo $rev['tipe_kamar']; ?></span>
                    </div>
                    <span class="review-date"><?php echo $rev['tanggal']; ?></span>
                </div>

                <div class="review-stars">
                    <?php 
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rev['rating']) {
                            echo '<span class="star filled">★</span>'; // Bintang emas kuning
                        } else {
                            echo '<span class="star">★</span>'; // Bintang abu-abu kosong
                        }
                    }
                    ?>
                </div>

                <p class="review-text">"<?php echo $rev['komentar']; ?>"</p>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="add-review-section">
        <h3>Sudah Selesai Menginap?</h3>
        <p>Bagikan pengalaman berharga Anda selama berada di hotel kami.</p>
        <button class="btn-tulis-review" onclick="alert('Fitur form input ulasan sukses dipicu!')">Tulis Ulasan Anda</button>
    </div>
</div>

<?php
// Memanggil footer dari folder includes
include '../includes/footer.php';
?>