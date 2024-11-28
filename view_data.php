<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data dari database berdasarkan ID
$query = "SELECT * FROM transaksi WHERE id = $id";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Data tidak ditemukan!'); window.location = 'dashboard.php';</script>";
    exit;
}
// Fungsi untuk format rupiah
function rupiah($angka){
    $hasil_rupiah = "Rp ".number_format($angka, 2, ',','.');
    return $hasil_rupiah;
}
// Format tanggal
$tanggal = date('d/m/Y', strtotime($data['tanggal']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lihat Data</title>
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
                                        <a class="nav-link" href="login.php">Login</a>
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
                    <h1 class="mt-4">Rincian Transaksi</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Kembali ke Dashboard</a></li>
                        <li class="breadcrumb-item active">Rincan Transaksi</li>
                    </ol>
                    <div class="card mb-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Tanggal: <?= $tanggal ?></h5>
                            <p class="card-text"><strong>Keterangan:</strong> <?= $data['keterangan'] ?></p>
                            <p class="card-text"><strong>Pemasukan (Debit):</strong>
                                <?= ($data['debit'] == 0) ? "Rp -" : rupiah($data['debit']) ?>
                            </p>
                            <p class="card-text"><strong>Pengeluaran (Kredit):</strong>
                                <?= ($data['kredit'] == 0) ? "Rp -" : rupiah($data['kredit']) ?>
                            </p>
                            <p class="card-text"><strong>Saldo:</strong> <?= rupiah($data['saldo']) ?></p>

                            <!-- Tampilkan struk jika ada -->
                            <?php if (!empty($data['struk'])): ?>
                            <p class="card-text"><strong>Struk:</strong></p>

                            <?php
            // Dapatkan ekstensi file
            $file_path = $data['struk'];
            $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            // Jika file adalah gambar, tampilkan sebagai gambar
            if (in_array($ext, ['jpg', 'jpeg', 'png'])): ?>
                            <img src="<?= $file_path ?>" alt="Struk" class="img-fluid img-thumbnail"
                                style="max-width: 200px;">
                            <?php
            // Jika file adalah PDF, tampilkan sebagai tautan
            elseif ($ext == 'pdf'): ?>
                            <a href="<?= $file_path ?>" target="_blank">Lihat Struk (PDF)</a>
                            <?php else: ?>
                            <p class="text-danger">Format file tidak dikenali.</p>
                            <?php endif; ?>

                            <?php else: ?>
                            <p class="card-text text-danger"><strong>Struk:</strong> Tidak ada struk yang diunggah.</p>
                            <?php endif; ?>


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