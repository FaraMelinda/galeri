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
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil</title>

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
                        <li><a class="dropdown-item" href="#">Profil</a></li>
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
                        <div class="rounded-top text-white d-flex flex-row bg-secondary" style="height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <!-- mencetak name dari data users -->
                                <img src="https://ui-avatars.com/api/?name=<?php echo $users["name"]; ?>" alt="<?php echo $users["name"]; ?>" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; height: 150px; z-index: 1">
                                <!-- link ke halaman edit profil ditambah parameter id yang di ambil dari 'user_id' -->
                                <a href="edit_profil.php?id=<?php echo $user_id; ?>" class="btn btn-outline-dark" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    <i class="fa-solid fa-pen"></i> Edit profil
                                </a>
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <!-- mencetak name dari data users -->
                                <h5><?php echo $users["name"]; ?></h5>
                                <!-- mencetak username dari data users -->
                                <p>@<?php echo $users["username"] ?></p>
                            </div>
                        </div>
                        <div class="p-4 text-black bg-light">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div>
                                    <!-- mencetak jumlah album yang di miliki user -->
                                    <p class="mb-1 h5"><?php echo $albums->rowCount(); ?></p>
                                    <p class="small text-muted mb-0">Album</p>
                                </div>
                                <div class="px-3">
                                    <!-- mencetak jumlah foto yang di miliki user -->
                                    <p class="mb-1 h5"><?php echo $photos->rowCount(); ?></p>
                                    <p class="small text-muted mb-0">Foto</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="lead fw-light mb-0 text-center">Apa yang Anda ingin tambahkan?</p>
                        <div class="row p-4">
                            <div class="col">
                                <a href="tambah_album.php" class="btn btn-outline-dark w-100" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    <i class="fa-regular fa-images"></i> Album
                                </a>
                            </div>
                            <div class="col">
                                <a href="tambah_foto.php" class="btn btn-outline-dark w-100" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    <i class="fa-solid fa-image"></i> Foto
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <p class="lead fw-normal mb-0">Album</p>
                                    <p class="mb-0"><a href="album_saya.php" class="text-muted">Lihat semua</a></p>
                                </div>

                                <div class="row g-2">
                                    <?php
                                    // looping data album dari tabel albums
                                    $i = 0;
                                    foreach ($albums as $album) {
                                        // menyiapkan query
                                        $sql = "SELECT * FROM photos WHERE album_id=:album_id";
                                        $stmt = $db->prepare($sql);

                                        // bind parameter ke query
                                        $params = array(
                                            ":album_id" => $album["album_id"]
                                        );

                                        // eksekusi query
                                        $stmt->execute($params);

                                        $cover = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if (++$i == 5) break;
                                    ?>
                                        <div class="col-lg-6 mb-2">
                                            <!-- link ke halaman lihat album ditambah parameter id yang diambil dari 'album_id' -->
                                            <a href="../lihat_album.php?id=<?php echo $album["album_id"]; ?>">
                                                <div class="position-relative shadow-1-strong rounded" style="height:270px; background-image: url('../<?php echo $cover["image_path"] ?>'); background-size: cover; object-fit: cover;">
                                                    <div class="h-100 shadow-1-strong rounded" style="background-color: rgba(0, 0, 0, 0.6);">
                                                        <div class="position-absolute top-50 start-50 translate-middle text-white">
                                                            <span class="lead fw-normal"><?php echo $album["title"]; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <p class="lead fw-normal mb-0">Foto</p>
                                    <p class="mb-0"><a href="foto_saya.php" class="text-muted">Lihat semua</a></p>
                                </div>
                                <div class="row g-2">
                                    <?php
                                    // looping data photo dari tabel photos
                                    $i = 0;
                                    foreach ($photos as $photo) {
                                        if (++$i == 5) break;
                                    ?>
                                        <div class="col-lg-6 mb-2">
                                            <!-- link ke halaman lihat foto ditambah parameter id yang di ambil dari 'photo_id' -->
                                            <a href="../lihat_foto.php?id=<?php echo $photo["photo_id"]; ?>">
                                                <img src="../<?php echo $photo["image_path"]; ?>" alt="<?php echo $photo["title"]; ?>" class="w-100 shadow-1-strong rounded-3 bg-light" style="height:270px; object-fit: contain;">
                                            </a>
                                        </div>
                                    <?php } ?>
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