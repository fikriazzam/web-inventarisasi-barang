<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga_satuan = $_POST['harga_satuan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

    $sql = "INSERT INTO barang (nama_barang, kategori, stok, harga_satuan, tanggal_masuk, tanggal_kadaluarsa) 
            VALUES ('$nama_barang', '$kategori', '$stok', '$harga_satuan', '$tanggal_masuk', '$tanggal_kadaluarsa')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Barang berhasil ditambahkan!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tambah Barang</title>
</head>
<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <option value="Pupuk">Pupuk</option>
                    <option value="Obat Pertanian">Obat Pertanian</option>
                    <option value="Alat Pertanian">Alat Pertanian</option>
                </select>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" required>
            </div>
            <div class="form-group">
                <label for="harga_satuan">harga:</label>
                <input type="text" id="harga_satuan" name="harga_satuan" required>
            </div>
            <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk:</label>
                <input type="date" id="tanggal_masuk" name="tanggal_masuk" required>
            </div>
            <div class="form-group">
                <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa:</label>
                <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required>
            </div>
            <input type="submit" value="Tambah Barang" class="submit-button">
        </form>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>
