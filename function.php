<?php
$conn = mysqli_connect("localhost", "root", "", "simbs");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getKategori()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM kategori");
}

// fungsi ubah data
function ubah_dataB($data)
{
    global $conn;

    $id = $data['id'];
    $judul = mysqli_real_escape_string($conn, $data['judul']);
    $penulis = mysqli_real_escape_string($conn, $data['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $data['penerbit']);
    $tanggal_input = $data['tanggal_input'];
    $id_kategori = $data['id_kategori'];
    $stok = $data['stok'];

    $query = "UPDATE buku SET
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tanggal_input = '$tanggal_input',
                id_kategori = '$id_kategori',
                stok = '$stok'
              WHERE id_buku = $id
              ";

    // $result = mysqli_query($conn, $query);
    // if (!$result) {
    //     die("Update Error: " . mysqli_error($conn));
    // }
    // return mysqli_affected_rows($conn);
     $result = mysqli_query($conn, $query);
     
     return mysqli_affected_rows($conn);
}

// Fungsi tambah data
function tambah_data($data)
{
    global $conn;

    $judul = mysqli_real_escape_string($conn, $data['judul']);
    $penulis = mysqli_real_escape_string($conn, $data['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $data['penerbit']);
    $tanggal_input = $data['tanggal_input'];
    $id_kategori = $data['id_kategori'];
    $stok = $data['stok'];

    $query = "INSERT INTO buku (judul, penulis, penerbit, tanggal_input, id_kategori, stok)
              VALUES ('$judul', '$penulis', '$penerbit', '$tanggal_input', '$id_kategori', '$stok')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi search data
function search_data($keyword)
{
    global $conn;

    $query = "SELECT buku.*, kategori.kategori 
              FROM buku
              JOIN kategori ON buku.id_kategori = kategori.id_kategori
              WHERE buku.judul LIKE '%$keyword%' 
              OR buku.penulis LIKE '%$keyword%' 
              OR buku.penerbit LIKE '%$keyword%'";

    return query($query);
}

// Fungsi hapus data
function hapus_dataB($id)
{
    global $conn;

    $query = "DELETE FROM buku WHERE id_buku = $id";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Delete Error: " . mysqli_error($conn));
    }
    return mysqli_affected_rows($conn);
}

// Fungsi login
function login($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = $data['password'];

    // Cek panjang password
    if (strlen($password) < 8) {
        return "Password minimal 8 karakter!";
    }

    // Cari user berdasarkan username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Cek apakah username ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];

            return 1; // Login berhasil
        }
    }

    return "Username atau password salah!"; // Login gagal
}

// Fungsi register
function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = mysqli_real_escape_string($conn, $data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        return "Username sudah terdaftar!";
    }

    // Cek panjang password
    if (strlen($password) < 8) {
        return "Password minimal 8 karakter!";
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$email', '$password')");

    return mysqli_affected_rows($conn);
}

// Fungsi tambah kategori
function tambah_kategori($data)
{
    global $conn;

    $kategori      = mysqli_real_escape_string($conn, $data['kategori']);
    $tanggal_input = $data['tanggal_input']; 

    $query = "INSERT INTO kategori (kategori, tanggal_input) 
              VALUES ('$kategori', '$tanggal_input')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Fungsi ubah kategori
function ubah_kategori($data)
{
    global $conn;

    $id_kategori   = $data['id_kategori'];
    $kategori      = mysqli_real_escape_string($conn, $data['kategori']);
    $tanggal_input = $data['tanggal_input']; // tidak perlu escape, format date sudah aman

    $query = "UPDATE kategori SET 
                kategori = '$kategori',
                tanggal_input = '$tanggal_input'
              WHERE id_kategori = $id_kategori";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Update Error: " . mysqli_error($conn));
    }

    return mysqli_affected_rows($conn);
}

// Fungsi hapus kategori
function hapus_kategori($id)
{
    global $conn;

    $query = "DELETE FROM kategori WHERE id_kategori = $id";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Delete Error: " . mysqli_error($conn));
    }
    return mysqli_affected_rows($conn);
}
?>