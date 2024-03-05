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
    ":photo_id" => $photo_id
);

// eksekusi query
$stmt->execute($params);

$photos = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":user_id" => $photos["user_id"]
);

// eksekusi query
$stmt->execute($params);

$author = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM likes WHERE photo_id=:photo_id";
$stmt = $db->prepare($sql);

$params = array(
    ":photo_id" => $photo_id
);

// eksekusi query
$stmt->execute($params);

$likes = $stmt->rowCount();

// menyiapkan query
$sql = "SELECT * FROM likes WHERE user_id=:user_id AND photo_id=:photo_id";
$stmt = $db->prepare($sql);

// bind parameter ke query
$params = array(
    ":user_id" => $user_id,
    ":photo_id" => $photo_id
);

// eksekusi query
$stmt->execute($params);

$liked = $stmt->fetch(PDO::FETCH_ASSOC);

// menyiapkan query
$sql = "SELECT * FROM comments";
$comments = $db->prepare($sql);

// eksekusi query
$comments->execute();

if (isset($_POST['like'])) {
    // menyiapkan query
    $sql = "INSERT INTO likes (user_id, photo_id) VALUES (:user_id, :photo_id)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":user_id" => $user_id,
        ":photo_id" => $photo_id
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    if ($saved) {
        header("Location: lihat_foto.php?id=" . $photo_id);
    }
}

if (isset($_POST['dislike'])) {
    // menyiapkan query
    $sql = "DELETE FROM likes WHERE like_id=:like_id";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":like_id" => $liked["like_id"],
    );

    // eksekusi query
    $stmt->execute($params);

    // alihkan ke halaman lihat foto ditambah parameter id
    header("Location: lihat_foto.php?id=" . $photo_id);
}

if (isset($_POST['comment'])) {
    // filter data yang diinputkan
    $commentText = filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_STRING);

    // menyiapkan query
    $sql = "INSERT INTO comments (user_id, photo_id, comment_text) VALUES (:user_id, :photo_id, :comment_text)";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":user_id" => $user_id,
        ":photo_id" => $photo_id,
        ":comment_text" => $commentText
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query berhasil, maka refresh halaman
    if ($saved) {
        header("Location: lihat_foto.php?id=" . $photo_id);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- mencetak judul photo -->
    <title><?php echo $photos["title"]; ?></title>

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

                    <!-- jika user_id foto sama dengan user_id user saat ini munculkan tombol Edit foto -->
                    <?php if ($photos["user_id"] == $user_id) { ?>
                        <div class="text-end">
                            <!-- link ke halaman edit foto ditambah parameter id yang di ambil dari 'photo_id' -->
                            <a href="users/edit_foto.php?id=<?php echo $photo_id; ?>" class="btn btn-outline-dark mb-2" data-mdb-ripple-color="dark" style="z-index: 1;">
                                <i class="fa-solid fa-pen"></i> Edit foto
                            </a>
                        </div>
                    <?php } ?>
                    <div class="card border-0">
                        <!-- mencetak url gambar dari data row photo -->
                        <img src="<?php echo $photos["image_path"]; ?>" alt="<?php echo $photos["title"]; ?>" class="w-100 shadow-1-strong rounded-top bg-secondary" style="height:360px; object-fit: contain;">
                        <div class="p-4 text-black bg-light">
                            <div class="d-flex justify-content-between py-1">
                                <div>
                                    <!-- mencetak judul foto -->
                                    <p class="mb-1 h5"><?php echo $photos["title"]; ?></p>
                                    <!-- mencetak username pembuat foto -->
                                    <p class="small text-muted mb-0">@<?php echo $author["username"] ?></p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <!-- mencetak jumlah link foto -->
                                        <p class="mb-1 h5 text-center"><?php echo $likes; ?></p>
                                        <p class="small text-muted mb-0">Suka</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <!-- mencetak deskripsi foto -->
                                <p><?php echo $photos["description"] ?></p>
                            </div>
                        </div>
                        <hr>
                        <form action="" method="POST">
                            <div class="row mb-4">
                                <div class="col">
                                    <!-- jika foto belum di like oleh user yang sedang login maka munculkan tombol 'Suka' jika sudah munculkan tombol 'Batal suka' -->
                                    <?php if ($liked !== false) { ?>
                                        <button type="submit" class="btn btn-dark w-100" data-mdb-ripple-color="dark" style="z-index: 1;" name="dislike">
                                            <i class="fa-solid fa-thumbs-down"></i> Batal suka
                                        </button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-outline-dark w-100" data-mdb-ripple-color="dark" style="z-index: 1;" name="like">
                                            <i class="fa-solid fa-thumbs-up"></i> Suka
                                        </button>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <a href="#commentText" class="btn btn-outline-dark w-100" data-mdb-ripple-color="dark" style="z-index: 1;" name="comment">
                                        <i class="fa-solid fa-comment"></i> Komentari
                                    </a>
                                </div>
                            </div>
                        </form>
                        <?php
                        // looping data dari tabel comments
                        foreach ($comments as $comment) {
                            // menyiapkan query
                            $sql = "SELECT * FROM users WHERE user_id=:user_id";
                            $stmt = $db->prepare($sql);

                            // bind parameter ke query
                            $params = array(
                                ":user_id" => $comment["user_id"]
                            );

                            // eksekusi query
                            $stmt->execute($params);

                            $comment_author = $stmt->fetch(PDO::FETCH_ASSOC);

                            // jika photo_id comment sama dengan photo_id saat ini maka munculkan komentar
                            if ($comment["photo_id"] == $photo_id) { ?>
                                <div class="row m-2">
                                    <div class="col-2">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo $comment_author["name"]; ?>" class="img-fluid" alt="<?php echo $comment_author["name"]; ?>">
                                        <p class="small mt-1"><?php echo $comment_author["name"]; ?></p>
                                    </div>
                                    <div class="col-10">
                                        <p><?php echo $comment["comment_text"] ?></p>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                        <form action="" method="POST">
                            <div class="my-3">
                                <textarea class="form-control" rows="3" placeholder="Tulis komentar..." id="commentText" name="commentText"></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-dark w-100" name="comment">Kirim</button>
                            </div>
                        </form>
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