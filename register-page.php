<?php 
    session_start();

    $username = isset($_SESSION['usernameRegis']) ? $_SESSION['usernameRegis'] : '';
    $pass = isset($_SESSION['pass']) ? $_SESSION['pass'] : '';
    $confirmPass = isset($_SESSION['confirmPass']) ? $_SESSION['confirmPass'] : '';
    $invalidRegis = isset($_SESSION['invalidRegis']) ? $_SESSION['invalidRegis'] : false;

    unset($_SESSION['usernameRegis']);
    unset($_SESSION['pass']);
    unset($_SESSION['confirmPass']);
    unset($_SESSION['invalidRegis']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>
    <link rel="icon" href="Assets/img/favicon.ico" sizes="16x16 32x32 48x48 64x64 128x128">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-custome">
    <div class="container">
        <!-- Outer Row -->
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row h-100">
                            <div class="col-lg-6 d-none d-lg-block brand-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun</h1>
                                    </div>
                                    <form class="user" action="ExeFiles/register-exe.php" method="POST">
                                        <div class="form-group">
                                            <label for="inputUsername">Username</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="inputUsername" name="username" aria-describedby="usernameHelp"
                                                placeholder="Enter Username..." value="<?= htmlspecialchars($username) ?>" required>
                                        </div>
                                        <label>Password</label>
                                        <div class="form-group row wrapper-register">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user"
                                                    id="inputPassword" name="password" placeholder="Password" value="<?= htmlspecialchars($pass) ?>" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user"
                                                    id="repeatPassword" name="confirmPass" placeholder="Repeat Password" value="<?= htmlspecialchars($confirmPass) ?>" required>
                                            </div>
                                            <p class="small form-text text-danger pl-3">
                                                <?php 
                                                    if($invalidRegis) {
                                                        echo 'Please make sure your passwords match';
                                                    } else {
                                                        echo '';
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                        <button type="submit" name="btn-register" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-decoration-none" href="login-page.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="Assets/js/jquery.min.js"></script>
    <script src="Assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Assets/js/sb-admin-2.min.js"></script>
</body>
</html>