<?php
// Mulai session dan muat dependensi
session_start();
include '../config/database.php';
include '../models/produk.php';

// Validasi parameter id dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: index.php"); exit(); }

// Inisialisasi koneksi database dan model
$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);
$id = (int) $_GET['id'];

// Ambil data produk untuk menghapus file gambar terkait
$data = $produk->getById($id);
if ($data->num_rows > 0) {
    $row = $data->fetch_assoc();
    $uploadDir = dirname(__DIR__) . '/uploads/';
    // Hapus file gambar dari server jika ada
    if ($row['gambar'] && file_exists($uploadDir . $row['gambar'])) {
        unlink($uploadDir . $row['gambar']);
    }
}

// Hapus data produk dari database dan set notifikasi
if ($produk->hapusData($id)) {
    $_SESSION['notif'] = 'Produk berhasil dihapus!';
    $_SESSION['notif_type'] = 'success';
} else {
    $_SESSION['notif'] = 'Gagal menghapus produk!';
    $_SESSION['notif_type'] = 'error';
}

// Redirect kembali ke halaman daftar produk
header("Location: index.php");
exit();
