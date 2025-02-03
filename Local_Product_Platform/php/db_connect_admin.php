<?php // Veri Tabanı Bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yerel_urun_platformu"; 

// Bağlantıyı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>