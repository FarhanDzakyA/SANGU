<?php
    include "ExeFiles/session-check.php";
?>

<?php
    include "ExeFiles/koneksi.php";

    setlocale(LC_ALL, 'IND');

    $id_pengguna = $_SESSION['id_pengguna'];

    $query_table = mysqli_query($mysqli, "SELECT pemasukan.id_pemasukan, pemasukan.tanggal_pemasukan, 
    pemasukan.deskripsi_pemasukan, kategori.nama_kategori, pemasukan.jumlah_pemasukan, dompet.nama_dompet 
    FROM `pemasukan`, `dompet`, `kategori` WHERE pemasukan.kategori_pemasukan = kategori.id_kategori AND 
    pemasukan.id_dompet = dompet.id_dompet AND pemasukan.id_pengguna = '$id_pengguna' ORDER BY id_pemasukan ASC");

    $number = 1;

    function rupiahFormat($number) {
        return 'Rp ' . number_format($number, 0, ',', '.');
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

    <title>SANGU - Pemasukan</title>

    <link rel="icon" href="Assets/img/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
            <li class="nav-item active">
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
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Current Page Indication -->
                    <a class="nav-link d-flex align-items-center" href="pemasukan-page.php">
                        <i class="fa-solid fa-fw fa-money-check-dollar mr-2" style="color: #6e707e"></i>
                        <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Pemasukan</h4>
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
                    <h3 class="h3 mb-4 text-gray-800">Pemasukan</h3>

                    <!-- Tabel Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">
                                    Data Pemasukan
                                </h5>
                                <a class="d-none d-sm-inline-block btn btn-sm btn-primary rounded-pill shadow-sm" href="tambahpemasukan.php">
                                    <i class="fas fa-plus fa-sm text-white-100 mr-2"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Dompet</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($result = mysqli_fetch_assoc($query_table)) { ?>
                                        <tr>
                                            <td><?= $number ?></td>
                                            <td><?= strftime('%A, %d %B %Y', strtotime($result['tanggal_pemasukan'])) ?></td>
                                            <td><?= $result['deskripsi_pemasukan'] ?></td>
                                            <td><?= $result['nama_kategori'] ?></td>
                                            <td><?= rupiahFormat($result['jumlah_pemasukan']) ?></td>
                                            <td><?= $result['nama_dompet'] ?></td>
                                            <td>
                                                <a href="editpemasukan.php?update=<?= $result['id_pemasukan'] ?>" class="btn btn-primary btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-fw fa-pen"></i>
                                                </a>
                                                <span class="mr-1"></span>
                                                <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#hapusPemasukan<?= $result['id_pemasukan'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="hapusPemasukan<?= $result['id_pemasukan'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-tittle">Hapus Data Pemasukan ?</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">x</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id_pemasukan" value="<?= $result['id_pemasukan'] ?>">

                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus catatan pemasukan <b>"<?= $result['deskripsi_pemasukan'] ?>"</b> ?
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" name="btn-hapus" class="btn btn-danger">
                                                                Ya, Hapus Dompet
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                                $number++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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
                    <a class="btn btn-primary" href="ExeFiles/logout-exe.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Logout Modal -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="Assets/js/jquery.dataTables.min.js"></script>
    <script src="Assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="Assets/js/demo/datatables-demo.js"></script>
</body>
</html>

<?php
    if(isset($_POST['btn-hapus'])) {
        $id_pemasukan = mysqli_real_escape_string($mysqli, $_POST['id_pemasukan']);

        $query_delete = mysqli_query($mysqli, "DELETE FROM `pemasukan` WHERE `id_pemasukan` = '$id_pemasukan'");

        if($query_delete) {
            ?>

            <script>
                Swal.fire({
                    title: "Berhasil!",
                    text: "Data Pemasukan Berhasil Dihapus!",
                    icon: "success"
                }).then(function() {
                    window.location.href = 'pemasukan-page.php';
                });
            </script>

            <?php
        } else {
            echo "Error: " . $query_delete . "<br>" . mysqli_error($mysqli);
        }
    }
?>