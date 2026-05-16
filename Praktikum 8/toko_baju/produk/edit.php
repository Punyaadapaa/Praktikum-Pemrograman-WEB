<?php
// Mulai session dan cek autentikasi
session_start();
if (!isset($_SESSION['login'])) { header("Location: ../auth/login.php"); exit(); }

// Muat dependensi
include '../config/database.php';
include '../models/produk.php';

// Inisialisasi koneksi database dan model
$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);

// Validasi parameter id dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: index.php"); exit(); }

// Ambil data produk berdasarkan id
$data = $produk->getById((int)$_GET['id']);
if ($data->num_rows === 0) {
    $_SESSION['notif'] = 'Produk tidak ditemukan!';
    $_SESSION['notif_type'] = 'error';
    header("Location: index.php");
    exit();
}
$row = $data->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk — Toko Baju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="form-page">
    <div class="form-container">
        <div class="glass-card form-card">
            <!-- Header halaman form edit -->
            <div class="form-header">
                <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <h1><i class="fas fa-edit"></i> Edit Produk</h1>
                </div>
            </div>
            <!-- Form edit dengan data produk yang sudah terisi -->
            <form action="update.php" method="POST" enctype="multipart/form-data" class="product-form">
                <!-- Hidden input untuk id dan nama gambar lama -->
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($row['gambar']); ?>">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="nama_baju"><i class="fas fa-tshirt"></i> Nama Baju</label>
                        <input type="text" id="nama_baju" name="nama_baju" value="<?php echo htmlspecialchars($row['nama_baju']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="merk"><i class="fas fa-tag"></i> Merk</label>
                        <input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars($row['merk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ukuran"><i class="fas fa-ruler"></i> Ukuran</label>
                        <select id="ukuran" name="ukuran" required>
                            <option value="" disabled>Pilih Ukuran</option>
                            <!-- Loop opsi ukuran dengan auto-select berdasarkan data -->
                            <?php foreach (['XS','S','M','L','XL','XXL','All Size'] as $s): ?>
                            <option value="<?php echo $s; ?>" <?php echo $row['ukuran']===$s?'selected':''; ?>><?php echo $s; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label for="harga"><i class="fas fa-money-bill-wave"></i> Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" value="<?php echo $row['harga']; ?>" min="0" required>
                    </div>
                    <!-- Area upload gambar dengan preview gambar saat ini -->
                    <div class="form-group full-width">
                        <label for="gambar"><i class="fas fa-image"></i> Gambar Produk</label>
                        <div class="file-upload" id="dropZone">
                            <input type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImg(this)">
                            <?php if ($row['gambar'] && file_exists("../uploads/".$row['gambar'])): ?>
                                <!-- Tampilkan gambar yang sudah ada -->
                                <img id="preview" class="img-preview" src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" alt="current">
                                <div class="file-upload-label" id="uploadLabel" style="display:none">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Klik untuk ganti gambar</span>
                                </div>
                            <?php else: ?>
                                <!-- Placeholder jika belum ada gambar -->
                                <div class="file-upload-label" id="uploadLabel">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Klik untuk upload gambar</span>
                                    <small>JPG, PNG, GIF (Maks 2MB)</small>
                                </div>
                                <img id="preview" class="img-preview" style="display:none" alt="preview">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Tombol aksi form -->
                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    // Preview gambar baru sebelum diupload
    function previewImg(input) {
        const preview = document.getElementById('preview');
        const label = document.getElementById('uploadLabel');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; if(label) label.style.display = 'none'; };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>