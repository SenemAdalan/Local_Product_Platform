<?php
// Veri tabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yerel_urun_platformu";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == "get_categories_by_il") {
        // Gelen il adı
        $ilAdi = $_GET['ilAdi'];

        // İle ait ürün kategorilerini çekme sorgusu
        $query = "SELECT DISTINCT kategori FROM urun 
                  INNER JOIN uretici ON urun.uretici_id = uretici.uretici_id
                  INNER JOIN bolge ON uretici.bolge_id = bolge.bolge_id
                  WHERE bolge.il = ?";
        
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $ilAdi);  
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $categories = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row['kategori'];  // Kategori adı
            }

            // JSON olarak kategorileri döndür
            echo json_encode(['categories' => $categories]);
        } else {
            echo json_encode(['error' => 'Kategori alınırken bir hata oluştu.']);
        }
    }

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == "get_products_by_category") {
            $kategoriAdi = $_GET['kategoriAdi'];  // Gelen kategori adı
            
            // Kategoriye ait ürünleri çekme sorgusu
            $query = "SELECT adi, aciklama
                    FROM urun
                    WHERE kategori = ?
                    GROUP BY adi, aciklama";
            
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $kategoriAdi);  // 's' string parametre
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
    
                $products = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $products[] = $row;  // Ürün adı ve açıklamasını al
                }
    
                // JSON olarak ürünleri döndür
                echo json_encode(['products' => $products]);
            } else {
                echo json_encode(['error' => 'Ürünler alınırken bir hata oluştu.']);
            }
        }
    }

    if ($action == "get_reviews_by_producer") {
        header('Content-Type: application/json; charset=utf-8'); // JSON çıktı başlığı
        header("Access-Control-Allow-Origin: *"); 
        $ureticiId = $_GET['ureticiId'];
    
        $query = "SELECT y.yorum, y.puan, k.adi AS kullanici, y.olusturulma_tarihi 
                  FROM yorum y
                  INNER JOIN kullanici k ON y.kullanici_id = k.kullanici_id
                  WHERE y.uretici_id = ?
                  ORDER BY y.olusturulma_tarihi DESC";
    
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $ureticiId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            $reviews = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $reviews[] = $row;
            }
    
            echo json_encode(['reviews' => $reviews]);
        } else {
            echo json_encode(['error' => 'Yorumlar alınırken bir hata oluştu.']);
        }
    }
    
    
    if ($action == "add_review") {
        session_start(); // Oturumu başlat
    
        // Kullanıcı oturumunu kontrol edin
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Lütfen önce giriş yapın.']);
            exit;
        }
    
        // Gerekli POST parametrelerini kontrol edin
        if (!isset($_POST['ureticiId'], $_POST['yorum'], $_POST['puan'])) {
            echo json_encode(['success' => false, 'message' => 'Eksik veri.']);
            exit;
        }
    
        $kullaniciId = $_SESSION['user_id'];
        $ureticiId = (int) $_POST['ureticiId'];
        $yorum = $_POST['yorum'];
        $puan = (int) $_POST['puan'];
    
        // Yorum ekleme sorgusu
        $query = "
            INSERT INTO yorum (kullanici_id, uretici_id, yorum, puan, olusturulma_tarihi)
            VALUES (?, ?, ?, ?, NOW())
        ";
    
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "iisi", $kullaniciId, $ureticiId, $yorum, $puan);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true, 'message' => 'Yorum başarıyla eklendi.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Yorum eklenirken bir hata oluştu.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorgu hazırlama başarısız.']);
        }
    }
    
    
}


$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == "get_producers_by_product") {
    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Origin: *");

    // Gelen parametreleri alın
    $urunAdi = $_GET['urunAdi'];
    $urunAciklama = $_GET['urunAciklama'];

    // Veritabanı sorgusu
    $query = "SELECT uretici.uretici_id, uretici.adi, uretici.soyadi, uretici.eposta, uretici.telefon, uretici.adres
              FROM urun
              INNER JOIN uretici ON urun.uretici_id = uretici.uretici_id
              WHERE urun.adi = ? AND urun.aciklama = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $urunAdi, $urunAciklama);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $producers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $producers[] = $row;
        }

        // Eğer sonuç yoksa boş bir dizi döndür
        if (empty($producers)) {
            echo json_encode(['producers' => []]);
            exit;
        }

        // JSON olarak üreticileri döndür
        echo json_encode(['producers' => $producers]);
    } else {
        echo json_encode(['error' => 'Üreticiler alınırken bir hata oluştu.']);
    }
}





