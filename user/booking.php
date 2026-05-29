<?php
include '../includes/navbar.php';
?>

<div class="main-content">
    <div class="booking-container">
        <h2>Formulir Pemesanan Kamar</h2>
        <p class="booking-subtitle">Silakan isi data diri dan pilih tipe kamar yang Anda inginkan.</p>
        
        <form action="pembayaran.php" method="GET" class="booking-form">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" placeholder="Masukkan nama sesuai KTP" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" placeholder="contoh@email.com" required>
                </div>
                <div class="form-group">
                    <label for="nohp">Nomor Telepon / WA</label>
                    <input type="tel" id="nohp" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            <div class="form-group">
                <label for="tipe_kamar">Pilih Tipe Kamar</label>
                <select id="tipe_kamar" required>
                    <option value="" disabled selected>-- Pilih tipe kamar yang tersedia --</option>
                    <option value="550000">Standard Room (Rp 550.000 / malam)</option>
                    <option value="850000">Superior Room (Rp 850.000 / malam)</option>
                    <option value="1250000">Deluxe Room (Rp 1.250.000 / malam)</option>
                    <option value="1650000">Suite Room (Rp 1.650.000 / malam)</option>
                    <option value="2500000">Presidential Room (Rp 2.500.000 / malam)</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="checkin">Tanggal Check-In</label>
                    <input type="date" id="checkin" required>
                </div>
                <div class="form-group">
                    <label for="checkout">Tanggal Check-Out</label>
                    <input type="date" id="checkout" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-konfirmasi">Lanjut ke Pembayaran</button>
            </div>
        </form>
    </div>
</div>

<?php
include '../includes/footer.php';
?>