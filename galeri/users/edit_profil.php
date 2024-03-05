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
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // menyiapkan query
    $sql = "UPDATE users SET name=:name, username=:username, email=:email, password=:password WHERE user_id=:user_id";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":name" => $name,
        ":username" => $username,
        ":email" => $email,
        ":password" => $password,
        ":user_id" => $user_id
    );

    // eksekusi query untuk menyimpan ke database
    $updated = $stmt->execute($params);

    // jika query submit berhasil, maka alihkan ke halaman profil
    if ($updated) header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit profil</title>

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
                        <div class="rounded-top text-white d-flex flex-row bg-secondary" style="height:200px;">
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <!-- mencetak nama user dari data users -->
                                <img src="https://ui-avatars.com/api/?name=<?php echo $users["name"]; ?>" alt="<?php echo $users["name"]; ?>" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                                <a href="edit_profil.php?id=<?php echo $user_id; ?>" class="btn btn-dark disabled" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    <i class="fa-solid fa-pen"></i> Edit profil
                                </a>
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <!-- mencetak nama dari data users -->
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
                        <div class="card-body p-4 text-black">
                            <form action="" method="POST">
                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $users['name'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $users['username'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $users['email'] ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="mb-3 row row justify-content-end">
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