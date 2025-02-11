# 🏡 Local Product Platform 

## 📌 Proje Açıklaması  
**Yerel Ürün Platformu**, kullanıcıların yerel bölgelerindeki gıda üreticilerini ve çiftçileri keşfetmelerini sağlayan bir **harita tabanlı web platformudur**.Bu platform sayesinde:  
✅ Kullanıcılar, doğrudan üreticilere ulaşarak **taze ve doğal ürünler** satın alabilir.  
✅ Yerel üreticiler, **dijital ortamda tanıtım yaparak** daha fazla müşteriye ulaşabilir.  
✅ **Yerel ekonomi desteklenir** ve küçük üreticilerin sürdürülebilirliği artırılır.  
✅ **Karbon ayak izi azaltılır**, çünkü ürünlerin taşınması yerine yerelde tüketimi teşvik edilir.  
✅ Kullanıcılar, üreticilere **yorum ve puan vererek** diğer kullanıcıların bilinçli seçimler yapmasına yardımcı olur.  

- **Yapılış Tarihi:** 10 Ocak 2025
- **Son Güncelleme:** 11 Şubat 2025

---

## 🚀 Kullanılan Teknolojiler  
- **Frontend:**  
  - HTML, CSS, JavaScript  
  - **SVG Türkiye Haritası** (Etkileşimli il seçimi)  
- **Backend:**  
  - PHP (Veritabanı yönetimi ve API)  
  - MySQL (Veri tabanı)  
- **Ek Kütüphaneler:**  
  - Bootstrap (Responsive tasarım)  

---

## 🔧 Proje Özellikleri  

✅ **Harita Tabanlı Arama**  
- Kullanıcılar Türkiye haritası üzerinden illeri seçerek yerel üreticilere ulaşabilir.  

✅ **Üretici ve Ürün Listeleme**  
- Kullanıcılar seçilen ildeki üreticileri ve onların sunduğu ürünleri inceleyebilir.  

✅ **Yorum ve Puanlama Sistemi**  
- Kullanıcılar, üreticiler hakkında yorum yapabilir ve puan verebilir.  

✅ **Kategori Bazlı Ürün Filtreleme**  
- Ürünler kategorilere ayrılarak kullanıcıların daha hızlı arama yapmasına imkan tanır.  

✅ **Kullanıcı Kayıt & Giriş Sistemi**  
- Kullanıcılar giriş yaparak üreticilere yorum ve puan ekleyebilir.

✅ **Yönetici Paneli**  
- Admin kullanıcıları, üretici ve ürün ekleme/güncelleme/silme gibi işlemleri gerçekleştirebilir.  

✅ **Responsive ve Mobil Uyumlu**  
- Tüm cihazlarda sorunsuz çalışan duyarlı tasarım.  

---

## 📥 Kurulum  

### 1️⃣ Gereksinimler  
- XAMPP  
- PHP 7+  
- MySQL Veritabanı  
- Tarayıcı  

### 2️⃣ Bağımlılıkları Yükleyin  
```bash
sudo apt update && sudo apt install apache2 php mysql-server php-mysql
```

### 3️⃣ Veritabanını Ayarlayın  
- MySQL üzerinde **yerel_urun_platformu** adında bir veritabanı oluşturun.  
- `db_connect.php` dosyasında **veritabanı bağlantı bilgilerini** düzenleyin.  

```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "yerel_urun_platformu";
```

### 4️⃣ Projeyi Çalıştırın (XAMPP ile)  
- **XAMPP’ı** bilgisayarınıza kurun ve **Apache** ile **MySQL** servislerini başlatın.  
- `htdocs` klasörüne projenizi kopyalayın:  

```bash
C:\xampp\htdocs\yerel_urun_platformu
```

- phpMyAdmin üzerinden **yerel_urun_platformu** adında bir veritabanı oluşturun.
- Proje dosyası içinde yer alan **local_product_platform.sql** dosyasını veri tabanına yükleyin.
- Tarayıcınızdan http://localhost/yerel_urun_platformu/html/proje.html adresine giderek platformu test edin.
---

## 📷 Arayüz Görselleri  

### Ana Sayfa 
![Image](https://github.com/user-attachments/assets/70bd5326-12d2-4b31-ab7a-0fec36fb4155)

### Ürün Listeleme İşlevi
![Image](https://github.com/user-attachments/assets/fc902999-6558-4ea8-b80e-c95df072ff7c)

### Üreticilere Yorum ve Puam Ekleme
![Image](https://github.com/user-attachments/assets/c679ee90-51ca-4a05-83fd-066869afa70f)

### Kullanıcı Kayıt İşlevi
![Image](https://github.com/user-attachments/assets/1a4288de-cc6e-4a15-81ad-0cf99f3e7311)

### Kullanıcı ve Admin Giriş Sayfası
![Image](https://github.com/user-attachments/assets/044f20a6-2b6f-44b0-9be8-e65ed247ca31)

### Yönetici Paneli 
![Image](https://github.com/user-attachments/assets/1b49c55a-8266-4d76-b015-12e3bd6e6b0d)

![Image](https://github.com/user-attachments/assets/38d3f93f-f748-4b78-8452-5191ec28d8b5)

![Image](https://github.com/user-attachments/assets/95ea90d0-2d60-481e-ac01-0141f007578a)
