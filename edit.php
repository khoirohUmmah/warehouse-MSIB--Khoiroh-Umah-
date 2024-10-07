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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];  // Mengambil status dari form
    $gudang->opening_hour = $_POST['opening_hour'];
    $gudang->closing_hour = $_POST['closing_hour'];
    
    // Mengupdate data gudang
    if ($gudang->update()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate data gudang.";
    }
} else {
    // Mendapatkan data gudang berdasarkan ID
    $stmt = $gudang->show($gudang->id);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $gudang->name = $data['name'];
    $gudang->location = $data['location'];
    $gudang->capacity = $data['capacity'];
    $gudang->status = $data['status']; // Menyimpan status dari database
    $gudang->opening_hour = $data['opening_hour'];
    $gudang->closing_hour = $data['closing_hour'];
}

ob_start();
?>

<h1>Edit Data Gudang</h1>

<form action="edit.php?id=<?php echo $gudang->id; ?>" method="POST">
    <div class="mb-3">
        <label for="name">Nama Gudang:</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $gudang->name; ?>" required><br>
    </div>

    <div class="mb-3">
        <label for="location">Lokasi Gudang:</label>
        <input type="text" class="form-control" name="location" id="location" value="<?php echo $gudang->location; ?>" required><br>
    </div>

    <div class="mb-3">
        <label for="capacity">Kapasitas Gudang:</label>
        <input type="number" class="form-control" name="capacity" id="capacity" value="<?php echo $gudang->capacity; ?>" required><br>
    </div>

    <div class="mb-3">
        <label for="status">Status:</label>
        <select class="form-control" name="status" id="status">
            <option value="aktif" <?php echo $gudang->status == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
            <option value="tidak_aktif" <?php echo $gudang->status == 'tidak_aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
        </select><br>
    </div>

    <div class="mb-3">
        <label for="opening_hour">Jam Buka:</label>
        <input type="time" class="form-control" name="opening_hour" id="opening_hour" value="<?php echo $gudang->opening_hour; ?>" required><br>
    </div>

    <div class="mb-3">
        <label for="closing_hour">Jam Tutup:</label>
        <input type="time" class="form-control" name="closing_hour" id="closing_hour" value="<?php echo $gudang->closing_hour; ?>" required><br>
    </div>

    <input type="submit" class="btn btn-warning w-100" value="Update Gudang">
</form>

<br>
<a href="index.php">Kembali ke Daftar Gudang</a>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
