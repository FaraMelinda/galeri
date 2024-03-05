<?php
require_once("database.php");
require_once("auth.php");

// menyiapkan query
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":user_id" => $user_id
);

// eksekusi query
$stmt->execute($params);

$users = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM albums WHERE user_id=:user_id";
$albums = $db->prepare($sql);

// eksekusi query
$albums->execute($params);

// menyiapkan query
$sql = "SELECT * FROM photos WHERE user_id=:user_id";
$photos = $db->prepare($sql);

// eksekusi query
$photos->execute($params);

if (isset($_POST['submit'])) {

    // filter data yang diinputkan
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

    // menyiapkan query
    $sql = "INSERT INTO albums (user_id, title, description) VALUES (:user_id, :title, :description)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":user_id" => $user_id,
        ":title" => $title,
        ":description" => $description
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    if ($saved) {
        // menyiapkan query
        $sql = "SELECT * FROM albums WHERE user_id=:user_id AND title=:title AND description=:description";
        $stmt = $db->prepare($sql);

        // eksekusi query 
        $stmt->execute($params);

        $albums = $stmt->fetch(PDO::FETCH_ASSOC);

        // membuat folder album
        $dir = "../uploads/" . $albums["album_id"] . "/";;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        // alihkan ke halaman profil
        header("Location: index.php");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah album</title>

    <!-- link cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- link cdn fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg mb-4 px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../album.php">Album</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-secondary rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>
                    <ul class="dropdown-menu" style="top: 100%; left: auto; right: 0; ">
                        <li><a class="dropdown-item" href="index.php">Profil</a></li>
                        <li><a class="dropdown-item" href="album_saya.php">Album saya</a></li>
                        <li><a class="dropdown-item" href="foto_saya.php">Foto saya</a></li>
                        <?php if ($access_level == "admin") { ?>
                            <li><a class="dropdown-item" href="../admin/index.php">Data user</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <section class="h-100">
        <div class="m-4 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-10 col-xl-8">
                    <div class="card border-0">
                        <h2 class="lead fw-normal mb-0 text-center mt-3">Tambah album</h2>
                        <div class="card-body p-4 text-black">
                            <form action="" method="POST">
                                <div class="mb-3 row">
                                    <label for="title" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="title" name="title" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="6" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-dark w-100" name="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- footer end -->

    <!-- link cdn bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>