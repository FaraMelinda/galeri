<?php
require_once("database.php");
require_once("auth.php");

// variabel 'album_id' = request GET 'id'
$album_id = $_GET["id"];

// menyiapkan query
$sql = "DELETE FROM albums WHERE album_id=:album_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":album_id" => $album_id,
);

// eksekusi query
$stmt->execute($params);

// menyiapkan query
$sql = "DELETE FROM photos WHERE album_id=:album_id";
$stmt = $db->prepare($sql);

// eksekusi query
$stmt->execute($params);

// menghapus folder beserta file di dalamnya
$dir = "../uploads/" . $album_id;
array_map('unlink', glob("$dir/*.*"));
rmdir($dir);

// alihkan ke halaman timeline
header("Location: index.php");
