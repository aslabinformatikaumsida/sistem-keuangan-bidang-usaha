<?php
include "koneksi.php";

// Ambil id dari parameter URL
$id = $_GET['id'];

// Ambil data transaksi berdasarkan id
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Cek jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); document.location='dashboard.php';</script>";
    exit;
}

// Ambil nilai debit, kredit, saldo, dan tanggal sebelumnya
$old_debit = $data['debit'];
$old_kredit = $data['kredit'];
$old_saldo = $data['saldo'];
$old_tanggal = $data['tanggal']; // Ambil tanggal lama dari transaksi

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keterangan = $_POST['keterangan'];
    $new_tanggal = $_POST['tanggal']; // Ambil tanggal baru
    $new_debit = isset($_POST['debit']) ? intval($_POST['debit']) : 0;
    $new_kredit = isset($_POST['kredit']) ? intval($_POST['kredit']) : 0;

    // Cek apakah file struk diunggah
    $file_path = $data['struk']; // Gunakan file lama sebagai default
    if (isset($_FILES['struk']) && $_FILES['struk']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['struk']['name'];
        $file_tmp = $_FILES['struk']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Tentukan folder penyimpanan berdasarkan transaksi (pemasukan/pengeluaran)
        if ($new_debit > 0) {
            $upload_dir = 'uploads/pemasukan/';
        } elseif ($new_kredit > 0) {
            $upload_dir = 'uploads/pengeluaran/';
        } else {
            $upload_dir = 'uploads/'; // Default folder
        }

        // Tentukan path lengkap untuk penyimpanan file
        $file_path = $upload_dir . basename($file_name);

        // Validasi tipe file (hanya JPG, PNG, PDF yang diperbolehkan)
        $allowed_ext = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($file_ext, $allowed_ext)) {
            // Upload file ke folder yang sesuai
            if (move_uploaded_file($file_tmp, $file_path)) {
                $file_path = $file_path; // Perbarui path file baru
            } else {
                echo "Gagal mengupload file.";
            }
        } else {
            echo "Format file tidak diperbolehkan.";
        }
    }

    // Hitung saldo baru berdasarkan perubahan debit dan kredit
    $new_saldo = $old_saldo;

    // Update saldo jika debit diubah
    if ($new_debit != $old_debit) {
        $new_saldo += ($new_debit - $old_debit);
    }

    // Update saldo jika kredit diubah
    if ($new_kredit != $old_kredit) {
        $new_saldo -= ($new_kredit - $old_kredit);
    }

    // Update data transaksi ke database
    $query_update = mysqli_query($koneksi, "UPDATE transaksi SET 
        tanggal='$new_tanggal', 
        keterangan='$keterangan', 
        debit='$new_debit', 
        kredit='$new_kredit', 
        struk='$file_path', 
        saldo='$new_saldo' 
        WHERE id='$id'");

    if ($query_update) {
        echo "<script>alert('Data transaksi berhasil diperbarui!'); document.location='dashboard.php';</script>";
    } else {
        echo "Gagal memperbarui data transaksi.";
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
    <title>Edit</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-2" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="dashboard.php">Sistem Keuangan Bidus</a>

        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                            Transaksi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="pemasukan.php">Pemasukan</a>
                                <a class="nav-link" href="pengeluaran.php">Pengeluaran</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            User
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Autentikasi
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="index.php">Login</a>
                                        <a class="nav-link" href="register.php">Register</a>

                                    </nav>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div>
                <?php
                include 'footer.php';
                ?>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Data Transaksi</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Data Transaksi</li>
                    </ol>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                                    <input type="date" name="tanggal" class="form-control" id="tanggal" 
                                    value="<?= date('Y-m-d', strtotime($data['tanggal'])); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label"><b>Keterangan</b></label>
                                    <textarea class="form-control" name="keterangan" id="keterangan"
                                        required><?= $data['keterangan']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="debit" class="form-label"><b>Debit</b></label>
                                    <input type="number" name="debit" class="form-control" id="debit"
                                        value="<?= $data['debit']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kredit" class="form-label"><b>Kredit</b></label>
                                    <input type="number" name="kredit" class="form-control" id="kredit"
                                        value="<?= $data['kredit']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="struk" class="form-label"><b>Unggah Struk (Opsional)</b></label>
                                    <input type="file" name="struk" class="form-control" id="struk">
                                    <small class="text-muted">**Format file yang diperbolehkan: JPG, PNG, PDF</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                            </form>
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