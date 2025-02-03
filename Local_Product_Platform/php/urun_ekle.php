<?php
session_start();

// Kullanıcı girişi kontrolü
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../php/login.php");
    exit;
}

include '../php/db_connect_admin.php'; // Veritabanı bağlantısı

$message = "";

// Ürün ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adi = $_POST['adi'];
    $aciklama = $_POST['aciklama'];
    $kategori = $_POST['kategori'];
    $uretici_id = $_POST['uretici_id'];

    // Veritabanı sorgusu ile ürün ekleme
    $stmt = $conn->prepare("INSERT INTO urun (adi, aciklama, kategori, uretici_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $adi, $aciklama, $kategori, $uretici_id);
    if ($stmt->execute()) {
        $message = "Ürün başarıyla eklendi!";
    } else {
        $message = "Ürün eklenirken bir hata oluştu: " . $conn->error;
    }
    $stmt->close();
}

// Üreticileri almak için sorgu
$uretici_query = "SELECT uretici_id, adi, soyadi FROM uretici";
$uretici_result = $conn->query($uretici_query);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

        .menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
        }

        .menu a {
            text-align: center;
            background-color: #f4f4f9;
            border: 2px solid #458368;
            border-radius: 5px;
            text-decoration: none;
            color: #458368;
            padding: 15px;
            font-size: 16px;
            font-weight: 500;
            transition: 0.3s;
            cursor: pointer;
        }

        .menu a:hover {
            background-color: #458368;
            color: white;
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
        <h2>Ürün Ekle</h2>

        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form id="productForm" method="POST">
            <label for="adi">Ürün Adı:</label>
            <input type="text" name="adi" id="adi" required>

            <label for="aciklama">Açıklama:</label>
            <input type="text" name="aciklama" id="aciklama">

            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" id="kategori">

            <label for="uretici_id">Üretici:</label>
            <select name="uretici_id" id="uretici_id" required>
                <option value="" disabled selected>Bir Üretici Seçin</option>
                <?php
                if ($uretici_result && $uretici_result->num_rows > 0) {
                    while ($uretici = $uretici_result->fetch_assoc()) {
                        echo "<option value='" . $uretici['uretici_id'] . "'>" . htmlspecialchars($uretici['adi']) . " " . htmlspecialchars($uretici['soyadi']) . "</option>";
                    }
                } else {
                    echo "<option value=\"\">Üretici bulunamadı.</option>";
                }
                ?>
            </select>

            <button type="submit">Ekle</button>
        </form>
    </div>

</body>
</html>

