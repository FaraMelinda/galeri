<?php
require_once("database.php");
require_once("auth.php");

// menyiapkan query
$sql = "SELECT * FROM photos";
$photos = $db->prepare($sql);

// eksekusi query
$photos->execute();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galerry</title>

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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="album.php">Album</a>
                    </li>
                </ul>
                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-secondary rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <ul class="dropdown-menu" style="top: 100%; left: auto; right: 0; ">
                            <li><a class="dropdown-item" href="users">Profil</a></li>
                            <li><a class="dropdown-item" href="users/album_saya.php">Album saya</a></li>
                            <li><a class="dropdown-item" href="users/foto_saya.php">Foto saya</a></li>
                            <?php if ($access_level == "admin") { ?>
                                <li><a class="dropdown-item" href="admin/index.php">Data user</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div> <?php } else { ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php } ?>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="m-4">
        <!-- Gallery -->
        <div class="row">
            <?php

            // looping semua data photo dari database
            foreach ($photos as $photo) { ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <a href="lihat_foto.php?id=<?php echo $photo['photo_id']; ?>">
                        <div class="position-relative shadow-1-strong rounded" style="height:270px; background-image: url('<?php echo $photo["image_path"]; ?>'); background-size: cover; object-fit: cover;">
                            <div class="h-100 shadow-1-strong rounded">
                                <div class=" position-absolute top-50 start-50 translate-middle text-white">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <!-- Gallery -->
    </div>


    <!-- footer end -->

    <!-- link cdn bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>