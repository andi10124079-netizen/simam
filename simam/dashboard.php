<?php

session_start();
require_once "bahasa_helper.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$username = htmlspecialchars(
    $_SESSION["username"],
    ENT_QUOTES,
    "UTF-8"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SIMAM</title>
</head>
<body>

    <h1>Dashboard SIMAM</h1>

    <h1><?= htmlspecialchars(t("selamat_datang")) ?></h1>

<a href="mahasiswa/index.php">
    <?= htmlspecialchars(t("mahasiswa")) ?>
</a>

<a href="logout.php">
    <?= htmlspecialchars(t("logout")) ?>
</a>

</body>
</html>