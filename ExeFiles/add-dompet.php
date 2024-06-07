<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id=$_POST["username"];
    $nama=$_POST["nama"];
    $saldo = $_POST["saldo"];
    $quer = "INSERT INTO `dompet`(`nama_dompet`, `saldo`, `id_pengguna`) VALUES ('$nama','$saldo','$id')";
    if ($mysqli->query($quer) === TRUE) {
        header("Location:../dompet-page.php");
    }else {
        header("Location:../tambahdompet.php");
    }

}
?>
