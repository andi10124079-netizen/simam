<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}
require_once "../bahasa_helper.php";
require_once "../koneksi.php";

$nim = "";
$nama = "";
$jurusan = "";
$email = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jurusan = trim($_POST["jurusan"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nim === "" || $nama === "" || $jurusan === "" || $email === "") {
        $error = "Semua kolom wajib diisi.";

    } elseif (!preg_match('/^[A-Za-z0-9-]{3,20}$/', $nim)) {
        $error = "NIM harus 3-20 karakter dan hanya boleh berisi huruf, angka, atau tanda hubung.";

    } elseif (strlen($nama) > 100) {
        $error = "Nama maksimal 100 karakter.";

    } elseif (strlen($jurusan) > 100) {
        $error = "Jurusan maksimal 100 karakter.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";

    } else {

        try {
            $sql = "INSERT INTO mahasiswa (nim, nama, jurusan, email)
                    VALUES (:nim, :nama, :jurusan, :email)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "nim" => $nim,
                "nama" => $nama,
                "jurusan" => $jurusan,
                "email" => $email
            ]);

            header("Location: index.php?status=tambah_berhasil");
            exit;

        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {
                $error = "NIM tersebut sudah terdaftar. Gunakan NIM lain.";
            } else {
                $error = "Data gagal disimpan. Silakan coba kembali.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa - SIMAM</title>
</head>

<body>

<h1><?= htmlspecialchars(t("tambah")) ?></h1>

    <?php if ($error !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="tambah.php">

        <label><?= htmlspecialchars(t("nim")) ?></label>
<br>
        <input
            type="text"
            id="nim"
            name="nim"
            maxlength="20"
            value="<?= htmlspecialchars($nim, ENT_QUOTES, "UTF-8") ?>"
            required
        >

        <br><br>

        <label><?= htmlspecialchars(t("nama")) ?></label>
<br>
        <input
            type="text"
            id="nama"
            name="nama"
            maxlength="100"
            value="<?= htmlspecialchars($nama, ENT_QUOTES, "UTF-8") ?>"
            required
        >

        <br><br>

        <label><?= htmlspecialchars(t("jurusan")) ?></label>
<br>
        <input
            type="text"
            id="jurusan"
            name="jurusan"
            maxlength="100"
            value="<?= htmlspecialchars($jurusan, ENT_QUOTES, "UTF-8") ?>"
            required
        >

        <br><br>

        <label><?= htmlspecialchars(t("email")) ?></label>
<br>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
            required
        >

        <br><br>

       <button type="submit">
    <?= htmlspecialchars(t("simpan")) ?>
</button>

    </form>

    <br>

    <a href="index.php">Kembali ke Data Mahasiswa</a>

</body>
</html>