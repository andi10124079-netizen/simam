<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}
require_once "../koneksi.php";
require_once "../bahasa_helper.php";

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}



$sql = "SELECT id, nim, nama, jurusan, email, created_at
        FROM mahasiswa
        ORDER BY id DESC";

$stmt = $pdo->query($sql);
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - SIMAM</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    
    <h1><?= htmlspecialchars(t("mahasiswa"), ENT_QUOTES, "UTF-8") ?></h1>
   <?php
$status = $_GET["status"] ?? "";

if ($status === "tambah_berhasil") {
    echo '<p style="color: green;">Data mahasiswa berhasil ditambahkan!</p>';
} elseif ($status === "edit_berhasil") {
    echo '<p style="color: green;">Data mahasiswa berhasil diperbarui!</p>';
} elseif ($status === "hapus_berhasil") {
    echo '<p style="color: green;">Data mahasiswa berhasil dihapus!</p>';
}
?>

    <p>
        Selamat datang,
        <strong>
            <?= htmlspecialchars(
                $_SESSION["username"],
                ENT_QUOTES,
                "UTF-8"
            ) ?>
        </strong>
    </p>

    <a href="../dashboard.php">Kembali ke Dashboard</a>
    |
    <a href="tambah.php" class="button button-primary">
    + Tambah Mahasiswa
</a>
    |
    <a href="../logout.php">Logout</a>

    <br><br>

    <div class="table-wrapper">
<table>
</div>
        <thead>
            <tr>
                <th>No.</th>
                <th><?= htmlspecialchars(t("nim"), ENT_QUOTES, "UTF-8") ?></th>
                <th><?= htmlspecialchars(t("nama"), ENT_QUOTES, "UTF-8") ?></th>
                <th><?= htmlspecialchars(t("jurusan"), ENT_QUOTES, "UTF-8") ?></th>
                <th><?= htmlspecialchars(t("email"), ENT_QUOTES, "UTF-8") ?></th>
                <th><?= htmlspecialchars(t("Waktu Dibuat"), ENT_QUOTES, "UTF-8") ?></th>
                <th><?= htmlspecialchars(t("aksi"), ENT_QUOTES, "UTF-8") ?></th>
            </tr>
        </thead>

        <tbody>

            <?php if (count($mahasiswa) > 0): ?>

                <?php foreach ($mahasiswa as $index => $mhs): ?>

                    <tr>
                        <td><?= $index + 1 ?></td>

                        <td>
                            <?= htmlspecialchars(
                                $mhs["nim"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $mhs["nama"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $mhs["jurusan"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $mhs["email"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $mhs["created_at"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>

                        <td>
                            <a href="edit.php?id=<?= (int) $mhs["id"] ?>">Edit</a>

|

<form method="POST" action="hapus.php" style="display: inline;"
      onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');">

    <input
        type="hidden"
        name="id"
        value="<?= (int) $mhs["id"] ?>"
    >

    <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($_SESSION["csrf_token"], ENT_QUOTES, "UTF-8") ?>"
    >

    <button type="submit">Hapus</button>

</form>



                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="7">
                        Belum ada data mahasiswa.
                    </td>
                </tr>

            <?php endif; ?>

            <form method="POST" action="../bahasa.php">

    <label for="bahasa">
        <?= htmlspecialchars(t("bahasa"), ENT_QUOTES, "UTF-8") ?>:
    </label>

    <select name="bahasa" id="bahasa">
        <option value="id"
            <?= ($_SESSION["bahasa"] ?? "id") === "id" ? "selected" : "" ?>>
            Bahasa Indonesia
        </option>

        <option value="en"
            <?= ($_SESSION["bahasa"] ?? "id") === "en" ? "selected" : "" ?>>
            English
        </option>
    </select>

    <input type="hidden" name="kembali" value="mahasiswa/index.php">

    <button type="submit">Pilih</button>

</form>
        </tbody>

    </table>

</body>
</html>