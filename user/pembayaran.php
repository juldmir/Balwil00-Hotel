<?php
// Memanggil navigasi dari folder includes
include '../includes/navbar.php';

// Simulasi Total Harga dari halaman booking sebelumnya (Contoh: Rp 750.000)
$total_awal = 850000; 
?>

<div class="main-content">
    <div class="main-content halaman-pembayaran">
    <div class="payment-container">
        <h2>Selesaikan Pembayaran Anda</h2>
        <p class="payment-subtitle">Silakan periksa detail pesanan, gunakan kode promo jika ada, dan pilih metode pembayaran.</p>

        <div class="invoice-box">
            <div class="invoice-row">
                <span>Tipe Kamar Selected:</span>
                <strong>Superior Room (1 Malam)</strong>
            </div>
            <div class="invoice-row">
                <span>Harga Kamar:</span>
                <span>Rp <?php echo number_format($total_awal, 0, ',', '.'); ?></span>
            </div>
            <div class="invoice-row discount-row" id="tampilan-diskon" style="display: none; color: #e63946;">
                <span>Potongan Promo (<span id="persen-diskon">0</span>%):</span>
                <span>- Rp <span id="nominal-diskon">0</span></span>
            </div>
            <hr>
            <div class="invoice-row total-row">
                <span>Total yang Harus Dibayar:</span>
                <span id="total-akhir" style="color: #0b132b; font-size: 20px; font-weight: 700;">Rp <?php echo number_format($total_awal, 0, ',', '.'); ?></span>
            </div>
        </div>

        <form action="proses_pembayaran.php" method="POST" class="payment-form">
            <input type="hidden" name="id_booking" value="2"> 

            <div class="form-group">
                <label for="kode_promo">Punya Kode Promo / Voucher?</label>
                <div class="promo-input-group">
                    <input type="text" id="kode_promo" placeholder="Contoh: LIBURANHAPPY / BALWILHEMAT">
                    <button type="button" id="btn-klaim-promo">Terapkan</button>
                </div>
                <small id="promo-message" style="display:block; margin-top: 5px; font-weight: 600;"></small>
                <input type="hidden" name="promo_terpakai" id="promo_terpakai" value="">
            </div>

            <div class="form-group">
                <label>Pilih Metode Pembayaran</label>
                <div class="payment-methods">
                    <label class="method-option">
                        <input type="radio" name="metode" value="Transfer Bank" required checked>
                        <div class="method-box">
                            <span class="icon">🏦</span>
                            <span>Transfer Bank (BCA / Mandiri)</span>
                        </div>
                    </label>

                    <label class="method-option">
                        <input type="radio" name="metode" value="E-Wallet">
                        <div class="method-box">
                            <span class="icon">📱</span>
                            <span>E-Wallet (OVO, GoPay, Dana)</span>
                        </div>
                    </label>

                    <label class="method-option">
                        <input type="radio" name="metode" value="Kartu Kredit">
                        <div class="method-box">
                            <span class="icon">💳</span>
                            <span>Kartu Kredit / Debit</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-bayar-sekarang">Proses & Bayar Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('btn-klaim-promo').addEventListener('click', function() {
    var kode = document.getElementById('kode_promo').value.toUpperCase().trim();
    var message = document.getElementById('promo-message');
    var hargaAwal = <?php echo $total_awal; ?>;
    
    // Data promo simulasi dari tabel database kamu tadi
    var daftarPromo = {
        'PROMOHEMAT': 15,
        'DISKONGEDE': 30
    };

    if (daftarPromo[kode]) {
        var diskonPersen = daftarPromo[kode];
        var potongan = (diskonPersen / 180) * hargaAwal; // render manual rumus matematis persen jika dibutuhkan, atau pakai hitungan standar:
        var potongan = (diskonPersen / 100) * hargaAwal;
        var hargaAkhir = hargaAwal - potongan;

        // Tampilkan kalkulasi diskon di invoice box
        document.getElementById('tampilan-diskon').style.display = 'flex';
        document.getElementById('persen-diskon').innerText = diskonPersen;
        document.getElementById('nominal-diskon').innerText = potongan.toLocaleString('id-ID');
        document.getElementById('total-akhir').innerText = 'Rp ' + hargaAkhir.toLocaleString('id-ID');
        document.getElementById('promo_terpakai').value = kode;

        message.style.color = '#2a9d8f';
        message.innerText = '🎉 Selamat! Kode promo ' + kode + ' berhasil dipasang (Diskon ' + diskonPersen + '%).';
    } else {
        message.style.color = '#e63946';
        message.innerText = '❌ Maaf, kode promo tidak valid atau sudah kedaluwarsa.';
    }
});
</script>

<?php
// Memanggil footer dari folder includes
include '../includes/footer.php';
?>