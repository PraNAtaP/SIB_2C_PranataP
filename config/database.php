<?php
/**
* FILE: config/database.php
* FUNGSI: Membuat koneksi ke database PostgreSQL
*/
class Database {
 // Informasi koneksi database - GANTI dengan settingan lokal Anda
 private $host = "localhost";
 private $port = "5432";
 private $db_name = "company_prana";
 private $username = "postgres"; // Default username PostgreSQL
 private $password = "08112005prana"; // Ganti dengan password PostgreSQL Anda
 public $conn;
 public function getConnection() {
 $this->conn = null;

 try {
 $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port .
";dbname=" . $this->db_name;
 $this->conn = new PDO($dsn, $this->username, $this->password);

 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 } catch(PDOException $exception) {
 echo "Error koneksi database: " . $exception->getMessage();
 }

 return $this->conn;
 }
}
?>