<?php
    session_start();
    include 'koneksi.php';

    if(isset($_POST['btn-login'])) {
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

        $_SESSION['username'] = $username;

        $query_pass = mysqli_query($mysqli, "SELECT `password`, `id_pengguna` FROM `pengguna` WHERE `username` = '$username'");
        
        if($query_pass) {
            if(mysqli_num_rows($query_pass) > 0) {
                $row = mysqli_fetch_assoc($query_pass);
                $hashedPass = $row['password'];
                $_SESSION['id_pengguna'] = $row['id_pengguna'];
    
                if(password_verify($pass, $hashedPass)) {
                    $_SESSION['login'] = true;

                    header("Location: ../dashboard.php");
                    exit();
                } else {
                    $_SESSION['invalidLogin'] = true;

                    header("Location: ../index.php");
                    exit();
                }
            } else {
                $_SESSION['invalidLogin'] = true;

                header("Location: ../index.php");
                exit();
            }
        } else {
            echo "Error: " . mysqli_error($mysqli);
            exit();
        }
    }