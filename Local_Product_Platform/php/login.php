<?php
session_start();
include '../php/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['sifre'])) {
        $email = $_POST['email'];
        $sifre = $_POST['sifre'];
        $giris_tipi = $_POST['giris_tipi']; // Kullanici veya yonetici

        // Kullanıcı doğrulama sorgusu
        $stmt = $conn->prepare("SELECT * FROM kullanici WHERE email = ? AND sifre = ?");
        $stmt->bind_param("ss", $email, $sifre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $rol = $user['rol'];

            // Kullanıcı girişi yapılırken admin bilgisi kullanıldıysa hata ver
            if ($giris_tipi === 'kullanici' && $rol === 'admin') {
                $error = "Kullanıcı girişi için geçersiz bilgiler!";
            } elseif ($giris_tipi === 'yonetici' && $rol !== 'admin') {
                $error = "Yönetici girişi için geçersiz bilgiler!";
            } else {
                // Geçerli giriş
                $_SESSION['user_id'] = $user['kullanici_id'];
                $_SESSION['user_role'] = $rol;
                $_SESSION['user_name'] = htmlspecialchars($user['adi']);

                if ($giris_tipi === 'yonetici') {
                    header("Location: ../php/admin_panel.php");
                } else {
                    header("Location: ../html/proje.html?name=". urlencode($user['adi']));
                }
                exit;
            }
        } else {
            $error = "Hatalı email veya şifre!";
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
    <title>Giriş Yap</title>
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
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            font-weight: bold;
            font-family: 'Open Sans';
            font-size: 16px;
            border: none;
            border-radius: 16px;
        }
        .tab.active {
            background-color: #5b5b5b;
            color: white;
            font-weight: bold;
            font-family: 'Open Sans';
            font-size: 16px;
            border: none;
            border-radius: 16px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .small-links {
            margin-top: 10px;
            font-size: 12px;
        }
        .small-links a {
            color: #555;
            text-decoration: none;
        }
        .small-links a:hover {
            text-deco
            ration: underline;
        }
        h1 a {
            text-decoration: none; 
            color: inherit; 
            left: 70px;  
        }
    </style>
    <script>
        function selectTab(type) {
            document.getElementById('giris_tipi').value = type;
            document.getElementById('kullanici_tab').classList.remove('active');
            document.getElementById('yonetici_tab').classList.remove('active');

            if (type === 'kullanici') {
                document.getElementById('kullanici_tab').classList.add('active');
            } else {
                document.getElementById('yonetici_tab').classList.add('active');
            }
        }
    </script>
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="../html/proje.html">
                <img src="../image/logo.jpg" alt="Yerel Ürün Platformu Logo" class="logo">
            </a>
            <h1><a href="../html/proje.html">Yerel Ürün Platformu</a></h1>
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
        <h2>Giriş Yap</h2>

        <div class="tabs">
            <div id="kullanici_tab" class="tab active" onclick="selectTab('kullanici')">Kullanıcı Girişi</div>
            <div id="yonetici_tab" class="tab" onclick="selectTab('yonetici')">Yönetici Girişi</div>
        </div>

        <form method="POST">
            <input type="hidden" name="giris_tipi" id="giris_tipi" value="kullanici">
            <input type="email" name="email" placeholder="E-posta" required>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <div class="small-links">
                <a href="../php/email_degistir.php">E-posta Değiştir</a> | <a href="../php/sifre_degistir.php">Şifre Değiştir</a>
            </div>
            <button type="submit">Giriş Yap</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error"> <?php echo htmlspecialchars($error); ?> </p>
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

