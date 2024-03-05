<?php
require_once("database.php");
require_once("auth.php");

// variabel 'photo_id' = request GET 'id'
$photo_id = $_GET["id"];

// menyiapkan query
$sql = "SELECT * FROM photos WHERE photo_id=:photo_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":photo_id" => $photo_id,
);

// eksekusi query
$stmt->execute($params);

$photos = $stmt->fetch(PDO::FETCH_ASSOC);

// menghapus file gambar
unlink("../" . $photos["image_path"]);

// menyiapkan query
$sql = "DELETE FROM photos WHERE photo_id=:photo_id";
$stmt = $db->prepare($sql);

// eksekusi query
$stmt->execute($params);

header("Location: index.php");
