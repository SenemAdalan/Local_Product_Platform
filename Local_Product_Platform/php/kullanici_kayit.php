<?php
include '../php/db_connect_admin.php';

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adi = $_POST['adi'];
    $soyadi = $_POST['soyadi'];
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    // Basit doğrulama
    if (strlen($sifre) < 8) {
        $error = "Şifre en az 8 karakter uzunluğunda olmalıdır.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Geçersiz e-posta formatı.";
    } else {
        // E-posta zaten var mı kontrol et
        $stmt = $conn->prepare("SELECT email FROM kullanici WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Bu e-posta adresi zaten kayıtlı.";
        } else {
            // Veritabanına kayıt işlemi
            try {
                $stmt = $conn->prepare("INSERT INTO kullanici (adi, soyadi, email, sifre) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $adi, $soyadi, $email, $sifre);

                if ($stmt->execute()) {
                    $success = "Kayıt başarılı!";
                } else {
                    $error = "Bir hata oluştu: " . $stmt->error;
                }
            } catch (mysqli_sql_exception $e) {
                $error = "Bu e-posta adresi zaten kayıtlı.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Kullanıcı Kayıt</title>
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
        h1 a {
            text-decoration: none; 
            color: inherit; 
            left: 70px;  
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="../html/proje.html">
                <img src="../image/logo.jpg" alt="Yerel Ürün Platformu Logo" class="logo">
            </a>
            <h1><a href="../html/proje.html">Yerel Ürün Platformu</a></h1>
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
        <h2>Kullanıcı Kayıt</h2>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="adi" placeholder="Adınız" required>
            <input type="text" name="soyadi" placeholder="Soyadınız" required>
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="sifre" placeholder="Şifre (En az 8 karakter)" required>
            <button type="submit">Kayıt Ol</button>
        </form>
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