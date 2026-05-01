<?php
include 'db.php';

$nama_produk = $_POST['nama_produk'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];

// Validasi: wajib upload gambar
if ($_FILES['gambar']['name'] == "") {
    echo "Gambar wajib diupload!";
    exit;
}

// Proses File Upload
$nama_file   = $_FILES['gambar']['name'];
$tmp_file    = $_FILES['gambar']['tmp_name'];
$folder      = "uploads/" . $nama_file;

// Pindahkan file ke folder uploads
if (move_uploaded_file($tmp_file, $folder)) {
    $sql = "INSERT INTO produk (nama_produk, harga, stok, gambar) VALUES ('$nama_produk', '$harga', '$stok', '$nama_file')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Kembali ke halaman utama jika sukses
    } else {
        echo "Gagal menyimpan ke database: " . mysqli_error($conn);
    }
} else {
    echo "Gagal mengupload gambar!";
}
?>