<?php
require_once("database.php");
require_once("auth.php");

// variabel 'user_id' = request GET 'id'
$user_id = $_GET["id"];

// menyiapkan query
$sql = "DELETE FROM users WHERE user_id=:user_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":user_id" => $user_id,
);

// eksekusi query
$stmt->execute($params);

// menyiapkan query
$sql = "SELECT * FROM albums WHERE user_id=:user_id";
$albums = $db->prepare($sql);

// eksekusi query
$albums->execute($params);

// menghapus album milik user
foreach ($albums as $album) {
    // menyiapkan query
    $sql = "SELECT * FROM photos WHERE album_id=:album_id";
    $photos = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":album_id" => $album["album_id"],
    );

    // eksekusi query
    $photos->execute($params);

    // menghapus album milik user
    foreach ($photos as $photo) {

        // menghapus file gambar
        unlink($photo["image_path"]);

        // menyiapkan query
        $sql = "DELETE FROM photos WHERE photo_id=:photo_id";
        $stmt = $db->prepare($sql);

        // bind parameter ke query
        $params = array(
            ":photo_id" => $photo["photo_id"],
        );

        $stmt->execute($params);
    }

    // menghapus folder album
    $dir = "../uploads/" . $album["album_id"];
    array_map('unlink', glob("$dir/*.*"));
    rmdir($dir);

    // menyiapkan query
    $sql = "DELETE FROM albums WHERE album_id=:album_id";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":album_id" => $album["album_id"],
    );

    // eksekusi query
    $stmt->execute($params);
}

// alihkan ke halaman data semua user
header("Location: index.php");
