<!-- footer.php -->
<?php 
include 'koneksi.php'
?>

<div class="sb-sidenav-footer">
    <div class="small">Login Sebagai:</div>
    <?php
    // Tampilkan email jika sudah login
    if (isset($_SESSION['email'])) {
        echo htmlspecialchars($_SESSION['email']);
    } else {
        echo "Belum login";
    }
    ?>
</div>