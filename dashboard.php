<?php
    include "ExeFiles/session-check.php";
?>

<?php
    include "ExeFiles/koneksi.php";

    setlocale(LC_ALL, 'IND');

    function rupiahFormat($number) {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    $query_maxpemasukan = mysqli_query($mysqli, "SELECT MAX(`jumlah_pemasukan`) AS Max FROM `pemasukan` WHERE `id_pengguna` = '$_SESSION[id_pengguna]';");
    $max_pemasukan = mysqli_fetch_assoc($query_maxpemasukan);

    $query_maxpengeluaran = mysqli_query($mysqli, "SELECT MAX(`jumlah_pengeluaran`) AS Max FROM `pengeluaran` WHERE `id_pengguna` = '$_SESSION[id_pengguna]';");
    $max_pengeluaran = mysqli_fetch_assoc($query_maxpengeluaran);

    $query_jumlahDompet = mysqli_query($mysqli, "SELECT COUNT(`id_dompet`) AS total FROM `dompet` WHERE `id_pengguna` = '$_SESSION[id_pengguna]'");
    $jumlahDompet = mysqli_fetch_assoc($query_jumlahDompet);

    $query_jumlahTabungan = mysqli_query($mysqli, "SELECT COUNT(`id_rencana`) as total FROM `rencana` WHERE `id_pengguna` = '$_SESSION[id_pengguna]' AND `tertabung` < `target`");
    $jumlahTabungan = mysqli_fetch_assoc($query_jumlahTabungan);

    $years_query = "
        SELECT DISTINCT year FROM (
            SELECT YEAR(tanggal_pemasukan) AS year
            FROM pemasukan
            UNION
            SELECT YEAR(tanggal_pengeluaran) AS year
            FROM pengeluaran
        ) AS combined_years
        ORDER BY year;
    ";

    $years_result = $mysqli->query($years_query);

    if (isset($_GET['btn-show'])) {
        $bulan = $_GET['bulan'] ?? '';
        $tahun = $_GET['tahun'];
        
        if($bulan == '') {
            $pemasukan_query = "
                SELECT
                    MONTHNAME(tanggal_pemasukan) AS bulan,
                    COUNT(id_pemasukan) AS jumlah_transaksi,
                    SUM(jumlah_pemasukan) AS total_pemasukan
                FROM
                    pemasukan
                WHERE
                    YEAR(tanggal_pemasukan) = $tahun
                GROUP BY
                    MONTH(tanggal_pemasukan)
                ORDER BY
                    MONTH(tanggal_pemasukan);
            ";

            $totalpemasukan_query = "
            SELECT
                SUM(jumlah_pemasukan) AS totalpemasukan,
                COUNT(id_pemasukan) AS totaltransaksipemasukan
            FROM
                pemasukan
            WHERE
                YEAR(tanggal_pemasukan) = '$tahun';
            ";

            $pengeluaran_query = "
            SELECT
                MONTHNAME(tanggal_pengeluaran) AS bulan,
                COUNT(id_pengeluaran) AS jumlah_transaksi,
                SUM(jumlah_pengeluaran) AS total_pengeluaran
            FROM
                pengeluaran
            WHERE
                YEAR(tanggal_pengeluaran) = '$tahun'
            GROUP BY
                MONTH(tanggal_pengeluaran)
            ORDER BY
                MONTH(tanggal_pengeluaran);
            ";

            $pengeluaran_total_query = "
            SELECT
                SUM(jumlah_pengeluaran) AS total_pengeluaran,
                COUNT(id_pengeluaran) AS totaltransaksipengeluaran
            FROM
                pengeluaran
            WHERE
                YEAR(tanggal_pengeluaran) = '$tahun';
            ";
        } else {
            $pemasukan_query = "
                SELECT
                    MONTHNAME(tanggal_pemasukan) AS bulan,
                    COUNT(id_pemasukan) AS jumlah_transaksi,
                    SUM(jumlah_pemasukan) AS total_pemasukan
                FROM
                    pemasukan
                WHERE
                    YEAR(tanggal_pemasukan) = '$tahun' AND MONTHNAME(tanggal_pemasukan) = '$bulan'
            ";

            $totalpemasukan_query = "
            SELECT
                SUM(jumlah_pemasukan) AS totalpemasukan,
                COUNT(id_pemasukan) AS totaltransaksipemasukan
            FROM
                pemasukan
            WHERE
                YEAR(tanggal_pemasukan) = '$tahun' AND MONTHNAME(tanggal_pemasukan) = '$bulan'
            ";

            $pengeluaran_query = "
            SELECT
                MONTHNAME(tanggal_pengeluaran) AS bulan,
                COUNT(id_pengeluaran) AS jumlah_transaksi,
                SUM(jumlah_pengeluaran) AS total_pengeluaran
            FROM
                pengeluaran
            WHERE
                YEAR(tanggal_pengeluaran) = '$tahun' AND MONTHNAME(tanggal_pengeluaran) = '$bulan'
            ";

            $pengeluaran_total_query = "
            SELECT
                SUM(jumlah_pengeluaran) AS total_pengeluaran,
                COUNT(id_pengeluaran) AS totaltransaksipengeluaran
            FROM
                pengeluaran
            WHERE
                YEAR(tanggal_pengeluaran) = '$tahun' AND MONTHNAME(tanggal_pengeluaran) = '$bulan'
            ";
        }

        $pemasukan_result = $mysqli->query($pemasukan_query);
        $totalpemasukan_result = $mysqli->query($totalpemasukan_query);
        $totalpemasukan_row = $totalpemasukan_result->fetch_assoc();
        $totalpemasukan = $totalpemasukan_row['totalpemasukan'];
        $totaltransaksipemasukan = $totalpemasukan_row['totaltransaksipemasukan'];
        
        $pengeluaran_result = $mysqli->query($pengeluaran_query);

        $pengeluaran_total_result = $mysqli->query($pengeluaran_total_query);
        $pengeluaran_total_row = $pengeluaran_total_result->fetch_assoc();
        $total_pengeluaran = $pengeluaran_total_row['total_pengeluaran'];
        $totaltransaksipengeluaran = $pengeluaran_total_row['totaltransaksipengeluaran'];
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

    <title>SANGU - Dashboard</title>

    <link rel="icon" href="Assets/img/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Assets/css/styles.css" rel="stylesheet">

    <style>
        @media (min-width: 576px) {
            .custome-width {
                max-width: 100px;
            }
        }
    </style>
</head>
<body id="page-top">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-custome sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <img src="Assets/img/BrandIcon.ico" alt="Brand Icon" width="40px">
                </div>
                <div class="sidebar-brand-text mx-2">SANGU</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fa-solid fa-fw fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Transaksi Heading -->
            <div class="sidebar-heading">
                Transaksi
            </div>

            <!-- Pemasukan -->
            <li class="nav-item">
                <a class="nav-link" href="pemasukan-page.php">
                    <i class="fa-solid fa-fw fa-money-check-dollar"></i>
                    <span>Pemasukan</span>
                </a>
            </li>

            <!-- Pengeluaran -->
            <li class="nav-item">
                <a class="nav-link" href="pengeluaran-page.php">
                    <i class="fa-solid fa-fw fa-money-bill-transfer"></i>
                    <span>Pengeluaran</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Lainnya Heading -->
            <div class="sidebar-heading">
                Lainnya
            </div>

            <!-- Dompet -->
            <li class="nav-item">
                <a class="nav-link" href="dompet-page.php">
                    <i class="fa-solid fa-fw fa-wallet"></i>
                    <span>Dompet</span>
                </a>
            </li>

            <!-- Tabungan Berencana -->
            <li class="nav-item">
                <a class="nav-link" href="tabunganberencana-page.php">
                    <i class="fa-solid fa-fw fa-piggy-bank"></i>
                    <span>Tabungan Berencana</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Page Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Content Page -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Current Page Indication -->
                    <a class="nav-link d-sm-flex d-none align-items-center" href="dashboard.php">
                        <i class="fa-solid fa-fw fa-house mr-2" style="color: #6e707e"></i>
                        <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Dashboard</h4>
                    </a>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark font-weight-bold">
                                    <?= $_SESSION['username']; ?>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fa-solid fa-arrow-right-from-bracket fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h3 class="h3 mb-4 text-gray-800">Dashboard</h3>

                    <!-- Illustrations -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" src="Assets/img/HeroImage.png">
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <h3 class="pt-3 text-primary">
                                        Selamat Datang <b><?= $_SESSION['username']; ?></b> di <b>SANGU</b>!
                                    </h3>
                                    <p class="mb-3">SANGU adalah web dompet digital yang membantu Anda mengelola keuangan dan merencanakan tabungan dengan mudah dan efisien. Pantau pengeluaran, atur anggaran, dan capai tujuan finansial Anda dengan SANGU!</p>
                                    <div class="d-flex align-items-center">
                                        <a class="btn btn-success rounded-pill mr-3" href="tambahpemasukan.php">
                                            <i class="fa-solid fa-plus text-white-100 mr-1"></i>
                                            Pemasukan
                                        </a>

                                        <a class="btn btn-warning rounded-pill" href="tambahpengeluaran.php">
                                            <i class="fa-solid fa-plus text-white-100 mr-1"></i>
                                            Pengeluaran
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Illustrations -->

                    <!-- Information Card -->
                    <div class="row">
                        <!-- First Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Pemasukan Terbesar
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if($max_pemasukan === null || $max_pemasukan === false || !isset($max_pemasukan['Max'])) {
                                                        echo "-";
                                                    } else {
                                                        echo rupiahFormat($max_pemasukan['Max']);
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-money-check-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pengeluaran Terbesar
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if($max_pengeluaran === null || $max_pengeluaran === false || !isset($max_pengeluaran['Max'])) {
                                                        echo "-";
                                                    } else {
                                                        echo rupiahFormat($max_pengeluaran['Max']);
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-money-bill-transfer fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Third Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Jumlah Dompet
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if($jumlahDompet === null || $jumlahDompet === false || !isset($jumlahDompet['total'])) {
                                                        echo "0";
                                                    } else {
                                                        echo $jumlahDompet['total'];
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-wallet fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Tabungan (On Progress)
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if($jumlahTabungan === null || $jumlahTabungan === false || !isset($jumlahTabungan['total'])) {
                                                        echo "0";
                                                    } else {
                                                        echo $jumlahTabungan['total'];
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-piggy-bank fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Information Card -->

                    <!-- Filter Laporan -->
                    <div class="card mb-4">
                        <div class="card-header" style="font-weight:bold; font-size:20px;">
                            Laporan Pemasukan & Pengeluaran
                        </div>

                        <div class="card-body">
                            <p class="card-text">Filter Data <i class="fas fa-star-of-life" style="font-size: 7px; vertical-align: top; color: #ED2939"></i></p>
                            <form method="GET" action="">
                                <div class="d-sm-flex align-items-center">
                                    <div class="mr-sm-3 mb-sm-0 mb-3">
                                        <select name="bulan" class="form-select form-control">
                                            <option value="" selected disabled>-- Pilih Bulan --</option>
                                            <option value="January">Januari</option>
                                            <option value="February">Februari</option>
                                            <option value="March">Maret</option>
                                            <option value="April">April</option>
                                            <option value="May">Mei</option>
                                            <option value="June">Juni</option>
                                            <option value="July">Juli</option>
                                            <option value="August">Agustus</option>
                                            <option value="September">September</option>
                                            <option value="October">Oktober</option>
                                            <option value="November">November</option>
                                            <option value="December">Desember</option>
                                        </select>
                                    </div>
                                    <div class="mr-sm-3 mb-sm-0 mb-3">
                                        <select name="tahun" class="form-select form-control" required>
                                            <option value=""  selected disabled>-- Pilih Tahun --</option>
                                            <?php while($row = $years_result->fetch_assoc()): ?>
                                                <option value="<?php echo $row['year']; ?>"><?php echo $row['year']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill w-100 w-small-auto custome-width" name="btn-show">Tampilkan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End of Filter Laporan -->

                    <!-- Laporan Pemasukan & Pengeluaran -->
                    <?php if (isset($pemasukan_result) && isset($pengeluaran_result)): ?>
                        <div class="card"">
                            <div class="card-header" style="font-weight:bold; font-size:20px;">
                                Laporan Pemasukan & Pengeluaran
                            </div>
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">Pemasukan</h5>
                                <table class="table table-bordered"">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Jumlah Transaksi</th>
                                            <th scope="col">Pemasukan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $pemasukan_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo (strftime('%B', strtotime($row['bulan']))) ?></td>
                                                <td><?php echo $row['jumlah_transaksi']; ?></td>
                                                <td><?php echo rupiahFormat($row ['total_pemasukan']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td><b><?php echo $totaltransaksipemasukan; ?></b></td>
                                            <td><b><?php echo rupiahFormat($totalpemasukan); ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <h5 class="card-title font-weight-bold mt-4">Pengeluaran</h5>
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Jumlah Transaksi</th>
                                            <th scope="col">Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $pengeluaran_result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo (strftime('%B', strtotime($row['bulan']))) ?></td>
                                                <td><?php echo $row['jumlah_transaksi']; ?></td>
                                                <td><?php echo rupiahFormat($row['total_pengeluaran']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td><b><?php echo $totaltransaksipengeluaran; ?></b></td>
                                            <td><b><?php echo rupiahFormat($total_pengeluaran); ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- End of Laporan -->
                </div>
                <!-- End of Container -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; SANGU 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Wrapper -->

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa-solid fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    Pilih "Logout" di bawah jika Anda yakin untuk mengakhiri sesi Anda saat ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="ExeFiles/logout-exe.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Logout Modal -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Assets/js/sb-admin-2.min.js"></script>
</body>
</html>
