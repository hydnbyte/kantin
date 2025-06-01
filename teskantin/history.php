<?php
$mysqli = new mysqli("localhost", "root", "", "kantin");
$result = $mysqli->query("SELECT * FROM history ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Riwayat Pembelian</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px; border: 1px solid #ccc; }
    th { background-color: #eee; }
  </style>
</head>
<body>
  <h1>Riwayat Pembelian</h1>
  <table>
    <tr>
      <th>Waktu</th>
      <th>Nama Barang</th>
      <th>Harga</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['waktu'] ?></td>
      <td><?= htmlspecialchars($row['nama_barang']) ?></td>
      <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
