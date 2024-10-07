<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);
$gudang->id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID tidak ditemukan.');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'activate') {
        $gudang->status = 'aktif';
    } elseif ($_GET['action'] == 'deactivate') {
        $gudang->status = 'tidak_aktif';
    }

    if ($gudang->changeStatus()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah status gudang.";
    }
} else {
    echo "Aksi tidak valid.";
}

?>
