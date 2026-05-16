<?php
session_start();

// Entry point: redirect berdasarkan status login
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: produk/index.php");
} else {
    header("Location: auth/login.php");
}
exit();
