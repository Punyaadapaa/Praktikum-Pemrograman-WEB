<?php
// Mulai session
session_start();

// Redirect user yang sudah login ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: ../produk/index.php");
    exit();
}

// Inisialisasi variabel error
$error = '';

// Proses login ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/database.php';

    // Buat koneksi ke database
    $db = new Database();
    $conn = $db->getConnection();

    // Ambil dan hash input user
    $username = trim($_POST['username']);
    $password = MD5($_POST['password']);

    // Cek kredensial di database dengan prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login berhasil: set session dan cookie
        $data = $result->fetch_assoc();
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        setcookie("username", $data['username'], time() + 3600, "/");
        header("Location: ../produk/index.php");
        exit();
    } else {
        // Login gagal: tampilkan pesan error
        $error = "Username atau password salah!";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Toko Baju</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="glass-card login-card">
            <!-- Branding aplikasi -->
            <div class="login-brand">
                <div class="brand-icon"><i class="fas fa-tshirt"></i></div>
                <h1>Toko Baju</h1>
                <p>Masuk ke panel admin</p>
            </div>

            <!-- Tampilkan pesan error jika login gagal -->
            <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <!-- Form login -->
            <form method="POST">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-pw" onclick="let p=document.getElementById('password'),i=document.getElementById('eyeIcon');p.type=p.type==='password'?'text':'password';i.classList.toggle('fa-eye');i.classList.toggle('fa-eye-slash')">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <!-- Info kredensial default -->
            <div class="login-footer">
                <small><i class="fas fa-info-circle"></i> Default: admin / admin123</small>
            </div>
        </div>
    </div>
</body>
</html>