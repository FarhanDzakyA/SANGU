<?php
    session_start();
    include "ExeFiles/koneksi.php";

    $id_pengguna = $_SESSION['id_pengguna'];
    $query_table = mysqli_query($mysqli, "SELECT * FROM `rencana` WHERE id_pengguna = '$id_pengguna'");
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

    <title>SANGU - Dompet</title>

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
            <li class="nav-item ">
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
                    <a class="nav-link d-flex align-items-center" href="dompet-page.php">
                        <i class="fa-solid fa-fw fa-piggy-bank mr-2" style="color: #6e707e"></i>
                        <h4 class="h4 mb-0 text-gray-700 font-weight-bold">Tabungan Berencana</h4>
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
                    <h3 class="h3 mb-4 text-gray-800">Rencana Tabungan</h3>

                    <!-- Tabel Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">
                                    Data Rencana Tabungan
                                </h5>
                                <a class="d-none d-sm-inline-block btn btn-sm btn-primary rounded-pill shadow-sm" href="tambah-rencana.php">
                                    <i class="fas fa-plus fa-sm text-white-100 mr-2"></i>
                                    Tambah Rencana
                                </a>
                            </div>
                            </div>
                            <div class="row">
                                <?php while($result = mysqli_fetch_assoc($query_table)) {?>
                                <?php
                                $hitung_progress = $result['tertabung']/$result['target'];
                                $progress_persen = $hitung_progress * 100;
                                $remaining_amount = $result['target'] - $result['tertabung'];
                                $modal_id_plus = 'plusModal' . $result['id_rencana'];
                                $modal_id_minus = 'minusModal' . $result['id_rencana'];
                                ?>
                                <div class="col-md-6 col-12 mb-4 mt-3">
                                    <div class="card shadow py-1">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-lg text-center font-weight-bold text-info text-uppercase mb-1"><?=$result['rencana'];?></div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-6">
                                                            <h4 class="small font-weight-bold"><?=rupiahFormat($result['tertabung']);?></h4>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <span class="small font-weight-bold"><?=rupiahFormat($result['target']);?></span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mb-1">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?=$progress_persen?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><?= $progress_persen ?>%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="col text-center">
                                                <a href="#" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#<?=$modal_id_plus;?>"><i class="fa-solid fa-plus"></i></a>
                                                <a href="#" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#<?=$modal_id_minus;?>"><i class="fa-solid fa-minus"></i></a>
                                                <a href="#" class="btn btn-warning btn-circle"><i class="fas fa-fw fa-pen"></i></a>
                                                <a href="#" class="btn btn-danger btn-circle" data-toggle="modal" data-target="#hapusRencana<?=$result['id_rencana']?>"><i class="fas fa-fw fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Plus Modal -->
                                <div class="modal fade" id="<?=$modal_id_plus;?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Deposit</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form for adding amount -->
                                                <form method="POST" action="">
                                                    <div class="mb-3">
                                                        <label for="amountToAdd<?=$result['id_rencana'];?>" class="form-label">Banyak yang akan disimpan</label>
                                                        <input type="text" class="form-control" id="amountToAdd<?=$result['id_rencana'];?>" name="amountToAdd" onkeyup="formatRupiah(this, <?=$remaining_amount;?>)" data-remaining-amount="<?=$remaining_amount;?>">
                                                    </div>
                                                    <input type="hidden" name="id_rencana" value="<?=$result['id_rencana'];?>">
                                                    <button type="submit" class="btn btn-primary" id="submitPlus<?=$result['id_rencana'];?>" name="btn-depo" disabled>Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- minus modal  -->
                                 <div class="modal fade" id="<?=$modal_id_minus;?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Withdraw</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST">
                                                    <div class="mb-3">
                                                        <label for="amountTolose<?=$result['id_rencana'];?>" class="form-label">Banyak yang akan dikeluarkan</label>
                                                        <input type="text" class="form-control" id="amountTolose<?=$result['id_rencana'];?>" name="amountTolose" onkeyup="formatRupiahmin(this,<?=$result['tertabung'];?>)" data-remaining-amount="<?=$result['tertabung']?>">
                                                    </div>
                                                    <input type="hidden" name="id_rencana" value="<?=$result['id_rencana'];?>">
                                                    <button type="submit" class="btn btn-primary" id="submitMin<?=$result['id_rencana'];?>" name="btn-wit" disabled>submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <!--delete modal-->
                                        <div class="modal fade" id="hapusRencana<?= $result['id_rencana'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-tittle">Hapus Rencana ?</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">x</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id_rencana" value="<?= $result['id_rencana'] ?>">

                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus Rencana <b><?= $result['rencana'] ?></b> ?
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" name="btn-hapus" class="btn btn-danger">
                                                                Ya, Hapus Rencana
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                <?php }?>
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

    <!-- Core plugin JavaScript-->
    <script src="Assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="Assets/js/jquery.dataTables.min.js"></script>
    <script src="Assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="Assets/js/demo/datatables-demo.js"></script>

    <script>
        function formatRupiah(input, remainingAmount) {
            let value = input.value.replace(/[^\d]/g, '');
            
            if (value === '' || isNaN(parseInt(value))) {
                value = 0;
            } else {
                value = parseInt(value);
            }

            value = 'Rp ' + formatNumber(parseInt(value));
            input.value = value;

            checkAmount(value, remainingAmount, input.id);
        }

        function formatNumber(number) {
            return number.toLocaleString('id-ID');
            }
            
            function formatRupiahmin(input, remainingAmount) {
                let value = input.value.replace(/[^\d]/g, '');
                
                if (value === '' || isNaN(parseInt(value))) {
                    value = 0;
                } else {
                    value = parseInt(value);
                }
    
                value = 'Rp ' + formatNumber(parseInt(value));
                input.value = value;
    
                checkAmount2(value, remainingAmount, input.id);
            }
    
            function formatNumber(number) {
                return number.toLocaleString('id-ID');
            }

        function checkAmount(value, remainingAmount, inputId) {
            let numericValue = parseInt(value.replace(/[^\d]/g, ''));
            let submitButtonId = 'submitPlus' + inputId.replace('amountToAdd', '');
            let submitButton = document.getElementById(submitButtonId);

            if (numericValue > remainingAmount) {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }

        function checkAmount2(value, remainingAmount, inputId) {
            let numericValue = parseInt(value.replace(/[^\d]/g, ''));
            let submitButtonId = 'submitMin' + inputId.replace('amountTolose', '');
            let submitButton = document.getElementById(submitButtonId);

            if (numericValue > remainingAmount) {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }

    </script>
</body>
</html>

<?php
    if(isset($_POST['btn-hapus'])) {
        $id_rencana = mysqli_real_escape_string($mysqli, $_POST['id_rencana']);

        $query_delete = mysqli_query($mysqli, "DELETE FROM `rencana` WHERE id_rencana ='$id_rencana'");

        if($query_delete) {
            ?>

            <script>
                Swal.fire({
                    title: "Berhasil!",
                    text: "Rencana Tabungan Berhasil Dihapus!",
                    icon: "success"
                }).then(function() {
                    window.location.href = 'tabunganberencana-page.php';
                });
            </script>

            <?php
        } else {
            echo "Error: " . $query_delete . "<br>" . mysqli_error($mysqli);
        }
    }
?>

<?php 
if(isset($_POST["btn-wit"])) {
    $id_rencana = mysqli_real_escape_string($mysqli, $_POST['id_rencana']);
    $amountTolose = mysqli_real_escape_string($mysqli, $_POST['amountTolose']);
    $amountTolose = str_replace('Rp', '', $amountTolose);
    $amountTolose = str_replace('.', '', $amountTolose);
    $amountTolose = (int)$amountTolose;
    $query1 = mysqli_query($mysqli,"SELECT * FROM `rencana` WHERE id_rencana='$id_rencana'");
    $result = mysqli_fetch_assoc($query1); // changed $query_table to $query1
    $amounttotal = $result['tertabung'] - $amountTolose;

    $query = mysqli_query($mysqli,"UPDATE `rencana` SET `tertabung`='$amounttotal' WHERE id_rencana = '$id_rencana'");
    if($query) {
        ?>

        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "withdraw Berhasil",
                icon: "success"
            }).then(function() {
                window.location.href = 'tabunganberencana-page.php';
            });
        </script>

        <?php
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }
}
?>
<?php
if(isset($_POST['btn-depo'])){
    $id_rencana = mysqli_real_escape_string($mysqli, $_POST['id_rencana']);
    $amountToAdd = mysqli_real_escape_string($mysqli, $_POST['amountToAdd']);
    $amountToAdd = str_replace('Rp', '', $amountToAdd);
    $amountToAdd = str_replace('.', '', $amountToAdd);
    $amountToAdd = (int)$amountToAdd;
    $query1 = mysqli_query($mysqli,"SELECT * FROM `rencana` WHERE id_rencana='$id_rencana'");
    $result = mysqli_fetch_assoc($query1); // changed $query_table to $query1
    $amounttotal = $result['tertabung'] + $amountToAdd;
    $query = mysqli_query($mysqli,"UPDATE `rencana` SET `tertabung`='$amounttotal' WHERE id_rencana = '$id_rencana'");
    if($query) {
        ?>

        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "Deposit Berhasil!",
                icon: "success"
            }).then(function() {
                window.location.href = 'tabunganberencana-page.php';
            });
        </script>

        <?php
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }
}
?>
