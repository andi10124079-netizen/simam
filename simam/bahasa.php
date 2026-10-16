<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $bahasa = $_POST["bahasa"] ?? "";

    if (in_array($bahasa, ["id", "en"], true)) {
        $_SESSION["bahasa"] = $bahasa;
    }
}

$kembali = $_POST["kembali"] ?? "dashboard.php";

$halamanDiizinkan = [
    "dashboard.php",
    "mahasiswa/index.php",
    "mahasiswa/tambah.php",
    "mahasiswa/edit.php"
];

if (!in_array($kembali, $halamanDiizinkan, true)) {
    $kembali = "dashboard.php";
}

header("Location: " . $kembali);
exit;