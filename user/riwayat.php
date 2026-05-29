<?php
// Memanggil navigasi dari folder includes
include '../includes/navbar.php';

/* Simulasi data gabungan (JOIN) antara tabel 'booking' dan 'pembayaran' 
  Nantinya di database benerannya kamu tinggal pakai query:
  SELECT booking.*, pembayaran.status_bayar, pembayaran.metode FROM booking 
  LEFT JOIN pembayaran ON booking.id_booking = pembayaran.id_booking
*/
$data_riwayat = [
    [
        'id_booking' => '#BKG-001',
        'tipe_kamar' => 'Standard Room',
        'checkin' => '01 Juni 2026',
        'checkout' => '03 Juni 2026',
        'total' => 900000,
        'metode' => 'Transfer Bank',
        'status' => 'Lunas'
    ],
    [
        'id_booking' => '#BKG-002',
        'tipe_kamar' => 'Deluxe Room',
        'checkin' => '05 Juni 2026',
        'checkout' => '06 Juni 2026',
        'total' => 750000,
        'metode' => 'E-Wallet',
        'status' => 'Lunas'
    ],
    [
        'id_booking' => '#BKG-003',
        'tipe_kamar' => 'Superior Room',
        'checkin' => '12 Juni 2026',
        'checkout' => '15 Juni 2026',
        'total' => 2250000,
        'metode' => 'Kartu Kredit',
        'status' => 'Belum Lunas'
    ],
    [
        'id_booking' => '#BKG-005',
        'tipe_kamar' => 'Suite Room',
        'checkin' => '18 Juni 2026',
        'checkout' => '20 Juni 2026',
        'total' => 2500000,
        'metode' => 'Transfer Bank',
        'status' => 'Lunas'
    ]
];
?>

<div class="main-content">
    <h2 class="history-title">Riwayat Pemesanan Kamar</h2>
    <p class="history-subtitle">Pantau seluruh status reservasi dan riwayat menginap Anda di Balwil Grand Hotel.</p>

    <div class="history-container">
        <div class="table-responsive">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>ID Booking</th>
                        <th>Tipe Kamar</th>
                        <th>Tanggal Menginap</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_riwayat as $row) : ?>
                        <tr>
                            <td><strong><?php echo $row['id_booking']; ?></strong></td>
                            <td><?php echo $row['tipe_kamar']; ?></td>
                            <td>
                                <span class="date-text">📅 <?php echo $row['checkin']; ?></span>
                                <small class="date-sep">s/d</small>
                                <span class="date-text"><?php echo $row['checkout']; ?></span>
                            </td>
                            <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['metode']; ?></td>
                            <td>
                                <?php if ($row['status'] == 'Lunas') : ?>
                                    <span class="badge badge-lunas">Lunas</span>
                                <?php else : ?>
                                    <span class="badge badge-belum">Belum Lunas</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Memanggil footer dari folder includes
include '../includes/footer.php';
?>