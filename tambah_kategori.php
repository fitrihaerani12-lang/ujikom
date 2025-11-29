<?php
require("function.php");
session_start();

// Cek login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Proses tambah kategori
if (isset($_POST['tombol_submit'])) {
    if (tambah_kategori($_POST) > 0) {
        echo "
            <script>
                alert('Kategori berhasil ditambahkan!');
                document.location.href = 'index2.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Kategori gagal ditambahkan!');
                document.location.href = 'index2.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Sistem Input Kategori</a>
        </div>
    </nav>

    <!-- CONTENT -->
    <section class="p-3">
        <div class="container">

            <h2 class="mb-3">Tambah Kategori Baru</h2>
            <a href="index2.php" class="mb-3 d-block">← Kembali ke Data Kategori</a>

            <div class="col-md-6">
                <form action="" method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Masukkan nama kategori..."
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_input" class="form-label fw-bold">Tanggal Input</label>
                        <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" value="<?= ($kategori['tanggal_input']) ?>" required />
                    </div>  
                    <button type="submit" name="tombol_submit" class="btn btn-primary">
                        Simpan Kategori
                    </button>

                </form>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>