<?php
// Kelas untuk mengelola koneksi ke database MySQL
class Database {
    // Konfigurasi koneksi database
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "toko_baju";
    public $conn;

    // Membuat dan mengembalikan koneksi mysqli
    public function getConnection() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
        // Set charset untuk mendukung karakter unicode
        $this->conn->set_charset("utf8mb4");
        return $this->conn;
    }
}