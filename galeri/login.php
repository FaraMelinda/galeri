<?php
require_once("database.php");

// jika ada request POST 'submit'
if (isset($_POST['submit'])) {

    // filter data yang diinputkan
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // menyiapkan query
    $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    // eksekusi query
    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if ($user) {
        // verifikasi password
        if (password_verify($password, $user["password"])) {
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman index
            header("Location: index.php");
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- link cdn bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light" style="height: 100vh;">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="bg-white w-100 p-4 shadow-sm rounded" style="max-width: 360px;">
            <form action="" method="POST">
                <h1 class="display-6 text-center mb-3">Login</h1>
                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-muted">/</span> Email Address</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-dark w-100 mb-3" name="submit">Login</button>
                <div class="row">
                    <div class="col-5">
                        <hr>
                    </div>
                    <div class="col-2">
                        <p class="text-center text-muted">OR</p>
                    </div>
                    <div class="col-5">
                        <hr>
                    </div>
                </div>
                <a href="registrasi.php" class="btn btn-outline-dark w-100">Register</a>
            </form>
        </div>
    </div>

    <!-- link cdn bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>