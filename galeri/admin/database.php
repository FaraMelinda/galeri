<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "galeri";

try {
    // membuat koneksi PDO
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    // menampilkan pesan kesalahan
    die("Terjadi masalah: " . $e->getMessage());
}
