<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuild Inventory</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Memanggil file CSS dari folder assets -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-box-seam me-2"></i>SmartBuild <span style="color: #FFD700;">Store</span>
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        
        <!-- Header & Search Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-0">Inventaris Produk</h3>
            </div>
            
            <!-- Input Pencarian JS -->
            <div>
                <input type="text" id="searchProduct" class="search-box" placeholder="🔍 Cari nama produk...">
            </div>

            <a href="tambah.php" class="btn btn-tambah">
                <i class="bi bi-plus-lg me-2"></i>Tambah Baru
            </a>
        </div>
        
        <!-- Tabel Produk -->
        <div class="card card-custom p-3">
            <div class="table-responsive">
                <table class="table align-middle" id="productTable">
                    <thead class="text-secondary">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Gambar</th>
                            <th width="35%">Nama Produk</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Stok</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td class="fw-bold text-muted"><?= $no++; ?></td>
                            <td>
                                <?php if ($row['gambar'] && file_exists("uploads/" . $row['gambar'])): ?>
                                    <img src="uploads/<?= $row['gambar']; ?>" class="product-img">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?= htmlspecialchars($row['nama_produk']); ?></td>
                            <td class="text-primary fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <!-- Warna stok berubah jika kurang dari 5 -->
                                <span class="badge bg-<?= $row['stok'] <= 5 ? 'danger' : 'success' ?> rounded-pill px-3 py-2">
                                    <?= $row['stok']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary rounded-circle p-2 mx-1" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger rounded-circle p-2 mx-1" onclick="return confirm('Hapus <?= $row['nama_produk']; ?>?');" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Memanggil file JavaScript dari folder assets -->
    <script src="assets/script.js"></script>
</body>
</html>