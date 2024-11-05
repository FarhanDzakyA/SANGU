<?php
    session_start();
    include 'koneksi.php';

    if(isset($_POST['btn-register'])) {
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $confirmPass = $_POST['confirmPass'];

        $_SESSION['usernameRegis'] = $username;
        $_SESSION['pass'] = $pass;
        $_SESSION['confirmPass'] = $confirmPass;

        if($pass == $confirmPass) {
            $username = mysqli_real_escape_string($mysqli, $username);
            $pass = mysqli_real_escape_string($mysqli, $pass);

            $password = password_hash($pass, PASSWORD_DEFAULT);

            $query_insert = mysqli_query($mysqli, "INSERT INTO `pengguna`(`username`, `password`) VALUES ('$username','$password')");

            if($query_insert) {
                unset($_SESSION['usernameRegis']);
                unset($_SESSION['pass']);
                unset($_SESSION['confirmPass']);

                header("Location: ../index.php");
                exit();
            } else {
                $errorMessage = "Error: " . mysqli_error($mysqli);
            }
        } else {
            $_SESSION['invalidRegis'] = true;

            header("Location: ../register-page.php");
            exit();
        }
    }
?>