<?php

// memulai sesi
session_start();
// menghapus seesion 'user'
unset($_SESSION['user']);
// alihkan ke halaman index
header("Location: index.php");
