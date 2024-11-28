<?php
include 'koneksi.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password sebelum menyimpannya ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan user baru ke database
    $query = "INSERT INTO login (email, password) VALUES ('$email', '$hashed_password')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Registrasi berhasil!');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>