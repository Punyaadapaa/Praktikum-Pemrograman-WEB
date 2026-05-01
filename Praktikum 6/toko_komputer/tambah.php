<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - SmartBuild</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Memanggil CSS Global -->
    <link rel="stylesheet" href="assets/style.css">
    
    <style>
        /* Animasi masuk khusus untuk form */
        .form-container {
            animation: slideDown 0.6s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Modifikasi warna fokus input */
        .form-control:focus {
            border-color: #868CFF;
            box-shadow: 0 0 0 0.25rem rgba(134, 140, 255, 0.25);
        }
        
        /* Styling tambahan untuk tombol batal */
        .btn-batal {
            background-color: #f8f9ff;
            color: #6c757d;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-batal:hover {
            background-color: #e2e8f0;
            color: #2b3674;
        }
    </style>
</head>
<body>

    <!-- Navbar Custom -->
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-box-seam me-2"></i>SmartBuild <span style="color: #FFD700;">Store</span>
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 form-container">
                
                <!-- Card Form -->
                <div class="card card-custom p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-block bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3">
                            <i class="bi bi-box2-heart-fill fs-2" style="color: #4318FF;"></i>
                        </div>
                        <h4 class="fw-bold" style="color: #2b3674;">Tambah Produk Baru</h4>
                        <p class="text-muted small">Lengkapi informasi di bawah ini untuk memperbarui katalog inventaris.</p>
                    </div>
                    
                    <form action="simpan.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Input Nama Produk dengan Floating Label -->
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_produk" class="form-control fw-bold" id="namaProduk" placeholder="Nama" required>
                            <label for="namaProduk" class="text-secondary"><i class="bi bi-tag-fill me-2"></i>Nama Produk</label>
                        </div>
                        
                        <div class="row">
                            <!-- Input Harga -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="harga" class="form-control fw-bold text-primary" id="hargaProduk" placeholder="Harga" required>
                                    <label for="hargaProduk" class="text-secondary"><i class="bi bi-cash-coin me-2"></i>Harga (Rp)</label>
                                </div>
                            </div>
                            <!-- Input Stok -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="stok" class="form-control fw-bold" id="stokProduk" placeholder="Stok" required>
                                    <label for="stokProduk" class="text-secondary"><i class="bi bi-boxes me-2"></i>Jumlah Stok</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Input File Upload -->
                        <div class="mb-4 mt-2">
                            <label class="form-label text-secondary fw-bold small"><i class="bi bi-image me-2"></i>Upload Gambar Produk</label>
                            <input type="file" name="gambar" class="form-control form-control-lg shadow-sm" accept="image/*" style="border-radius: 12px; font-size: 0.9rem;" required>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex flex-column gap-3 mt-4">
                            <button type="submit" class="btn btn-tambah w-100 py-2 shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan ke Database
                            </button>
                            <a href="index.php" class="btn btn-batal w-100 py-2">
                                <i class="bi bi-arrow-left-circle me-2"></i>Batal & Kembali
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</body>
</html>