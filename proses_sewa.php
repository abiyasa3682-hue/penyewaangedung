<?php
include 'config/database.php';
$id_gedung = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$gedung = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gedung WHERE id_gedung=$id_gedung"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST['tanggal_selesai']);

    $jam = (strtotime($tanggal_selesai) - strtotime($tanggal_mulai)) / 3600;
    $total = max(0, $jam) * $gedung['harga_sewa_per_jam'];
    
    $cek = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $pelanggan = mysqli_fetch_assoc($cek);
        $id_pelanggan = $pelanggan['id_pelanggan'];
    } else {
        mysqli_query($conn, "INSERT INTO pelanggan (nama, no_telepon, email) VALUES ('$nama', '$no_telp', '$email')");
        $id_pelanggan = mysqli_insert_id($conn);
    }

    $sql = "INSERT INTO pemesanan (id_pelanggan, id_gedung, tanggal_mulai, tanggal_selesai, total_biaya) 
            VALUES ($id_pelanggan, $id_gedung, '$tanggal_mulai', '$tanggal_selesai', $total)";
    mysqli_query($conn, $sql);
    $id_pemesanan = mysqli_insert_id($conn);
    
    echo "<script>alert('Pemesanan berhasil! ID Pemesanan: $id_pemesanan. Total: Rp ".number_format($total,0,',','.')."'); window.location='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Form Sewa Gedung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="panel" style="max-width:780px; margin:32px auto;">
            <h2>Sewa <?= htmlspecialchars($gedung['nama_gedung'] ?? 'Gedung') ?></h2>
            <p>Harga: <strong>Rp <?= number_format($gedung['harga_sewa_per_jam'] ?? 0,0,',','.') ?></strong> / jam</p>

            <form method="POST" id="sewaForm">
                <input type="hidden" name="id_gedung" value="<?= (int)$id_gedung ?>">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required placeholder="Nama lengkap">
                </div>

                <div class="form-row" style="display:flex; gap:12px;">
                    <div style="flex:1;">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" required placeholder="0812xxxx">
                    </div>
                    <div style="flex:1;">
                        <label>Email</label>
                        <input type="email" name="email" required placeholder="email@domain.com">
                    </div>
                </div>

                <div class="form-row" style="display:flex; gap:12px; margin-top:8px;">
                    <div style="flex:1;">
                        <label>Mulai</label>
                        <input id="mulai" type="datetime-local" name="tanggal_mulai" required>
                    </div>
                    <div style="flex:1;">
                        <label>Selesai</label>
                        <input id="selesai" type="datetime-local" name="tanggal_selesai" required>
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; align-items:center; gap:12px;">
                    <div>Perkiraan total: <strong id="totalDisplay">-</strong></div>
                    <div style="margin-left:auto"><button class="btn" type="submit">Pesan Sekarang</button></div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function(){
            const price = <?= (float)($gedung['harga_sewa_per_jam'] ?? 0) ?>;
            const mulai = document.getElementById('mulai');
            const selesai = document.getElementById('selesai');
            const totalDisplay = document.getElementById('totalDisplay');

            function calc(){
                if(!mulai.value || !selesai.value) { totalDisplay.textContent = '-'; return; }
                const s = new Date(selesai.value);
                const m = new Date(mulai.value);
                const diff = (s - m) / 1000 / 3600; // hours
                if(isNaN(diff) || diff <= 0){ totalDisplay.textContent = 'Pilihan waktu tidak valid'; return; }
                const total = diff * price;
                totalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(total));
            }

            mulai.addEventListener('change', calc);
            selesai.addEventListener('change', calc);
        })();
    </script>
</body>
</html>