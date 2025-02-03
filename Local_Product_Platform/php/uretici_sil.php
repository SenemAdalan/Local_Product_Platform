<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db_connect_admin.php';

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

// Üreticiler listelenmesi ve silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Bölgeye ait üreticileri çek
    if (isset($_POST['bolge_id']) && !empty($_POST['bolge_id'])) {
        $bolge_id = $_POST['bolge_id'];
        $sql = "SELECT * FROM uretici WHERE bolge_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bolge_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ureticiler = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ureticiler[] = $row;
            }
        }
    }

    // Üretici silme işlemi
    if (isset($_POST['delete_uretici_id']) && !empty($_POST['delete_uretici_id'])) {
        $uretic_id = $_POST['delete_uretici_id'];
    
        $sql = "SELECT COUNT(*) AS urun_sayisi FROM urun WHERE uretici_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $uretic_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        if ($row['urun_sayisi'] > 0) {
            $message = "Bu üreticiye ait ürünler mevcut. Önce bu ürünleri silmelisiniz.";
        } else {
            // Üreticiyi sil
            $sql = "DELETE FROM uretici WHERE uretici_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $uretic_id);
    
            if ($stmt->execute()) {
                $message = "Üretici başarıyla silindi.";
            } else {
                $message = "Üretici silinirken bir hata oluştu.";
            }
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Üretici Sil</title>
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

        .ureticiler {
            margin-top: 5px;
        }

        .ureticiler table {
            width: 100%;
            border-collapse: collapse;
        }

        .ureticiler th, .ureticiler td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .ureticiler th {
            background-color: #458368;
            color: white;
        }

        .ureticiler td button {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .ureticiler td button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Yönetici Paneli</h1>
        <a href="admin_panel.php">Geri Dön</a>
    </div>

    <div class="container">
        <h2>Üretici Sil</h2>

        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <!-- Bölge Seçimi -->
        <form method="POST">
            <label for="bolge_id">Bölge Seçin:</label>
            <select name="bolge_id" id="bolge_id" required>
                <option value="">--Bölge Seçin--</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['bolge_id'] ?>"><?= $region['bolge_id'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Üreticileri Göster</button>
        </form>

        <?php if (isset($ureticiler) && !empty($ureticiler)): ?>
            <div class="ureticiler">
                <table>
                    <thead>
                        <tr>
                            <th>Adı</th>
                            <th>Soyadı</th>
                            <th>Adres</th>
                            <th>Telefon</th>
                            <th>E-posta</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ureticiler as $uretici): ?>
                            <tr>
                                <td><?= $uretici['adi'] ?></td>
                                <td><?= $uretici['soyadi'] ?></td>
                                <td><?= $uretici['adres'] ?></td>
                                <td><?= $uretici['telefon'] ?></td>
                                <td><?= $uretici['eposta'] ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_uretici_id" value="<?= $uretici['uretici_id'] ?>">
                                        <button type="submit">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>

