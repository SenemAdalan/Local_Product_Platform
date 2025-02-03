<?php
session_start();
include '../php/db_connect_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['current_email']) && isset($_POST['new_email'])) {
        $current_email = $_POST['current_email'];
        $new_email = $_POST['new_email'];

        // Mevcut e-posta doğrulaması
        $stmt = $conn->prepare("SELECT * FROM kullanici WHERE email = ?");
        $stmt->bind_param("s", $current_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Yeni e-posta güncellemesi
            $stmt = $conn->prepare("UPDATE kullanici SET email = ? WHERE email = ?");
            $stmt->bind_param("ss", $new_email, $current_email);
            if ($stmt->execute()) {
                $success_message = "E-posta başarıyla güncellendi!";
            } else {
                $error_message = "E-posta güncellenirken bir hata oluştu.";
            }
        } else {
            $error_message = "Mevcut e-posta yanlış!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>E-posta Değiştir</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="../css/svg-turkiye-haritasi.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fffaf6;
        }
        header {
            background-color: #fffaf6;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            height: 42px;
            margin-right: 20px;
        }
        .nav-buttons a, .nav-buttons button {
            color: #fff;
            text-decoration: none;
            background: #000000;
            border: none;
            padding: 15px 20px;
            font-size: 16px;
            font-weight: bold;
            font-family: 'Open Sans';
            margin: 0 15px;
            border-radius: 20px;
            cursor: pointer;
        }
        .nav-buttons button:hover, .nav-buttons a:hover {
            background: #5b5b5b;
        }
        .menu-container {
            position: relative;
            display: inline-block;
        }
        .hamburger {
            position: absolute; 
            top: -21px;       
            left: 22px;     
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
        }
        .hamburger .bar {
            height: 4.5px;
            background-color: rgb(0, 0, 0);
            border-radius: 5px;
            top: 0dvh; 
            font-family: 'Open Sans';
        }
        .menu {
            position: absolute;
            top: 10px;
            left: 22px;
            display: none; 
            opacity: 0;
            z-index: 1;
            transition: opacity 0.3s;
        }
        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu ul li { 
        text-align: left;
        margin: 10px 0; 
        font-size: 14px;
        font-family: 'Open Sans';
        font-weight: bold;
        }
        .menu ul li a {
            text-decoration: none;
            color: #000000;
            display: block;
            padding: 0px 0px;
        }
        .container {
            text-align: center;
            max-width: 400px;
            margin: 50px auto;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 16px;
            background-color: #fff;
        }
        input, button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #000000;
            color: white;
            font-weight: bold;
            font-family: 'Open Sans';
            font-size: 16px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #5b5b5b;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../image/logo.jpg" alt="Logo" class="logo">
            <h1>Yerel Ürün Platformu</h1>
        </div>
        <div class="nav-buttons">
            <a href="../php/login.php">Giriş Yap</a>
        </div>
    </header>

    <div class="menu-container">
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="menu">
            <ul>
                <li><a href="../html/hakkimizda.html">Hakkımızda</a></li>
                <li><a href="../html/iletisim.html">İletişim</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <h2>E-posta Değiştir</h2>

        <form method="POST">
            <input type="email" name="current_email" placeholder="Mevcut E-posta" required>
            <input type="email" name="new_email" placeholder="Yeni E-posta" required>
            <button type="submit">E-posta Değiştir</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
    </div>
    <script>
        document.querySelector('.hamburger').addEventListener('click', function() {
            const menu = document.querySelector('.menu');
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                menu.style.opacity = '0';
            } else {
                menu.style.display = 'block';
                setTimeout(function() {
                    menu.style.opacity = '1';
                }, 10);
            }
        });
    </script>
</body>
</html>

