
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pencatatan Data Penjualan</title>
</head>
<body>
    <h2>Sistem Pencatatan Data Penjualan</h2>
    
    <form method="POST" action="">
        <label for="nama">Nama Produk:</label>
        <input type="text" id="nama" name="nama_produk" required><br><br>

        <label for="harga">Harga per Produk:</label>
        <input type="number" id="harga" name="harga_produk" required><br><br>

        <label for="jumlah">Jumlah Terjual:</label>
        <input type="number" id="jumlah" name="jumlah_terjual" required><br><br>

        <input type="submit" value="Tambahkan Penjualan">
    </form>

    <?php
    // Mulai sesi untuk menyimpan data penjualan
    session_start();

    // Array untuk menyimpan transaksi penjualan
    if (!isset($_SESSION['penjualan'])) {
        $_SESSION['penjualan'] = [];
    }

    // Cek jika form di-submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_produk = $_POST['nama_produk'];
        $harga_produk = (int)$_POST['harga_produk'];
        $jumlah_terjual = (int)$_POST['jumlah_terjual'];

        // Simpan transaksi dalam array asosiatif
        $transaksi = [
            'nama_produk' => $nama_produk,
            'harga_produk' => $harga_produk,
            'jumlah_terjual' => $jumlah_terjual
        ];

        // Tambahkan transaksi ke dalam array penjualan
        $_SESSION['penjualan'][] = $transaksi;
    }

    // Fungsi untuk menghitung total penjualan
    function hitungTotalPenjualan($penjualan) {
        $total = 0;
        foreach ($penjualan as $transaksi) {
            $total += $transaksi['harga_produk'] * $transaksi['jumlah_terjual'];
        }
        return $total;
    }

    // Fungsi untuk menghitung total jumlah terjual
    function hitungTotalJumlahTerjual($penjualan) {
        $total_jumlah = 0;
        foreach ($penjualan as $transaksi) {
            $total_jumlah += $transaksi['jumlah_terjual'];
        }
        return $total_jumlah;
    }

    // Tampilkan laporan penjualan jika ada data
    if (!empty($_SESSION['penjualan'])) {
        echo "<h3>Laporan Penjualan:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nama Produk</th><th>Harga per Produk</th><th>Jumlah Terjual</th><th>Total Harga</th></tr>";

        foreach ($_SESSION['penjualan'] as $transaksi) {
            echo "<tr>";
            echo "<td>" . $transaksi['nama_produk'] . "</td>";
            echo "<td>" . $transaksi['harga_produk'] . "</td>";
            echo "<td>" . $transaksi['jumlah_terjual'] . "</td>";
            echo "<td>" . ($transaksi['harga_produk'] * $transaksi['jumlah_terjual']) . "</td>";
            echo "</tr>";
        }

        $total_penjualan = hitungTotalPenjualan($_SESSION['penjualan']);
        $total_jumlah_terjual = hitungTotalJumlahTerjual($_SESSION['penjualan']);

        // Tampilkan total jumlah terjual dan total penjualan
        echo "<tr><td colspan='2'>Total Jumlah Terjual</td><td>" . $total_jumlah_terjual . "</td><td></td></tr>";
        echo "<tr><td colspan='3'>Total Penjualan (Rp)</td><td>" . $total_penjualan . "</td></tr>";
        echo "</table>";
    }
    ?>
</body>
</html>
