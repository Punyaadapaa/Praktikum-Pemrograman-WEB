<?php
// Mulai session dan muat dependensi
session_start();
include '../config/database.php';
include '../models/produk.php';

// Tolak akses jika bukan metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: index.php"); exit(); }

// Inisialisasi koneksi database dan model
$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);

// Ambil data dari form
$id = (int) $_POST['id'];
$nama_baju = trim($_POST['nama_baju']);
$merk = trim($_POST['merk']);
$ukuran = trim($_POST['ukuran']);
$harga = (int) $_POST['harga'];
$gambar = null;

// Tentukan direktori upload
$uploadDir = dirname(__DIR__) . '/uploads/';

// Buat folder uploads jika belum ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Proses upload gambar baru jika ada
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK && $_FILES['gambar']['size'] > 0) {
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Validasi ekstensi dan ukuran file (maks 5MB)
    if (in_array($ext, $allowed) && $_FILES['gambar']['size'] <= 5 * 1024 * 1024) {
        $gambar = time() . '_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar)) {
            // Hapus gambar lama dari server
            $gambar_lama = $_POST['gambar_lama'] ?? '';
            if ($gambar_lama && file_exists($uploadDir . $gambar_lama)) {
                unlink($uploadDir . $gambar_lama);
            }
        } else {
            $gambar = null;
        }
    }
}

// Simpan perubahan ke database dan set notifikasi
if ($produk->updateData($id, $nama_baju, $merk, $ukuran, $harga, $gambar)) {
    $_SESSION['notif'] = 'Produk berhasil diperbarui!';
    $_SESSION['notif_type'] = 'success';
} else {
    $_SESSION['notif'] = 'Gagal memperbarui produk!';
    $_SESSION['notif_type'] = 'error';
}

// Redirect kembali ke halaman daftar produk
header("Location: index.php");
exit();
