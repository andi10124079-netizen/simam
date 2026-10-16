<?php

if (!isset($_SESSION["bahasa"])) {
    $_SESSION["bahasa"] = "id";
}

$teks = [
    "id" => [
        "dashboard" => "Dashboard",
        "mahasiswa" => "Data Mahasiswa",
        "tambah" => "Tambah Mahasiswa",
        "logout" => "Keluar",
        "selamat_datang" => "Selamat datang",
        "nim" => "NIM",
        "nama" => "Nama Mahasiswa",
        "jurusan" => "Jurusan",
        "email" => "Email",
        "aksi" => "Aksi",
        "simpan" => "Simpan Data",
        "edit" => "Edit",
        "hapus" => "Hapus",
        "bahasa" => "Bahasa",
        "belum_ada" => "Belum ada data mahasiswa."
    ],
    "en" => [
        "dashboard" => "Dashboard",
        "mahasiswa" => "Student Data",
        "tambah" => "Add Student",
        "logout" => "Logout",
        "selamat_datang" => "Welcome",
        "nim" => "Student ID",
        "nama" => "Student Name",
        "jurusan" => "Department",
        "email" => "Email",
        "aksi" => "Actions",
        "simpan" => "Save Data",
        "edit" => "Edit",
        "hapus" => "Delete",
        "bahasa" => "Language",
        "belum_ada" => "No student data available."
    ]
];

function t($kunci) {
    global $teks;

    $bahasa = $_SESSION["bahasa"] ?? "id";

    return $teks[$bahasa][$kunci] ?? $kunci;
}