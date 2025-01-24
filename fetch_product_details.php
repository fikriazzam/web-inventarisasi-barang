<?php
include 'db.php';

if (isset($_GET['id'])) {
    $nama_barang = $_GET['id'];

    // Ambil detail barang berdasarkan nama_barang
    $sql = "SELECT kategori, harga_satuan FROM barang WHERE nama_barang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_barang);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row); // Mengembalikan data dalam format JSON
    } else {
        echo json_encode(['kategori' => '', 'harga_satuan' => 0]);
    }

    $stmt->close();
}
?>