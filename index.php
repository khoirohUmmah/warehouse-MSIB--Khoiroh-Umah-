<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

// Cek apakah ada input pencarian
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $gudang->search($search_query); // Panggil fungsi search
$num = $stmt->rowCount();

$title = "Daftar Gudang";
ob_start();
?>

<h1>Daftar Gudang</h1>

<!-- Form Pencarian -->
<form action="index.php" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, lokasi, atau status..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button class="btn btn-outline-primary" type="submit">Cari</button>
    </div>
</form>

<a href="create.php" class="btn btn-primary mb-3">Tambah Gudang</a>

<?php
if ($num > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ID</th><th>Nama</th><th>Lokasi</th><th>Kapasitas</th><th>Status</th><th>Jam Buka</th><th>Jam Tutup</th><th>Aksi</th></tr></thead>";
    echo "<tbody>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$location}</td>";
        echo "<td>{$capacity}</td>";
        echo "<td>{$status}</td>";
        echo "<td>{$opening_hour}</td>";
        echo "<td>{$closing_hour}</td>";
        echo "<td>
                <a href='edit.php?id={$id}' class='btn btn-sm btn-warning'>Edit</a> 
                <a href='delete.php?id={$id}' class='btn btn-sm btn-danger'>Delete</a>";
             if ($status === 'aktif') {
                    echo " <a href='status.php?id={$id}&action=deactivate' class='btn btn-sm btn-secondary'>Nonaktifkan</a>";
            } else {
                    echo " <a href='status.php?id={$id}&action=activate' class='btn btn-sm btn-success'>Aktifkan</a>";
            }
                
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>Belum ada data gudang atau tidak ditemukan hasil pencarian.</p>";
}

$content = ob_get_clean();
include 'layout.php';
?>
