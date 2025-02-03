<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../php/login.php");
    exit;
}

include '../php/db_connect_admin.php';

$message = "";

// Bölgeleri al
$regions = [];
$sql = "SELECT * FROM bolge";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $regions[] = $row;
    }
}

// Üretici ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_uretic'])) {
    $adi = $_POST['adi'];
    $soyadi = $_POST['soyadi'];
    $adres = $_POST['adres'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];
    $bolge_id = $_POST['bolge_id'];

    // Üretici ekleme sorgusu
    $sql = "INSERT INTO uretici (adi, soyadi, adres, telefon, eposta, bolge_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $adi, $soyadi, $adres, $telefon, $eposta, $bolge_id);

    if ($stmt->execute()) {
        $message = "Üretici başarıyla eklendi.";
    } else {
        $message = "Üretici eklenirken bir hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Üretici Ekle</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .navbar {
            background-color: #458368;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 15px;
            border: 2px solid white;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: white;
            color: #458368;
            transition: 0.3s;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .container h2 {
            background-color: #458368;
            color: white;
            margin: 0;
            padding: 10px;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: auto;
            margin-top: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
        }

        button {
            background-color: #458368;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #6ac59e;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .message p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Yönetici Paneli</h1>
        <a href="../php/admin_panel.php">Geri Dön</a>
    </div>

    <div class="container">
        <h2>Üretici Ekle</h2>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <!-- Üretici Ekleme Formu -->
        <form method="POST">
            <label for="adi">Adı:</label>
            <input type="text" name="adi" id="adi" required>

            <label for="soyadi">Soyadı:</label>
            <input type="text" name="soyadi" id="soyadi" required>

            <label for="adres">Adres:</label>
            <input type="text" name="adres" id="adres">

            <label for="telefon">Telefon:</label>
            <input type="text" name="telefon" id="telefon">

            <label for="eposta">E-posta:</label>
            <input type="email" name="eposta" id="eposta">

            <label for="bolge_id">Bölge Seçin:</label>
            <select name="bolge_id" id="bolge_id" required>
                <option value="">--Bölge Seçin--</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['bolge_id'] ?>"><?= $region['bolge_id'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add_uretic">Üretici Ekle</button>
        </form>
    </div>
</body>
</html>
