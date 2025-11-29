<?php
require("function.php");
session_start();

// Cek login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Ambil ID kategori
$id = $_GET['id'];

// Proses hapus
if (hapus_kategori($id) > 0) {
    echo "
        <script>
            alert('Kategori berhasil dihapus dari database!');
            document.location.href = 'index2.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Kategori gagal dihapus dari database!');
            document.location.href = 'index2.php';
        </script>
    ";
}
?>