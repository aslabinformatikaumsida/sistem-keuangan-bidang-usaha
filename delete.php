<?php
include 'koneksi.php';

// Ambil ID dari query string
$id = $_GET['id'];

// Hapus transaksi berdasarkan ID
$sql = "DELETE FROM transaksi WHERE id='$id'";
if (mysqli_query($koneksi, $sql)) {
    // Setelah menghapus, hitung saldo terbaru
    // Ambil semua transaksi yang tersisa
    $sql = "SELECT * FROM transaksi ORDER BY tanggal DESC";
    $hasil = mysqli_query($koneksi, $sql);
    
    $last_saldo = 0;
    while ($row = mysqli_fetch_assoc($hasil)) {
        $last_saldo = $row['saldo'];
    }
    
    // Perbarui saldo untuk setiap transaksi yang tersisa
    $sql = "UPDATE transaksi SET saldo='$last_saldo' WHERE id='$id'";
    mysqli_query($koneksi, $sql);
    
    // Redirect ke halaman utama setelah penghapusan
    header('Location: dashboard.php');
} else {
    echo "Error deleting record: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>