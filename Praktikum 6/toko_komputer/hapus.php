<?php
include 'db.php';

$id = $_GET['id'];

// Ambil nama file gambar dari database untuk dihapus
$query = mysqli_query($conn, "SELECT gambar FROM produk WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if (file_exists("uploads/" . $row['gambar'])) {
    unlink("uploads/" . $row['gambar']); // Menghapus file fisik gambar
}

// Hapus data dari database
$sql = "DELETE FROM produk WHERE id='$id'";
if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>