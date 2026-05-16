<?php
// Kelas model untuk operasi CRUD tabel produk
class Produk {
    private $conn;

    // Simpan koneksi database dari parameter
    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil semua data produk, diurutkan dari terbaru
    public function tampilData() {
        return $this->conn->query("SELECT * FROM produk ORDER BY id DESC");
    }

    // Mengambil satu produk berdasarkan id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Menambahkan produk baru ke database
    public function tambahData($nama_baju, $merk, $ukuran, $harga, $gambar) {
        $stmt = $this->conn->prepare("INSERT INTO produk (nama_baju, merk, ukuran, harga, gambar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nama_baju, $merk, $ukuran, $harga, $gambar);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Memperbarui data produk, gambar diupdate hanya jika ada file baru
    public function updateData($id, $nama_baju, $merk, $ukuran, $harga, $gambar = null) {
        if ($gambar) {
            $stmt = $this->conn->prepare("UPDATE produk SET nama_baju=?, merk=?, ukuran=?, harga=?, gambar=? WHERE id=?");
            $stmt->bind_param("sssisi", $nama_baju, $merk, $ukuran, $harga, $gambar, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE produk SET nama_baju=?, merk=?, ukuran=?, harga=? WHERE id=?");
            $stmt->bind_param("sssii", $nama_baju, $merk, $ukuran, $harga, $id);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Menghapus produk berdasarkan id
    public function hapusData($id) {
        $stmt = $this->conn->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}