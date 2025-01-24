<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .card {
            background: #45a049;
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            flex: 1 1 200px;
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .card p {
            margin: 0 0 15px;
        }
        .button {
            background: #fff;
            color: #45a049;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .button:hover {
            background: #e7e7e7;
        }
        .logout-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .logout-button:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aplikasi Inventarisasi Barang</h1>
        <p>Selamat datang, <?php echo $_SESSION['role']; ?>!</p>

        <div class="card-container">
            <div class="card">
                <h3><i class="fas fa-plus"></i> Tambah Barang</h3>
                <p>Input barang baru ke dalam sistem.</p>
                <a href="add_item.php" class="button">Tambah Barang</a>
            </div>
            <div class="card">
                <h3><i class="fas fa-list"></i> Lihat Barang</h3>
                <p>Melihat daftar barang yang ada di sistem.</p>
                <a href="view_items.php" class="button">Lihat Barang</a>
            </div>
            <div class="card">
                <h3><i class="fas fa-arrow-right"></i> Barang Keluar</h3>
                <p>Proses transaksi jual beli.</p>
                <a href="barang_keluar.php" class="button">Barang Keluar</a>
            </div>
            <div class="card">
                <h3><i class="fas fa-history"></i> Transaksi</h3>
                <p>Melihat riwayat transaksi yang telah dilakukan.</p>
                <a href="transactions.php" class="button">Lihat Transaksi</a>
            </div>
            
        </div>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>