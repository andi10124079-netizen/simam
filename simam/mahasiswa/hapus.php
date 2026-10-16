<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$token = $_POST["csrf_token"] ?? "";

if (
    !$id ||
    $id < 1 ||
    !is_string($token) ||
    !isset($_SESSION["csrf_token"]) ||
    !hash_equals($_SESSION["csrf_token"], $token)
) {
    http_response_code(400);
    exit("Permintaan tidak valid. Silakan kembali dan coba lagi.");
}

$stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
$stmt->execute(["id" => $id]);

header("Location: index.php?status=hapus_berhasil");
exit;