<?php

// memulai sesi
session_start();
// jika user ter autentikasi maka ambil data user, jia tidak arahkan ke halaman login
if (isset($_SESSION["user"])) {
    $user_login = $_SESSION["user"];

    $user_id = $user_login['user_id'];
    $name = $user_login['name'];
    $username = $user_login['username'];
    $password = $user_login['password'];
    $email = $user_login['email'];
    $access_level = $user_login['access_level'];
    $created_at = $user_login['created_at'];
} else {
    header("Location: ../login.php");
}
