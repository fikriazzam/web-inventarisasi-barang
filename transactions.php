<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Proses penghapusan transaksi
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $deleteSql = "DELETE FROM transaction WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idToDelete);
    $stmt->execute();
    $stmt->close();
    header("Location: transactions.php"); // Redirect setelah penghapusan
    exit();
}

// Ambil data barang keluar
$barangKeluarSql = "SELECT * FROM barang_keluar";
$barangKeluarResult = $conn->query($barangKeluarSql);

// Ambil data transaksi
$sql = "SELECT id, nama_barang, kategori, jumlah, harga_satuan, tanggal_transaksi FROM transaction";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Daftar Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-button {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
        .delete-button:hover {
            text-decoration: underline;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            width: 150px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <table>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Tanggal Transaksi</th>
                <th>Aksi</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["nama_barang"] . "</td>
                            <td>" . $row["kategori"] . "</td>
                            <td>" . $row["jumlah"] . "</td>
                            <td>" . number_format($row["harga_satuan"], 2, ',', '.') . "</td>
                            <td>" . date('d-m-Y', strtotime($row["tanggal_transaksi"])) . "</td>
                            <td>
                                <a href='?delete=" . $row["id"] . "' class='delete-button' onclick=\"return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');\">Hapus</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada transaksi yang ditemukan.</td></tr>";
            }
            ?>
        </table>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>