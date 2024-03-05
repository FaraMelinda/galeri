<?php
require_once("database.php");
require_once("auth.php");

$sql = "SELECT * FROM users";
$users = $db->prepare($sql);
$users->execute();

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data user</title>

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
                        <li><a class="dropdown-item" href="../users">Profil</a></li>
                        <li><a class="dropdown-item" href="../users/album_saya.php">Album saya</a></li>
                        <li><a class="dropdown-item" href="../users/foto_saya.php">Foto saya</a></li>
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

    <div class="container-fluid">
        <!-- table start -->
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Access level</th>
                    <th scope="col">Created at</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                <!-- looping semua data user dari tabel 'users' -->
                <?php $i = 0;
                foreach ($users as $user) {
                    $i++; ?>
                    <tr>
                        <td scope="col"><?php echo $i; ?></td>
                        <td scope="col"><?php echo $user["name"]; ?></td>
                        <td scope="col"><?php echo $user["username"]; ?></td>
                        <td scope="col"><?php echo $user["email"]; ?></td>
                        <td scope="col"><?php echo $user["access_level"]; ?></td>
                        <td scope="col"><?php echo $user["created_at"]; ?></td>
                        <!-- link ke halaman edit user ditambah parameter id yang diambil dari 'user_id' -->
                        <td scope="col"><a class="btn btn-outline-dark" href="edit_user.php?id=<?php echo $user["user_id"]; ?>"><i class="fa-solid fa-pen"></i> Edit</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- table end -->

        <!-- footer end -->

        <!-- link cdn bootstrap js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>