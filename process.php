<?php
include "koneksi.php";

// Ambil saldo terakhir dari database
$query_saldo = mysqli_query($koneksi, "SELECT saldo FROM transaksi ORDER BY tanggal DESC LIMIT 1");
$saldo = mysqli_fetch_assoc($query_saldo);

// Ambil data dari form
$tanggal = date('Y-m-d H:i:s');
$keterangan = $_POST['keterangan'];
$debit = isset($_POST['debit']) ? intval($_POST['debit']) : 0;
$kredit = isset($_POST['kredit']) ? intval($_POST['kredit']) : 0;
$saldo_akhir = $saldo['saldo'] + $debit - $kredit;

// Cek apakah file struk diunggah
if (isset($_FILES['struk']) && $_FILES['struk']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['struk']['name'];
    $file_tmp = $_FILES['struk']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Tentukan folder penyimpanan berdasarkan transaksi (pemasukan/pengeluaran)
    if ($debit > 0) {
        $upload_dir = 'uploads/pemasukan/';
    } elseif ($kredit > 0) {
        $upload_dir = 'uploads/pengeluaran/';
    } else {
        $upload_dir = 'upload/'; // Default folder jika tidak ada debit atau kredit
    }

    // Tentukan path lengkap untuk penyimpanan file
    $file_path = $upload_dir . basename($file_name);

    // Validasi tipe file (hanya JPG, PNG, PDF yang diperbolehkan)
    $allowed_ext = array('jpg', 'jpeg', 'png', 'pdf');
    if (in_array($file_ext, $allowed_ext)) {
        // Upload file ke folder yang sesuai
        if (move_uploaded_file($file_tmp, $file_path)) {
            // File berhasil diupload
            echo "File berhasil diupload ke " . $file_path;
        } else {
            // Gagal mengupload file
            echo "Gagal mengupload file.";
        }
    } else {
        // Format file tidak valid
        echo "Format file tidak diperbolehkan.";
    }
} else {
    // Jika tidak ada file yang diupload
    $file_path = ''; // Kosongkan path file
}

// Insert data transaksi ke database
$query = mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, keterangan, debit, kredit, saldo, struk) VALUES
('$tanggal', '$keterangan', '$debit', '$kredit', '$saldo_akhir', '$file_path')");

if ($query) {
    echo "<script>
    alert('Transaksi berhasil ditambahkan!!!');
    document.location = 'dashboard.php';
    </script>";
} else {
    echo "Gagal menambahkan transaksi.";
}
?>