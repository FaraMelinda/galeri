<?php
require_once("database.php");
require_once("auth.php");

// variabel 'album_id' = request GET 'id'
$album_id = $_GET["id"];

// menyiapkan query
$sql = "SELECT * FROM albums WHERE album_id=:album_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":album_id" => $album_id
);

// eksekusi query
$stmt->execute($params);

$albums = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":user_id" => $albums["user_id"]
);

// eksekusi query
$stmt->execute($params);

$author = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM photos WHERE album_id=:album_id";
$photos = $db->prepare($sql);

$params = array(
    ":album_id" => $album_id
);

// eksekusi query
$photos->execute($params);

$jumlah_foto = $photos->rowCount();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- menceta judul album -->
    <title><?php echo $albums["title"]; ?></title>

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
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
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

    <section class="h-100">
        <div class="m-4 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-10 col-xl-8 mt-5">
                    <!-- jika user_id album sama dengan user_id user saat ini munculkan tombol Edit album -->
                    <?php if ($albums["user_id"] == $user_id) { ?>
                        <div class="text-end">
                            <!-- link ke halaman edit album ditambah parameter id yang di ambil dari 'album_id' -->
                            <a href="users/edit_album.php?id=<?php echo $album_id; ?>" class="btn btn-outline-dark mb-2" data-mdb-ripple-color="dark" style="z-index: 1;">
                                <i class="fa-solid fa-pen"></i> Edit album
                            </a>
                        </div>
                    <?php } ?>
                    <div class="card border-0">
                        <div class="p-4 text-black bg-light">
                            <div class="d-flex justify-content-between py-1">
                                <div>
                                    <!-- mencetak judul album -->
                                    <p class="mb-1 h5"><?php echo $albums["title"]; ?></p>
                                    <!-- mencetak username pembuat album -->
                                    <p class="small text-muted mb-0">@<?php echo $author["username"] ?></p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <!-- mencetak jumlah foto dalam album -->
                                        <p class="mb-1 h5 text-center"><?php echo $jumlah_foto; ?></p>
                                        <p class="small text-muted mb-0">Foto</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <!-- mencetak deskripsi album -->
                                <p><?php echo $albums["description"] ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <div class="row g-2">
                                    <!-- looping data dari tabel photos  -->
                                    <?php foreach ($photos as $photo) { ?>
                                        <div class="col-lg-6 mb-2">
                                            <!-- link ke halaman lihat foto ditambah parameter id yang di ambil dari 'photo_id' -->
                                            <a href="lihat_foto.php?id=<?php echo $photo["photo_id"]; ?>">
                                                <!-- mencetak url gambar dan judul dari data row photo  -->
                                                <img src="<?php echo $photo["image_path"]; ?>" alt="<?php echo $photo["title"]; ?>" class="w-100 shadow-1-strong rounded-3 bg-light" style="height:270px; object-fit: contain;">
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
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