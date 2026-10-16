<?php

session_start();
require_once "../bahasa_helper.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id, nim, nama, jurusan, email
     FROM mahasiswa
     WHERE id = :id"
);

$stmt->execute(["id" => $id]);
$mhs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mhs) {
    header("Location: index.php");
    exit;
}

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

    } elseif (strlen($nama) > 100 || strlen($jurusan) > 100) {
        $error = "Nama dan jurusan maksimal 100 karakter.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";

    } else {

        try {
            $sql = "UPDATE mahasiswa
                    SET nim = :nim,
                        nama = :nama,
                        jurusan = :jurusan,
                        email = :email
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                "nim" => $nim,
                "nama" => $nama,
                "jurusan" => $jurusan,
                "email" => $email,
                "id" => $id
            ]);

            header("Location: index.php?status=edit_berhasil");
            exit;

        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {
                $error = "NIM sudah digunakan mahasiswa lain.";
            } else {
                $error = "Data gagal diperbarui. Silakan coba kembali.";
            }
        }
    }

    // Mempertahankan nilai input jika validasi gagal.
    $mhs["nim"] = $nim;
    $mhs["nama"] = $nama;
    $mhs["jurusan"] = $jurusan;
    $mhs["email"] = $email;
}

function aman($nilai) {
    return htmlspecialchars($nilai, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa - SIMAM</title>
</head>

<body>

    <h1>Edit Data Mahasiswa</h1>

    <?php if ($error !== ""): ?>
        <p style="color: red;"><?= aman($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= (int) $id ?>">

        <label for="nim">NIM:</label><br>
        <input
            type="text"
            id="nim"
            name="nim"
            maxlength="20"
            value="<?= aman($mhs["nim"]) ?>"
            required
        >

        <br><br>

        <label for="nama">Nama Mahasiswa:</label><br>
        <input
            type="text"
            id="nama"
            name="nama"
            maxlength="100"
            value="<?= aman($mhs["nama"]) ?>"
            required
        >

        <br><br>

        <label for="jurusan">Jurusan:</label><br>
        <input
            type="text"
            id="jurusan"
            name="jurusan"
            maxlength="100"
            value="<?= aman($mhs["jurusan"]) ?>"
            required
        >

        <br><br>

        <label for="email">Email:</label><br>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?= aman($mhs["email"]) ?>"
            required
        >

        <br><br>

        <button type="submit">Simpan Perubahan</button>

    </form>

    <br>

    <a href="index.php">Kembali ke Data Mahasiswa</a>

</body>
</html>