<?php
include 'db.php';

$id          = $_POST['id'];
$nama_produk = $_POST['nama_produk'];
$harga       = $_POST['harga'];
$stok        = $_POST['stok'];
$gambar_lama = $_POST['gambar_lama'];

$nama_file   = $_FILES['gambar']['name'];
$tmp_file    = $_FILES['gambar']['tmp_name'];

// Cek apakah user mengupload gambar baru
if ($nama_file != "") {
    $folder = "uploads/" . $nama_file;
    move_uploaded_file($tmp_file, $folder);
    
    // Hapus gambar lama dari folder
    if (file_exists("uploads/" . $gambar_lama)) {
        unlink("uploads/" . $gambar_lama);
    }
    
    $sql = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', gambar='$nama_file' WHERE id='$id'";
} else {
    // Jika gambar tidak diganti
    $sql = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok' WHERE id='$id'";
}

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>