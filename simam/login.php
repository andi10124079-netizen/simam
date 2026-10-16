<?php

session_start();
require_once "koneksi.php";
require_once "bahasa_helper.php";
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $error = "Username dan password wajib diisi.";
    } else {
        $sql = "SELECT id, username, password
                FROM users
                WHERE username = :username";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "username" => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIMAM</title>
</head>
<body>

    <h1>Login SIMAM</h1>
    <p>Sistem Informasi Manajemen Data Mahasiswa</p>

    <?php if ($error !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <label for="username">Username:</label><br>
        <input
            type="text"
            id="username"
            name="username"
            required
        >

        <br><br>

        <label for="password">Password:</label><br>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <br><br>

        <button type="submit">Login</button>

    </form>

</body>
</html>