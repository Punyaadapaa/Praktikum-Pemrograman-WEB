<?php
include 'db.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Edit Produk</h4>
            </div>
            <div class="card-body">
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $row['gambar']; ?>">
                    
                    <div class="mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($row['nama_produk']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Gambar Baru (Abaikan jika tidak ingin ganti)</label>
                        <br>
                        <img src="uploads/<?= $row['gambar']; ?>" width="100" class="mb-2 rounded">
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Data</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>