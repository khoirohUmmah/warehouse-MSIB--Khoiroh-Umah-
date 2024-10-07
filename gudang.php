<?php
class Gudang {
    // Koneksi database dan nama tabel
    private $conn;
    private $table_name = "gudang";

    // Properti dari objek Gudang
    public $id;
    public $name;
    public $location;
    public $capacity;
    public $status;
    public $opening_hour;
    public $closing_hour;

    // Constructor untuk menerima koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk menambah gudang baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (name, location, capacity, status, opening_hour, closing_hour) 
                  VALUES (:name, :location, :capacity, :status, :opening_hour, :closing_hour)";
        
        // Menyiapkan query
        $stmt = $this->conn->prepare($query);

        // Sanitasi input data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->capacity = htmlspecialchars(strip_tags($this->capacity));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->opening_hour = htmlspecialchars(strip_tags($this->opening_hour));
        $this->closing_hour = htmlspecialchars(strip_tags($this->closing_hour));

        // Bind data ke query
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->opening_hour);
        $stmt->bindParam(":closing_hour", $this->closing_hour);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fungsi untuk membaca semua data gudang
    public function read() {
        $query = "SELECT id, name, location, capacity, status, opening_hour, closing_hour 
                  FROM " . $this->table_name . " ORDER BY id DESC";
        
        // Menyiapkan query
        $stmt = $this->conn->prepare($query);
        
        // Eksekusi query
        $stmt->execute();

        return $stmt;
    }

    // Fungsi untuk menampilkan data gudang berdasarkan ID
    public function show($id) {
        $query = "SELECT id, name, location, capacity, status, opening_hour, closing_hour 
                  FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        
        // Menyiapkan query
        $stmt = $this->conn->prepare($query);
        
        // Bind ID ke query
        $stmt->bindParam(":id", $id);

        // Eksekusi query
        $stmt->execute();

        return $stmt;
    }

    // Fungsi untuk mengupdate data gudang
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, location = :location, capacity = :capacity, 
                      status = :status, opening_hour = :opening_hour, closing_hour = :closing_hour 
                  WHERE id = :id";

        // Menyiapkan query
        $stmt = $this->conn->prepare($query);

        // Sanitasi input data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->capacity = htmlspecialchars(strip_tags($this->capacity));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->opening_hour = htmlspecialchars(strip_tags($this->opening_hour));
        $this->closing_hour = htmlspecialchars(strip_tags($this->closing_hour));

        // Bind data ke query
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":capacity", $this->capacity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->opening_hour);
        $stmt->bindParam(":closing_hour", $this->closing_hour);
        $stmt->bindParam(":id", $this->id);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fungsi untuk menghapus gudang berdasarkan ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Menyiapkan query
        $stmt = $this->conn->prepare($query);

        // Bind ID ke query
        $stmt->bindParam(":id", $this->id);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fungsi untuk mengubah status gudang (aktif/tidak aktif)
    public function changeStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        
        // Menyiapkan query
        $stmt = $this->conn->prepare($query);

        // Bind parameter ke query
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        // Eksekusi query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Fungsi untuk mencari gudang berdasarkan nama atau lokasi
    public function search($keyword) {
        $query = "SELECT id, name, location, capacity, status, opening_hour, closing_hour 
                  FROM " . $this->table_name . " 
                  WHERE name LIKE :keyword OR location LIKE :keyword";
        
        // Menyiapkan query
        $stmt = $this->conn->prepare($query);

        // Bind parameter pencarian ke query
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);

        // Eksekusi query
        $stmt->execute();

        return $stmt;
    }
}
?>
