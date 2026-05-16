<?php
// Mulai session dan cek autentikasi
session_start();
if (!isset($_SESSION['login'])) { header("Location: ../auth/login.php"); exit(); }

// Muat dependensi
include '../config/database.php';
include '../models/produk.php';

// Inisialisasi koneksi database dan ambil semua data produk
$db = new Database();
$conn = $db->getConnection();
$produk = new Produk($conn);
$data = $produk->tampilData();

// Ambil notifikasi dari session lalu hapus
$notif = $_SESSION['notif'] ?? '';
$notifType = $_SESSION['notif_type'] ?? 'success';
unset($_SESSION['notif'], $_SESSION['notif_type']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Toko Baju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="dashboard-page">

    <!-- Sidebar navigasi -->
    <aside class="sidebar glass-panel" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="fas fa-tshirt"></i></div>
            <h2>Toko Baju</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-link active"><i class="fas fa-box-open"></i> Produk</a>
            <a href="tambah.php" class="nav-link"><i class="fas fa-plus-circle"></i> Tambah</a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
            <a href="../auth/logout.php" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <main class="main-content">
        <!-- Topbar dengan greeting dan jam -->
        <header class="topbar">
            <button class="sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topbar-info">
                <span class="topbar-greeting">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</span>
                <h1><i class="fas fa-chart-line topbar-icon"></i> Dashboard Produk</h1>
            </div>
            <div class="topbar-right">
                <div class="live-clock glass-badge" id="liveClock"></div>
                <div class="glass-badge">
                    <i class="fas fa-cookie-bite"></i>
                    <?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : '-'; ?>
                </div>
            </div>
        </header>

        <!-- Kartu statistik ringkasan -->
        <div class="stats-row">
            <div class="glass-card stat-card">
                <div class="stat-icon icon-primary"><i class="fas fa-box"></i></div>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $data->num_rows; ?></span>
                    <span class="stat-label">Total Produk</span>
                </div>
            </div>
            <div class="glass-card stat-card">
                <div class="stat-icon icon-success"><i class="fas fa-tags"></i></div>
                <div class="stat-info">
                    <?php
                    // Hitung jumlah merk unik
                    $merkList = [];
                    $tmpData = $produk->tampilData();
                    while ($m = $tmpData->fetch_assoc()) $merkList[$m['merk']] = true;
                    $data->data_seek(0);
                    ?>
                    <span class="stat-value"><?php echo count($merkList); ?></span>
                    <span class="stat-label">Merk</span>
                </div>
            </div>
            <div class="glass-card stat-card">
                <div class="stat-icon icon-warning"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <span class="stat-value" id="clockValue">--:--:--</span>
                    <span class="stat-label">Waktu Saat Ini</span>
                </div>
            </div>
        </div>

        <!-- Notifikasi dari session -->
        <?php if ($notif): ?>
        <div class="alert alert-<?php echo $notifType; ?>" id="notif">
            <i class="fas fa-<?php echo $notifType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo htmlspecialchars($notif); ?>
            <button class="alert-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        </div>
        <?php endif; ?>

        <!-- Bar aksi dengan tombol tambah produk -->
        <div class="action-bar">
            <h2><i class="fas fa-list"></i> Daftar Produk</h2>
            <a href="tambah.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
        </div>

        <!-- Tabel daftar produk -->
        <div class="glass-card table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Baju</th>
                        <th>Merk</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($data->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>
                            <!-- Cek keberadaan file gambar sebelum ditampilkan -->
                            <?php if ($row['gambar'] && file_exists("../uploads/" . $row['gambar'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($row['gambar']); ?>" class="thumb" alt="gambar">
                            <?php else: ?>
                                <div class="thumb-placeholder"><i class="fas fa-image"></i></div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo htmlspecialchars($row['nama_baju']); ?></strong></td>
                        <td><span class="badge"><?php echo htmlspecialchars($row['merk']); ?></span></td>
                        <td><span class="badge badge-alt"><?php echo htmlspecialchars($row['ukuran']); ?></span></td>
                        <td class="text-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="action-cell">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada produk</p>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

    <script>
    // Fungsi jam real-time untuk topbar dan kartu statistik
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit', hour12: false});
        const date = now.toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'});
        document.getElementById('clockValue').textContent = time;
        document.getElementById('liveClock').innerHTML = '<i class="fas fa-calendar-alt"></i> ' + date;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Auto-dismiss notifikasi setelah 4 detik
    const n = document.getElementById('notif');
    if (n) setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 300); }, 4000);
    </script>
</body>
</html>