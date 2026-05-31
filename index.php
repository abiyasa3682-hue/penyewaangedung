<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sewa Gedung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="site-header">
            <div class="logo">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 21V10l9-6 9 6v11H3z" stroke="#fff" stroke-width="1.2" stroke-linejoin="round"/></svg>
                <h1>Sewa Gedung</h1>
            </div>
            <nav class="nav">
                <a href="#">Beranda</a>
                <a href="#gedung">Gedung</a>
                <a href="#kontak">Kontak</a>
                <a class="btn" href="#booking">Booking Sekarang</a>
            </nav>
        </header>

        <section class="hero">
            <div class="panel">
                <h2>Sewa Gedung Untuk Setiap Momen Spesial Anda</h2>
                <p class="lead">Kami menyediakan gedung berkualitas dengan fasilitas lengkap untuk berbagai acara, mulai dari seminar, pernikahan, hingga konferensi perusahaan.</p>
                <div class="actions">
                    <a class="btn" href="#booking">Booking Sekarang</a>
                    <a class="btn" href="#gedung" style="background:#333;">Lihat Selengkapnya</a>
                </div>
                <div class="search-bar" style="margin-top:18px;">
                    <select name="tipe">
                        <option>Pilih Tipe Acara</option>
                        <option>Seminar</option>
                        <option>Pernikahan</option>
                        <option>Pesta</option>
                    </select>
                    <select name="kapasitas">
                        <option>Pilih Kapasitas</option>
                        <option>50 Orang</option>
                        <option>100 Orang</option>
                        <option>200 Orang</option>
                    </select>
                    <input type="date" name="tanggal">
                    <a class="btn search-btn" href="#gedung">Cari Gedung</a>
                </div>
            </div>
            <div class="panel" style="flex:0 0 360px;">
                <h3>Kenapa Memilih Kami</h3>
                <ul style="line-height:1.8;">
                    <li>Lokasi Strategis</li>
                    <li>Fasilitas Lengkap</li>
                    <li>Layanan Profesional</li>
                </ul>
            </div>
        </section>

        <section id="gedung" class="featured">
            <h2 style="margin-top:22px; text-align:center;">Gedung Unggulan Kami</h2>
            <div class="cards">
                <?php
                $sql = "SELECT * FROM gedung";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $img = "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=60";
                ?>
                <div class="card">
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($row['nama_gedung']) ?>">
                    <h3><?= htmlspecialchars($row['nama_gedung']) ?></h3>
                    <div class="meta"><?= htmlspecialchars($row['kapasitas']) ?> orang</div>
                    <div class="price">Rp <?= number_format($row['harga_sewa_per_jam'],0,',','.') ?></div>
                    <div style="margin-top:10px;"><a class="btn" href="proses_sewa.php?id=<?= $row['id_gedung'] ?>">Booking</a></div>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>
</body>
</html>
