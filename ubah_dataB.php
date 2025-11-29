<?php
// Temporarily disabled session check for testing
// session_start();
// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

require("function.php");

// Ambil ID buku yang mau diubah
$id = $_GET['id'];

// Query data buku berdasarkan id
$buku = query("SELECT * FROM buku WHERE id_buku = $id")[0];

// Query semua kategori untuk dropdown
$kategori = query("SELECT * FROM kategori ORDER BY kategori ASC");

// Ketikan tombol submit diklik
if(isset($_POST['tombol_submit'])){
    $result = ubah_dataB($_POST);
    
    if($result > 0){
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    }else{
        echo "
            <script>
                alert('Data gagal diubah! Rows affected: $result');
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
    <title>Ubah Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container p-4">
    <h2 class="mb-3">Ubah Data Buku</h2>
    <a href="index.php" class="mb-3 d-block">← Kembali</a>

    <div class="col-md-6">
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $buku['id_buku'] ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Buku</label>
                <input type="text" name="judul" class="form-control" 
                       value="<?= $buku['judul'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Penulis</label>
                <input type="text" name="penulis" class="form-control" 
                       value="<?= $buku['penulis'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" 
                       value="<?= $buku['penerbit'] ?>" required>
            </div>
              <div class="mb-3">
                <label for="tanggal_input" class="form-label fw-bold">Tanggal Input</label>
                <input type="date" class="form-control" name="tanggal_input" id="tanggal_input" value="<?= ($buku['tanggal_input']) ?>" required />
            </div>                    
            <div class="mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach($kategori as $k): ?>
                        <option value="<?= $k['id_kategori'] ?>" 
                            <?= ($k['id_kategori'] == $buku['id_kategori']) ? "selected" : "" ?>>
                            <?= $k['kategori'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Stok</label>
                <input type="number" name="stok" class="form-control" 
                       value="<?= $buku['stok'] ?>" required>
            </div>

            <button type="submit" name="tombol_submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

        </form>
    </div>
</div>

</body>
</html>