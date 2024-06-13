<?php
    session_start();
    include "ExeFiles/koneksi.php";
    $id = $_GET['update'];
    $query_select = mysqli_query($mysqli, "SELECT * FROM `rencana` WHERE id_rencana = '$_GET[update]'");
    $result = mysqli_fetch_assoc($query_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SANGU - Tambah Rencana</title>

    <link rel="icon" href="Assets/img/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Assets/css/styles.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li class="nav-item">
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
            <li class="nav-item active">
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
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </form>

                    <!-- Current Page Indication -->
                     <div class="d-flex align-items-center">
                         <a class="nav-link d-flex align-items-center" href="tabunganberencana-page.php">
                            <i class="fa-solid fa-fw fa-piggy-bank mr-2" style="color: #6e707e"></i>
                            <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Tabungan Berencana</h4>
                         </a>

                         <i class="fa-solid fa-fw fa-angle-right" style="color: #6e707e"></i>

                         <a class="nav-link d-flex align-items-center" href="#">
                            <i class="fa-solid fa-fw fa-pen mr-2" style="color: #6e707e"></i>
                             <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Edit Rencana</h4>
                         </a>
                     </div>

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
                    <h3 class="h3 mb-4 text-gray-800">Tambah Rencana</h3>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">
                                Tambah Rencana
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="rencana">Rencana<i class="fas fa-star-of-life" style="font-size: 7px; vertical-align: top; color: #ED2939"></i></label>
                                    <input type="text" id="nama_dompet" name="rencana" class="form-control" placeholder="Masukkan Rencana Tabungan Anda..." value="<?=$result['rencana']?>"required>
                                </div>

                                <div class="form-group">
                                    <label for="target">Target<i class="fas fa-star-of-life" style="font-size: 7px; vertical-align: top; color: #ED2939"></i></label>
                                    <input type="text" id="saldo" name="target" class="form-control" placeholder="Masukkan target yang ingin dicapai..." onkeyup="formatRupiah(this)" value="<?=$result['target']?>" required>
                                </div>

                                <div class="d-sm-flex align-items-center justify-content-start">
                                    <button type="submit" name="btn-simpan" class="btn btn-primary">Simpan</button>
                                    <span class="mr-2"></span>
                                    <a href="tabunganberencana-page.php" class="btn btn-secondary">Batalkan</a>
                                </div>
                            </form>

                            <?php
                                if (isset($_POST['btn-simpan'])) {
                                    $id_pengguna = $_SESSION['id_pengguna'];
                                    $rencana = mysqli_real_escape_string($mysqli, $_POST['rencana']);

                                    $saldo = mysqli_real_escape_string($mysqli, $_POST['target']);
                                    $saldo = str_replace('Rp', '', $saldo);
                                    $saldo = str_replace('.', '', $saldo);
                                    $saldo = (int)$saldo;

                                    $query_insert = mysqli_query($mysqli, "UPDATE `rencana` SET `rencana`='$rencana',`target`='$saldo' WHERE id_rencana ='$id'");
                                
                                    if($query_insert) {
                                        ?>

                                        <script>
                                            Swal.fire({
                                                title: "Berhasil!",
                                                text: "Rencana Tabungan Berhasil di Update!",
                                                icon: "success"
                                            }).then(function() {
                                                window.location.href = 'tabunganberencana-page.php';
                                            });
                                        </script>

                                        <?php
                                    } else {
                                        echo "Error: " . $query_insert . "<br>" . mysqli_error($mysqli);
                                    }
                                }
                            ?>

                        </div>
                    </div>
                </div>
                <!-- End of Container -->
            </div>
            <!-- End of Main Content -->

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
                    <a class="btn btn-primary" href="login-page.php">Logout</a>
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

    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^\d]/g, '');

            if (value === '' || isNaN(parseInt(value))) {
                value = 0;
            } else {
                value = parseInt(value);
            }

            value = 'Rp ' + formatNumber(parseInt(value));
            input.value = value;
        }

        function formatNumber(number) {
            return number.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
