<?php
// Memanggil navigasi dari folder includes
include '../includes/navbar.php';
?>

<div class="main-content">
    <h2 class="rooms-title">Pilihan Kamar Balwil Grand Hotel</h2>
    <p class="rooms-subtitle">Setiap kamar dirancang khusus untuk memberikan kenyamanan maksimal dan ketenangan selama Anda menginap.</p>

    <div class="rooms-container">

        <div class="room-card">
            <div class="room-image">
                <img src="../assets/superior.jpg" alt="Standard Room">
            </div>
            <div class="room-details">
                <span class="room-tag">Paling Populer</span>
                <h3>Standard Room</h3>
                <p class="room-desc">Kamar minimalis modern yang nyaman, sangat cocok untuk perjalanan atau liburan singkat Anda.</p>
                <ul class="room-features">
                    <li>📐 22 m²</li>
                    <li>👥 2 Dewasa</li>
                    <li>🛏️ Queen Bed</li>
                    <li>🚿 Shower Kamar Mandi</li>
                </ul>
                <div class="room-price-action">
                    <span class="room-price">Rp 550.000<small>/ malam</small></span>
                    <a href="booking.php" class="btn-book-room">Pesan Kamar</a>
                </div>
            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="../assets/deluxe.jpg" alt="Superior Room">
            </div>
            <div class="room-details">
                <span class="room-tag">Pilihan Terbaik</span>
                <h3>Superior Room</h3>
                <p class="room-desc">Nikmati ruang yang lebih luas dengan pemandangan laut langsung dari jendela kamar Anda.</p>
                <ul class="room-features">
                    <li>📐 32 m²</li>
                    <li>👥 2 Dewasa</li>
                    <li>🛏️ King Bed</li>
                    <li>🚿 Shower & Balkon</li>
                </ul>
                <div class="room-price-action">
                    <span class="room-price">Rp 850.000<small>/ malam</small></span>
                    <a href="booking.php" class="btn-book-room">Pesan Kamar</a>
                </div>
            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="../assets/kamarbaru.jpg" alt="Deluxe Room">
            </div>
            <div class="room-details">
                <span class="room-tag">Kemewahan Terjangkau</span>
                <h3>Deluxe Room</h3>
                <p class="room-desc">Kamar luas dengan interior premium dan fasilitas lengkap, menjamin istirahat malam Anda sangat berkesan.</p>
                <ul class="room-features">
                    <li>📐 42 m²</li>
                    <li>👥 2 Dewasa</li>
                    <li>🛏️ King Bed</li>
                    <li>🚿 Shower & Living room</li>
                </ul>
                <div class="room-price-action">
                    <span class="room-price">Rp 1.250.000<small>/ malam</small></span>
                    <a href="booking.php" class="btn-book-room">Pesan Kamar</a>
                </div>
            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="../assets/suite.jpg" alt="Suite Room">
            </div>
            <div class="room-details">
                <span class="room-tag">Kemewahan Mutlak</span>
                <h3>Suite Room</h3>
                <p class="room-desc">Kamar kasta tertinggi dengan ruang tamu terpisah, bathtub mewah, dan akses pemandangan laut privat.</p>
                <ul class="room-features">
                    <li>📐 55 m²</li>
                    <li>👥 2 Dewasa, 1 Anak</li>
                    <li>🛏️ Super King Bed</li>
                    <li>🛁 Bathtub & Private Lounge</li>
                </ul>
                <div class="room-price-action">
                    <span class="room-price">Rp 1.650.000<small>/ malam</small></span>
                    <a href="booking.php" class="btn-book-room">Pesan Kamar</a>
                </div>
            </div>
        </div>

        <div class="room-card">
            <div class="room-image">
                <img src="../assets/presidential.jpg" alt="Presidential Room">
            </div>
            <div class="room-details">
                <span class="room-tag">Eksklusif Sultan</span>
                <h3>Presidential Room</h3>
                <p class="room-desc">Kamar termewah berukuran masif dengan panorama laut lepas 180 derajat langsung dari ranjang tidur Anda.</p>
                <ul class="room-features">
                    <li>📐 85 m²</li>
                    <li>👥 4 Dewasa</li>
                    <li>🛏️ 2 Super King Bed</li>
                    <li>🛁 Jacuzzi & Private Pool Access</li>
                </ul>
                <div class="room-price-action">
                    <span class="room-price">Rp 2.500.000<small>/ malam</small></span>
                    <a href="booking.php" class="btn-book-room">Pesan Kamar</a>
                </div>
            </div>
        </div>

    </div> </div>

<?php
// Memanggil footer dari folder includes
include '../includes/footer.php';
?>