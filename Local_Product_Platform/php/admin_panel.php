<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli</title>
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
            color: #6ac59e;
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
            padding: 20px;
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
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Yönetici Paneli</h1>
        <a href="../php/logout.php">Çıkış Yap</a>
    </div>

    <div class="container">
        <h2>Yönetim İşlemleri</h2>
        <div class="menu">
            <!-- Ürün işlemleri -->
            <a href="../php/urun_ekle.php">Ürün Ekle</a>
            <a href="../php/urun_sil.php">Ürün Sil</a>
            <a href="../php/urun_guncelle.php">Ürün Güncelle</a>
        </div>
        <div class="menu">
            <!-- Üretici işlemleri -->
            <a href="../php/uretici_ekle.php">Üretici Ekle</a>
            <a href="../php/uretici_sil.php">Üretici Sil</a>
            <a href="../php/uretici_guncelle.php">Üretici Güncelle</a>
        </div>
    </div>

</body>
</html>


