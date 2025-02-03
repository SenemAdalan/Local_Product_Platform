<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../php/login.php");
    exit;
}
include '../php/db_connect_admin.php';

$message = "";

// Kategori, Üretici ve Ürün silme işlemleri için gerekli sorguları oluşturuyoruz
$categories = [];
$manufacturers = [];
$products = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Silme işlemi
    if (isset($_POST['delete_product'])) {
        $urun_id = $_POST['urun_id'];
        $sql = "DELETE FROM urun WHERE urun_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $urun_id);
        if ($stmt->execute()) {
            $message = "Ürün başarıyla silindi.";
        } else {
            $message = "Ürün silinirken bir hata oluştu.";
        }
    }
}

// Kategorileri al
$sql = "SELECT DISTINCT kategori FROM urun";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['kategori'];
    }
}

// Üreticileri al
if (isset($_POST['kategori'])) {
    $kategori = $_POST['kategori'];
    $sql = "SELECT DISTINCT u.uretici_id, u.adi, u.soyadi 
            FROM urun AS p 
            JOIN uretici AS u ON p.uretici_id = u.uretici_id 
            WHERE p.kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $manufacturers_result = $stmt->get_result();
    while ($row = $manufacturers_result->fetch_assoc()) {
        $manufacturers[] = $row;
    }
}

// Ürünleri al
if (isset($_POST['kategori']) && isset($_POST['uretici_id'])) {
    $kategori = $_POST['kategori'];
    $uretici_id = $_POST['uretici_id'];
    $sql = "SELECT urun_id, adi FROM urun WHERE kategori = ? AND uretici_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $kategori, $uretici_id);
    $stmt->execute();
    $products_result = $stmt->get_result();
    while ($row = $products_result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Ürün Sil</title>
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
            color: #4CAF50;
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
        <h2>Ürün Sil</h2>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        
        <!-- Kategori Seçimi -->
        <form method="POST">
            <label for="kategori">Kategori Seçin:</label>
            <select name="kategori" id="kategori" onchange="this.form.submit()">
                <option value="">--Kategori Seçin--</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category ?>" <?= isset($_POST['kategori']) && $_POST['kategori'] == $category ? 'selected' : '' ?>>
                        <?= $category ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if (isset($_POST['kategori'])): ?>
            <!-- Üretici Seçimi -->
            <form method="POST">
                <input type="hidden" name="kategori" value="<?= $_POST['kategori'] ?>">
                <label for="uretici_id">Üretici Seçin:</label>
                <select name="uretici_id" id="uretici_id" onchange="this.form.submit()">
                    <option value="">--Üretici Seçin--</option>
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <option value="<?= $manufacturer['uretici_id'] ?>" <?= isset($_POST['uretici_id']) && $_POST['uretici_id'] == $manufacturer['uretici_id'] ? 'selected' : '' ?>>
                            <?= $manufacturer['adi'] . ' ' . $manufacturer['soyadi'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['kategori']) && isset($_POST['uretici_id'])): ?>
            <!-- Ürün Listeleme -->
            <form method="POST">
                <input type="hidden" name="kategori" value="<?= $_POST['kategori'] ?>">
                <input type="hidden" name="uretici_id" value="<?= $_POST['uretici_id'] ?>">

                <label for="urun_id">Ürün Seçin:</label>
                <select name="urun_id" id="urun_id">
                    <option value="">--Ürün Seçin--</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['urun_id'] ?>">
                            <?= $product['adi'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="delete_product">Sil</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

