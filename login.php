<?php 
include 'koneksi.php';
session_start();

// if (isset($_POST['email']) && isset($_POST['password'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     // Query untuk mencari user berdasarkan email
//     $query = "SELECT * FROM login WHERE email = '$email'";
//     $result = mysqli_query($koneksi, $query);

//     if (mysqli_num_rows($result) > 0) {
//         $user = mysqli_fetch_assoc($result);

//         // Cek apakah password cocok (tanpa hash)
//         if ($password === $user['password']) {
//             // Password benar, simpan informasi user di session
//             $_SESSION['id_user'] = $user['id_user'];
//             $_SESSION['email'] = $user['email'];

//             // Redirect ke halaman dashboard atau utama
//             echo "<script>alert('Login berhasil!');window.location='index.php';</script>";
//         } else {
//             // Password salah
//             echo "<script>alert('Password salah!');</script>";
//         }
//     } else {
//         // Email tidak ditemukan
//         echo "<script>alert('Email tidak ditemukan!');</script>";
//     }
// }

// menangkap data yang dikirim dari form login

$username = $_POST['email'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi, "select * from login where email='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if ($cek > 0) {

	$data = mysqli_fetch_assoc($login);

	// cek jika user login sebagai admin
	if ($data['email'] == "$username") {
		header("location: dashboard.php");
	} else{
		echo "<script>alert('password salah!');</script>";

	}
} 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">LOGIN</h3>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email"
                                                placeholder="name@example.com" name="email" required />
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Password" name="password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Login</button>

                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.php">Ga duwe akun? Daftar saiki!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>