<?php
session_start();
include 'koneksi.php';
// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
    exit();
}

// Ambil semua transaksi dari5 yang terbaru
$sql = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$hasil = mysqli_query($koneksi, $sql);

// Ambil saldo terakhir
$query_saldo = mysqli_query($koneksi, "SELECT saldo FROM transaksi ORDER BY tanggal DESC LIMIT 1");
$saldo = mysqli_fetch_assoc($query_saldo);

// Fungsi untuk format rupiah
function rupiah($angka){
$hasil_rupiah = "Rp ".number_format($angka, 2, ',','.');
return $hasil_rupiah;
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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
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
                    <li><a class="dropdown-item" href="logout.php" onclick="return confirmLogout()">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="">
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
                            Pengguna
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
            <main style="background-color:;">
                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-3">Selamat Datang Divisi Bidang Usaha!</h1>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Saldo Saat Ini :</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <h3><?= rupiah($saldo['saldo'])?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Keluar-Masuk Keuangan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Isi Ringkas</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Total Saldo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Isi Ringkas</th>
                                        <th>Pemasukan</th>
                                        <th>Pengeluaran</th>
                                        <th>Total Saldo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($hasil)):
                        $tanggal = $row['tanggal'];
                        $tanggal_format = date('d/m/Y', strtotime($tanggal));            
                    ?>
                                <tr>
                                    <td class="text-center"><?=$no?></td>
                                    <td><?= $tanggal_format ?></td>

                                    <td><?=$row['keterangan']?></td>
                                    <td><?= ($row['debit'] == 0) ? "Rp -" : rupiah($row['debit']); ?></td>
                                    <td><?= ($row['kredit'] == 0) ? "Rp -" : rupiah($row['kredit']); ?></td>
                                    <td><?=rupiah($row['saldo'])?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['id']; ?>"
                                            class='btn btn-sm p-1 justify-content-center text-light'
                                            style='background-color: #F39C12;'><i
                                                class='bx bx-message-square-edit fs-6'></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id']; ?>"
                                            class='btn btn-sm p-1 justify-content-center text-light'
                                            style='background-color: #DD4B39;'><i class='bx bx-trash'
                                                onclick="return confirm('Yakin ingin menghapus data ini?');"></i></a>
                                        <a href="view_data.php?id=<?= $row['id']; ?>"
                                            class='btn btn-sm p-1 justify-content-center text-light'
                                            style='background-color: #2275E3;'>
                                            <i class='bx bxs-show fs-6'></i>
                                        </a>

                                    </td>
                                    <?php $no++; endwhile;?>

                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-end  small">
                        <div class="text-muted">Copyright &copy; Bidang Usaha 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>