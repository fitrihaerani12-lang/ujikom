<?php
require("function.php");
session_start();

// Cek login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Pagination
$jumlahDataPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM kategori"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Tampilkan kategori berdasarkan tanggal_input terbaru
$kategori = query("
    SELECT * FROM kategori
    ORDER BY tanggal_input DESC
    LIMIT $awalData, $jumlahDataPerHalaman
");

// Search
if (isset($_POST['tombol_search'])) {
    $keyword = $_POST['keyword'];
    $kategori = query("
        SELECT * FROM kategori 
        WHERE kategori LIKE '%$keyword%'
        ORDER BY tanggal_input DESC
    ");
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SIMBS | Data Kategori</title>

    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <!-- NAVBAR -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle">
                            <span class="d-none d-md-inline">Heyra’s Library</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <img src="dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow">
                                <p>HEYRA - Web Developer</p>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <!-- SIDEBAR -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <img src="dist/assets/img/AdminLTELogo.png" class="brand-image opacity-75 shadow">
                    <span class="brand-text fw-light">SIMBS</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Data Master<i class="nav-arrow bi bi-chevron-right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Data Buku</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index2.php" class="nav-link active">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Data Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-header">AUTENTIKASI</li>

                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Sign Out</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <h1>Hallo, Selamat datang <?= $_SESSION["username"] ?></h1>

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Kategori</li>
                    </ol>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="app-content">
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="tambah_kategori.php" class="btn btn-primary btn-sm">Tambah Kategori</a>

                        <!-- Pagination -->
                        <ul class="pagination">
                            <?php if ($halamanAktif > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                <li class="page-item <?= ($i == $halamanAktif) ? 'active' : '' ?>">
                                    <a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($halamanAktif < $jumlahHalaman): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <!-- Search -->
                        <form method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" placeholder="Cari kategori...">
                                <button class="btn btn-primary" name="tombol_search">Cari</button>
                            </div>
                        </form>
                    </div>

                    <!-- TABLE -->
                    <table class="table table-striped table-hover mt-3">
                        <tr>
                            <th>No</th>
                            <th>ID Kategori</th>
                            <th>Kategori</th>
                            <th>Tanggal Input</th>
                            <th>Aksi</th>
                        </tr>

                        <?php $no = 1 + $awalData; ?>
                        <?php foreach ($kategori as $data): ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $data['id_kategori'] ?></td>
                                <td><?= $data['kategori'] ?></td>
                                <td><?= $data['tanggal_input'] ?></td>
                                <td>
                                    <a href="ubah_data.php?id=<?= $data['id_kategori'] ?>" class="btn btn-success btn-sm">Edit</a>
                                    <a href="hapus_data.php?id=<?= $data['id_kategori'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    </table>

                </div>
            </div>
        </main>

        <footer class="app-footer text-center">
            <strong>Copyright &copy; 2025.</strong>
        </footer>

    </div>

    <script src="dist/js/adminlte.js"></script>
</body>

</html>
