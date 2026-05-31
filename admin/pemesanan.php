<?php include '../config/database.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Data Pemesanan</title>
</head>
<body>
    <h2>Data Pemesanan</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Gedung</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Total</th>
            <th>Status Bayar</th>
        </tr>
        <?php
        $sql = "SELECT p.*, pl.nama as pelanggan, g.nama_gedung, 
                       pb.status_pembayaran 
                FROM pemesanan p
                JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                JOIN gedung g ON p.id_gedung = g.id_gedung
                LEFT JOIN pembayaran pb ON p.id_pemesanan = pb.id_pemesanan";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id_pemesanan']}</td>
                <td>{$row['pelanggan']}</td>
                <td>{$row['nama_gedung']}</td>
                <td>{$row['tanggal_mulai']}</td>
                <td>{$row['tanggal_selesai']}</td>
                <td>Rp ".number_format($row['total_biaya'],0,',','.')."</td>
                <td>".($row['status_pembayaran'] ?? 'Belum bayar')."</td>
            </tr>";
        }
        ?>
    </table>
    <a href="pembayaran.php">Kelola Pembayaran</a>
</body>
</html>