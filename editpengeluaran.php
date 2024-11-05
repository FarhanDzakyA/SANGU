<?php
    include "ExeFiles/session-check.php";
?>

<?php
    include "ExeFiles/koneksi.php";

    $id = $_SESSION['id_pengguna'];

    $query_select = mysqli_query($mysqli, "SELECT * FROM `pengeluaran` WHERE `id_pengeluaran` = '$_GET[update]'");
    $query_dompet = mysqli_query($mysqli, "SELECT * FROM `dompet` WHERE id_pengguna = '$id'");
    $query_kategori = mysqli_query($mysqli, "SELECT * FROM `kategori` WHERE tipe_kategori = 'Pengeluaran'");

    $result = mysqli_fetch_assoc($query_select);

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
    
    <title>SANGU - Edit Pengeluaran</title>

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
            <div class="sidebar-heading">Transaksi</div>

            <!-- Pemasukan -->
            <li class="nav-item">
                <a class="nav-link" href="pemasukan-page.php">
                    <i class="fa-solid fa-fw fa-money-check-dollar"></i>
                    <span>Pemasukan</span>
                </a>
            </li>

            <!-- Pengeluaran -->
            <li class="nav-item active">
                <a class="nav-link" href="pengeluaran-page.php">
                    <i class="fa-solid fa-fw fa-money-bill-transfer"></i>
                    <span>Pengeluaran</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Lainnya Heading -->
            <div class="sidebar-heading">Lainnya</div>

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
                    <div class="d-sm-flex d-none align-items-center">
                        <a class="nav-link d-flex align-items-center" href="pengeluaran-page.php">
                            <i class="fa-solid fa-fw fa-money-check-dollar mr-2" style="color: #6e707e"></i>
                            <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Pengeluaran</h4>
                        </a>

                        <i class="fa-solid fa-fw fa-angle-right" style="color: #6e707e"></i>

                        <a class="nav-link d-flex align-items-center" href="editpengeluaran.php?update=<?= $_GET['update'] ?>">
                            <i class="fa-solid fa-fw fa-pen mr-2" style="color: #6e707e"></i>
                            <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Edit Pengeluaran</h4>
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
                    <h3 class="h3 mb-4 text-gray-800">Edit Pengeluaran</h3>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Edit Pengeluaran</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <!-- date -->
                                 <div class="form-group">
                                    <label for="date">Tanggal <i class="fas fa-star-of-life text-danger" style="font-size: 7px; vertical-align: top;"></i></label>
                                    <input type="date" id="date" name="date" class="form-control" value="<?= $result['tanggal_pengeluaran'] ?>" max="<?= date('Y-m-d'); ?>" required>
                                 </div>
                                
                                <!-- description -->
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi <i class="fas fa-star-of-life text-danger" style="font-size: 7px; vertical-align: top;"></i></label>
                                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi pengeluaran ..." value="<?= $result['deskripsi_pengeluaran'] ?>" required>
                                </div>

                                <!-- amount -->
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Pengeluaran <i class="fas fa-star-of-life text-danger" style="font-size: 7px; vertical-align: top;"></i></label>
                                    <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Masukkan jumlah pengeluaran ..." value="<?= rupiahFormat($result['jumlah_pengeluaran']) ?>" onkeyup="formatRupiah(this)" required>
                                </div>
                                
                                <!-- dompet -->
                                <div class="form-group">
                                    <label for="dompet">Dompet <i class="fas fa-star-of-life text-danger" style="font-size: 7px; vertical-align: top;"></i></label>
                                    <select id="dompet" name="dompet" class="form-select form-control">
                                        <option selected disabled>-- Pilih Dompet --</option>
                                        <?php while($dompet = mysqli_fetch_assoc($query_dompet)) { 
                                            $selected_dompet = ($dompet['id_dompet'] == $result['id_dompet']) ? 'selected' : '';
                                            ?>
                                            <option value="<?= $dompet['id_dompet'] ?>" <?= $selected_dompet ?>><?= $dompet['nama_dompet'] ?> -- <?= rupiahFormat($dompet['saldo']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- kategori -->
                                <div class="form-group">
                                    <label for="kategori">Kategori <i class="fas fa-star-of-life text-danger" style="font-size: 7px; vertical-align: top;"></i></label>
                                    <select id="kategori" name="kategori" class="form-select form-control">
                                        <option selected disabled>-- Pilih Kategori --</option>
                                        <?php while($kategori = mysqli_fetch_assoc($query_kategori)) { 
                                            $selected_kategori = ($kategori['id_kategori'] == $result['kategori_pengeluaran']) ? 'selected' : '';
                                            ?>
                                            <option value="<?= $kategori['id_kategori'] ?>" <?= $selected_kategori ?>><?= $kategori['nama_kategori'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- tombol -->
                                <div class="d-flex align-items-center justify-content-start">
                                    <button type="submit" name="btn-simpan" class="btn btn-primary">Simpan</button>
                                    <span class="mr-2"></span>
                                    <a href="pengeluaran-page.php" class="btn btn-secondary">Batalkan</a>
                                </div>
                            </form>

                            <?php
                                if(isset($_POST['btn-simpan'])) {
                                    $id_pengeluaran = $_GET['update'];
                                    $date = mysqli_real_escape_string($mysqli, $_POST['date']);
                                    $deskripsi = mysqli_real_escape_string($mysqli, $_POST['deskripsi']);
                                    $id_dompet = mysqli_real_escape_string($mysqli, $_POST['dompet']);
                                    $id_kategori = mysqli_real_escape_string($mysqli, $_POST['kategori']);

                                    $jumlah = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
                                    $jumlah = str_replace('Rp', '', $jumlah);
                                    $jumlah = str_replace('.', '', $jumlah);
                                    $jumlah = (int)$jumlah;

                                    $query_saldo = mysqli_query($mysqli, "SELECT saldo FROM `dompet` WHERE id_dompet = '$id_dompet'");
                                    $result_saldo = mysqli_fetch_assoc($query_saldo);
                                    $saldo_dompet = $result_saldo['saldo'] + $result['jumlah_pengeluaran'];

                                    if($saldo_dompet >= $jumlah) {
                                        $query_update = mysqli_query($mysqli, "UPDATE `pengeluaran` SET 
                                        `tanggal_pengeluaran`='$date',
                                        `kategori_pengeluaran`='$id_kategori',
                                        `deskripsi_pengeluaran`='$deskripsi',
                                        `jumlah_pengeluaran`='$jumlah',
                                        `id_dompet`='$id_dompet' 
                                        WHERE `id_pengeluaran`='$id_pengeluaran'");
    
                                        if($query_update) {
                                            ?>
    
                                            <script>
                                                Swal.fire({
                                                    title: "Berhasil!",
                                                    text: "Data Pengeluaran Berhasil Diubah!",
                                                    icon: "success"
                                                }).then(function() {
                                                    window.location.href = 'pengeluaran-page.php';
                                                });
                                            </script>
    
                                            <?php
                                        } else {
                                            echo "Error: " . $query_insert . "<br>" . mysqli_error($mysqli);
                                        }
                                    } else {
                                        ?>
    
                                        <script>
                                            Swal.fire({
                                                title: "Gagal!",
                                                text: "Saldo Dompet Tidak Mencukupi!",
                                                icon: "error"
                                            }).then(function() {
                                                window.location.href = 'editpengeluaran.php?update=<?= $_GET['update'] ?>';
                                            });
                                        </script>

                                        <?php
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
                <div class="modal-body">Pilih "Logout" di bawah jika Anda yakin untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('accordionSidebar');
            if (!sidebar.classList.contains('toggled')) {
                sidebar.classList.add('toggled');
            }
        });

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
