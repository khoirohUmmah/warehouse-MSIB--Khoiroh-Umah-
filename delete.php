<?php
require_once 'database.php';
require_once 'Gudang.php';

// Koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Membuat objek Gudang
$gudang = new Gudang($db);

// Mendapatkan ID gudang dari URL
$gudang->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID tidak ditemukan.');

if (isset($_GET['action']) && $_GET['action'] == 'deactivate') {
    // Mengubah status gudang menjadi "tidak aktif"
    $gudang->status = 'tidak_aktif';
    if ($gudang->changeStatus()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah status gudang.";
    }
} else {
    // Menghapus gudang
    if ($gudang->delete()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menghapus gudang.";
    }
}
?>
