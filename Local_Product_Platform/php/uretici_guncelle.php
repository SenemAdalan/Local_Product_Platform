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

// Üretici bilgilerini al
$ureticiler = [];
if (isset($_POST['bolge_id'])) {
    $bolge_id = $_POST['bolge_id'];
    $sql = "SELECT * FROM uretici WHERE bolge_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bolge_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ureticiler[] = $row;
        }
    }
}

// Üretici güncelleme işlemi
if (isset($_POST['update_uretici_id'])) {
    $uretici_id = $_POST['update_uretici_id'];
    $adi = $_POST['adi'];
    $soyadi = $_POST['soyadi'];
    $adres = $_POST['adres'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];

    $sql = "UPDATE uretici SET adi = ?, soyadi = ?, adres = ?, telefon = ?, eposta = ? WHERE uretici_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $adi, $soyadi, $adres, $telefon, $eposta, $uretici_id);

    if ($stmt->execute()) {
        // Success: Return a JSON response
        echo json_encode([
            'status' => 'success',
            'message' => 'Üretici başarıyla güncellendi.'
        ]);
    } else {
        // Failure: Return a JSON response with an error message
        echo json_encode([
            'status' => 'error',
            'message' => 'Üretici güncellenirken bir hata oluştu.'
        ]);
    }
    exit;  // Ensure no fu
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üretici Güncelle</title>
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
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, .table td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #458368;
            color: white;
        }

        button {
            background-color: #458368;
            color: white;
            border: none;
            padding: 10px 10px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6ac59e;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Yönetici Paneli</h1>
        <a href="../php/admin_panel.php">Geri Dön</a>
    </div>

    <div class="container">
        <h2>Üretici Güncelle</h2>

        <!-- Mesaj için boş bir alan -->
        <div class="message"></div>
        
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

        <?php if (isset($ureticiler)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Adı</th>
                        <th>Soyadı</th>
                        <th>Adres</th>
                        <th>Telefon</th>
                        <th>E-posta</th>
                        <th>Güncelle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ureticiler as $ureticiler_row): ?>
                        <tr>
                            <td class="editable" contenteditable="true" data-column="adi" data-id="<?php echo $ureticiler_row['uretici_id']; ?>"><?php echo $ureticiler_row['adi']; ?></td>
                            <td class="editable" contenteditable="true" data-column="soyadi" data-id="<?php echo $ureticiler_row['uretici_id']; ?>"><?php echo $ureticiler_row['soyadi']; ?></td>
                            <td class="editable" contenteditable="true" data-column="adres" data-id="<?php echo $ureticiler_row['uretici_id']; ?>"><?php echo $ureticiler_row['adres']; ?></td>
                            <td class="editable" contenteditable="true" data-column="telefon" data-id="<?php echo $ureticiler_row['uretici_id']; ?>"><?php echo $ureticiler_row['telefon']; ?></td>
                            <td class="editable" contenteditable="true" data-column="eposta" data-id="<?php echo $ureticiler_row['uretici_id']; ?>"><?php echo $ureticiler_row['eposta']; ?></td>
                            <td><button class="btn-update" onclick="updateUretici(<?php echo $ureticiler_row['uretici_id']; ?>)">Güncelle</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function updateUretici(uretici_id) {
            const updatedData = {};
            const cells = document.querySelectorAll(`td[data-id="${uretici_id}"]`);
            
            cells.forEach(cell => {
                const column = cell.getAttribute('data-column');
                updatedData[column] = cell.innerText.trim();
            });

            // Form data for update
            const formData = new FormData();
            formData.append('update_uretici_id', uretici_id);
            formData.append('adi', updatedData.adi);
            formData.append('soyadi', updatedData.soyadi);
            formData.append('adres', updatedData.adres);
            formData.append('telefon', updatedData.telefon);
            formData.append('eposta', updatedData.eposta);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                // Display the message in the message div
                const messageDiv = document.querySelector('.message');
                messageDiv.innerHTML = data.message;
            })
            .catch(error => {
                console.error('Hata:', error);
                document.querySelector('.message').innerHTML = "Bir hata oluştu."; // Error message in the message div
            });
        }
    </script>

</body>
</html>





