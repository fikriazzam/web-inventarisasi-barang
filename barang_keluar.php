<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Ambil daftar barang dari database
$barang_sql = "SELECT  id, nama_barang FROM barang"; // Ambil dari tabel barang
$barang_result = $conn->query($barang_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $harga_satuan = $_POST['harga_satuan'];

    // Simpan ke tabel barang_keluar
    $sql_barang_keluar = "INSERT INTO barang_keluar (nama_barang, kategori, jumlah, tanggal_keluar, harga_satuan) 
                          VALUES (?, ?, ?, ?, ?)";
    
    $stmt_barang_keluar = $conn->prepare($sql_barang_keluar);
    $stmt_barang_keluar->bind_param("ssids", $nama_barang, $kategori, $jumlah, $tanggal_keluar, $harga_satuan);
    
    if ($stmt_barang_keluar->execute()) {
        // Simpan ke tabel transaction
        $sql_transaction = "INSERT INTO transaction (nama_barang, kategori, jumlah, tanggal_transaksi, harga_satuan) 
                            VALUES (?, ?, ?, ?, ?)";
        
        $stmt_transaction = $conn->prepare($sql_transaction);
        $stmt_transaction->bind_param("ssids", $nama_barang, $kategori, $jumlah, $tanggal_keluar, $harga_satuan);
        
        if ($stmt_transaction->execute()) {
            $message = "Barang keluar berhasil dicatat dan disimpan di transaksi!";
        } else {
            $message = "Barang keluar berhasil dicatat, tetapi gagal menyimpan di transaksi: " . $stmt_transaction->error;
        }
        $stmt_transaction->close();
    } else {
        $message = "Error saat mencatat barang keluar: " . $stmt_barang_keluar->error;
    }
    $stmt_barang_keluar->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .submit-button:hover {
            background-color: #45a049;
        }
        .message {
            margin: 15px 0;
            padding: 10px;
            background-color: #e7f3fe;
            color: #31708f;
            border: 1px solid #bce8f1;
            border-radius: 5px;
        }
        .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function fetchProductDetails(productId) {
            if (productId) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "fetch_product_details.php?id=" + productId, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById("kategori").value = response.kategori;
                        document.getElementById("harga_satuan").value = response.harga_satuan;
                    }
                };
                xhr.send();
            } else {
                document.getElementById("kategori").value = "";
                document.getElementById("harga_satuan" + index).value = "";
            }
        }

        function calculateTotal() {
            var hargaSatuan = parseFloat(document.getElementById("harga_satuan").value) || 0;
            var jumlah = parseInt(document.getElementById("jumlah_0").value) || 0;
            var totalHarga = hargaSatuan * jumlah;
            document.getElementById("total_harga").innerText = "Total Harga: " + totalHarga.toFixed(2);
        }
 
    </script>
</head>
<body>

<div class="container">
    <h2>Form Barang Keluar</h2>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <select id="nama_barang" name="nama_barang"  required onchange="fetchProductDetails(this.value)">
                <?php while ($row = $barang_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['nama_barang']; ?>"><?php echo $row['nama_barang']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" required>
        </div>

        <div class="form-group">
            <label for="harga_satuan">Harga Satuan</label>
            <input type="number" name="harga_satuan" id="harga_satuan" required step="0.01" min="0">
        </div>

        <div class="form-group">
            <label for="tanggal_keluar">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" required value="<?php echo isset($tanggal_keluar) ? $tanggal_keluar : ''; ?>">
        </div>

        <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" required>
            </div>
        </div>
        <button type="submit" class="submit-button">Simpan</button>
    </form>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
</div>

</body>
</html>