<?php
require_once 'database.php';
require_once 'gudang.php';

$database = new Database();
$db = $database->getConnection();

$gudang = new Gudang($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gudang->name = $_POST['name'];
    $gudang->location = $_POST['location'];
    $gudang->capacity = $_POST['capacity'];
    $gudang->status = $_POST['status'];
    $gudang->opening_hour = $_POST['opening_hour'];
    $gudang->closing_hour = $_POST['closing_hour'];

    if ($gudang->create()) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menambah gudang.</div>";
    }
}

ob_start();
?>

<h1 class="mb-4">Tambah Gudang Baru</h1>

<form action="create.php" method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Gudang:</label>
        <input type="text" name="name" id="name" class="form-control" required>
        <div class="invalid-feedback">Nama gudang harus diisi.</div>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Lokasi:</label>
        <input type="text" name="location" id="location" class="form-control" required>
        <div class="invalid-feedback">Lokasi harus diisi.</div>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Kapasitas:</label>
        <input type="number" name="capacity" id="capacity" class="form-control" required>
        <div class="invalid-feedback">Kapasitas harus diisi.</div>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status:</label>
        <select name="status" id="status" class="form-select">
            <option value="aktif">Aktif</option>
            <option value="tidak_aktif">Tidak Aktif</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="opening_hour" class="form-label">Jam Buka:</label>
        <input type="time" name="opening_hour" id="opening_hour" class="form-control">
    </div>
    <div class="mb-3">
        <label for="closing_hour" class="form-label">Jam Tutup:</label>
        <input type="time" name="closing_hour" id="closing_hour" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary w-100">Tambah Gudang</button>
</form>

<div class="mt-3">
    <a href="index.php" class="btn btn-secondary w-100">Kembali ke Daftar Gudang</a>
</div>

<script>
    // Bootstrap form validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
