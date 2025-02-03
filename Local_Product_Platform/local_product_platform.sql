-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 06 Oca 2025, 22:48:01
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yerel_urun_platformu`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bolge`
--

CREATE TABLE `bolge` (
  `bolge_id` int(11) NOT NULL,
  `il` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `bolge`
--

INSERT INTO `bolge` (`bolge_id`, `il`) VALUES
(1, 'Adana'),
(2, 'Adıyaman'),
(3, 'Afyonkarahisar'),
(4, 'Ağrı'),
(5, 'Amasya'),
(6, 'Ankara'),
(7, 'Antalya'),
(8, 'Artvin'),
(9, 'Aydın'),
(10, 'Balıkesir'),
(11, 'Bilecik'),
(12, 'Bingöl'),
(13, 'Bitlis'),
(14, 'Bolu'),
(15, 'Burdur'),
(16, 'Bursa'),
(17, 'Çanakkale'),
(18, 'Çankırı'),
(19, 'Çorum'),
(20, 'Denizli'),
(21, 'Diyarbakır'),
(22, 'Edirne'),
(23, 'Elazığ'),
(24, 'Erzincan'),
(25, 'Erzurum'),
(26, 'Eskişehir'),
(27, 'Gaziantep'),
(28, 'Giresun'),
(29, 'Gümüşhane'),
(30, 'Hakkari'),
(31, 'Hatay'),
(32, 'Isparta'),
(33, 'Mersin'),
(34, 'İstanbul'),
(35, 'İzmir'),
(36, 'Kars'),
(37, 'Kastamonu'),
(38, 'Kayseri'),
(39, 'Kırklareli'),
(40, 'Kırşehir'),
(41, 'Kocaeli'),
(42, 'Konya'),
(43, 'Kütahya'),
(44, 'Malatya'),
(45, 'Manisa'),
(46, 'Kahramanmaraş'),
(47, 'Mardin'),
(48, 'Muğla'),
(49, 'Muş'),
(50, 'Nevşehir'),
(51, 'Niğde'),
(52, 'Ordu'),
(53, 'Rize'),
(54, 'Sakarya'),
(55, 'Samsun'),
(56, 'Siirt'),
(57, 'Sinop'),
(58, 'Sivas'),
(59, 'Tekirdağ'),
(60, 'Tokat'),
(61, 'Trabzon'),
(62, 'Tunceli'),
(63, 'Şanlıurfa'),
(64, 'Uşak'),
(65, 'Van'),
(66, 'Yozgat'),
(67, 'Zonguldak'),
(68, 'Aksaray'),
(69, 'Bayburt'),
(70, 'Karaman'),
(71, 'Kırıkkale'),
(72, 'Batman'),
(73, 'Şırnak'),
(74, 'Bartın'),
(75, 'Ardahan'),
(76, 'Iğdır'),
(77, 'Yalova'),
(78, 'Karabük'),
(79, 'Kilis'),
(80, 'Osmaniye'),
(81, 'Düzce');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `adi` varchar(100) NOT NULL,
  `soyadi` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(8) NOT NULL,
  `rol` enum('kullanici','admin') NOT NULL DEFAULT 'kullanici'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `adi`, `soyadi`, `email`, `sifre`, `rol`) VALUES
(1, 'Sema', 'Su', 'semasu_41@hotmail.com', 'sema', 'admin'),
(2, 'Deniz', 'TUNA', 'denizz@gmail.com', '12345678', 'kullanici'),
(15, 'Sema Su', 'YILMAZ', '220502016@kocaelisaglik.edu.tr', '12345678', 'kullanici'),
(16, 'Zehra', 'YARDIMCI', 'zehros@gmail.com', '12345678', 'kullanici'),
(17, 'Azra', 'AYMEN', 'azra@hotmail.com', '12345678', 'kullanici'),
(18, 'Senem ', 'ADALAN', 'senemadalan1903@gmail.com', '12345678', 'kullanici'),
(19, 'Zeynep', 'ÖZALP', 'zeynep@gmail.com', '12345678', 'kullanici'),
(20, 'Umut', 'KAYA', 'umutkaya@hotmail.com', '12345678', 'kullanici'),
(21, 'Ahmet', 'YILDIZ', 'ahmet@gmail.com', '12345678', 'kullanici');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uretici`
--

CREATE TABLE `uretici` (
  `uretici_id` int(11) NOT NULL,
  `adi` varchar(100) NOT NULL,
  `soyadi` varchar(100) NOT NULL,
  `adres` varchar(255) DEFAULT NULL,
  `telefon` varchar(25) DEFAULT NULL,
  `eposta` varchar(100) DEFAULT NULL,
  `bolge_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `uretici`
--

INSERT INTO `uretici` (`uretici_id`, `adi`, `soyadi`, `adres`, `telefon`, `eposta`, `bolge_id`) VALUES
(2, 'Ezgi', 'AKINCILAR', 'Çağlayan Mh. 2053 Sk. Oskup Apt. No:16 D:2 Muratpaşa/ANTALYA', '05453865236', 'haydi@antalyadaniste.com', 7),
(3, 'Hakan', 'HATİPOĞLU', 'Konaklı Mh. Mustafa Kemal Bulvarı No:172 Alanya/ANTALYA', '05334113224', 'siparis@ejdermeyvesi.com', 7),
(4, 'Ayşe', 'MECEK', 'Demirtaş Kasabası Toptancı Hali No:20 Alanya/ANTALYA', '05415487837', 'siparis@avokadocuayse.com', 7),
(5, 'Ayhan', 'TAŞ', 'Çakış Mh. Yeniköy Sk. No:1/1 Manavgat/ANTALYA', '02427623154', 'info@aymuz.com.tr', 7),
(6, 'Şevki', 'ÖNCEL', 'Çakış Mh. Yeniköy Sk. No:129/1 Manavgat/ANTALYA', '02425224689', 'info@bimuz.com.tr', 7),
(7, 'Portakal', 'Bahçem', 'Sahilkent Mh. 51 Sk. No:15 Finike/ANTALYA', '02428553855', 'iletisim@portakalbahcem.com', 7),
(8, 'Fresh', 'Tarım', 'Şimşek Sk. No:11/1 Kepez/ANTALYA', '05308951990', 'antalyafreshtarim@gmail.com', 7),
(9, 'Abdullah', 'İNAN', 'Güzelyurt Mh. Mustafa Göktürk Sk. No:45/A Aksu/ANTALYA', '02424631092', 'info@ecodab.com.tr', 7),
(10, 'Kuşkonmaz', 'Vadisi', 'Solak Mh. 4008 Sk. No:7 Aksu/ANTALYA', '05457985455', 'info@kuskonmazvadisi.com', 7),
(11, 'Mustafa Talha', 'KOYUNCU', 'Şazi Mh. İstasyon Cad. No:14/2-3 Bolvadin/AFYONKARAHİSAR', '02726127070', 'destek@hacimustafa.com', 3),
(12, 'Kaymakçızade', 'Enver', 'Umurbey Mh. Basın Cad. No:3/A Merkez/AFYONKARAHİSAR', '02722153122', '', 3),
(13, 'Cumhuriyet', 'Sucukları', 'Sinanpaşa Mh. 172. Sk. No:7/A Merkez/AFYONKARAHİSAR', '05306556155', 'info@afyongida.com', 3),
(14, 'İkbal', 'Sucukları', 'Organize Sanayi Bölgesi 2. Cad. 11. Sk. No:2 Merkez/AFYONKARAHİSAR', '08503023030', 'destek@ikbalonline.com', 3),
(15, 'Ahmet', 'ASGIN', 'Zafer Mh. Ahmet Özyurt Cad. No:204 İhsaniye/AFYONKARAHİSAR', '05333737005', 'info@gelincikhashas.com', 3),
(16, 'Erhan', 'KURDOĞLU', 'Susuz Mh. Ankara Cad. Merkez/AFYONKARAHİSAR', '027222354544', 'info@atakey.com', 3),
(17, 'Altaş', 'Tarım', 'Yunus Emre Mh. Antalya Yolu Cad. No:149 Sandıklı/AFYONKARAHİSAR', '05322584291', 'info@altastarim.com.tr', 3),
(18, 'Sadık', 'Memiş', 'Selçuklu Mh. Alparslan Türkeş Cad. Erkmen/AFYONKARAHİSAR', '05354640011', 'info@erkmenmeyvefidanbirliği.com.tr', 3),
(19, 'Köklü', 'Zeytincilik', 'Küçükköy Mh. Tellikavak Cad. No:1/1 Ayvalık/BALIKESİR', '08505321444', 'siparis@kokluzeytincilik.com.tr', 10),
(20, 'Özgün', 'Zeytincilik', '150 Evler Mh. No:5 Ayvalık/BALIKESİR', '02663313600', 'iletisim@ozgunzeytin.com.tr', 10),
(21, 'AloSüt', 'Balıkesir', 'Ege Mh. Yeniyol Cad. No:7/A Karesi/BALIKESİR', '05538804448', NULL, 10),
(22, 'Kesebir', 'Mandıra', 'Namık Kemal Mh. Belediye Sk. No:7 Ayvalık/BALIKESİR', '05354399610', 'kesebir@hotmail.com', 10),
(23, 'Sarıbaş', 'Gurme', 'Hürriyet Mh. 263. Sk. No:1 Burhaniye/BALIKESİR', '02664221711', 'info@saribasmandira.com.tr', 10),
(24, 'Perla', 'Fruit', 'Serme Mh. Kahraman Cad. No:29/2 Kestel/BURSA', '02245021888', 'info@perlafruit.com', 16),
(25, 'Bursa', 'Tarım', 'Çalı Mh. Dönüş Cad. No:58 Nilüfer/BURSA', '02244822770', 'bilgi@bursatarim.com.tr', 16),
(26, 'Canlar', 'Fruit', 'Ahmetbey Mh. Nilüfer Cad. No:295 Osmangazi/BURSA', '02247941132', 'info@canlarfruit.com', 16),
(27, 'Bursa', 'İpek', 'Reyhan Mh. Cumhuriyet Cad. No:288 Osmangazi/BURSA', '02242244050', 'info@bursaipek.com', 16),
(28, 'İpek', 'Evi', 'Odunluk Mh. Akademi Cad. No:17/6 Nilüfer/BURSA', '02244520222', 'iletisim@ipekevi.com', 16),
(29, 'Alkan', 'Zeytin', 'Umurbey Mh. Yalova Yolu No:1 Gemlik/BURSA', '05373622727', NULL, 16),
(30, 'Solive', 'Zeytin', 'Umurbey Mh. 2. Sk. No:2 Gemlik/BURSA', '02245149242', 'medya@solive.com.tr', 16),
(31, 'Eşme', 'Tarım', 'Eşme Mh. No:970/A Kartepe/KOCAELİ', '02623772620', 'esme@esmetarim.com', 41),
(32, 'İnci', 'Fındık', 'Akdurak Mh. Sakarya Cad. No:105/2 Kandıra/KOCAELİ', '02625515521', NULL, 41),
(33, 'Mert', 'Fındık', 'Orhan Mh. Ağva İstanbul Cad. No:246 Kandıra/KOCAELİ', '02623456789', 'info@mertfindik.com', 41),
(34, 'Zehra', 'YARDIMCI', 'Kocakaymas Mh. Eski Kandıra Cad. No:30 Kandıra/KOCAELİ', '02623130015', 'info@kandiragiosb.com', 41),
(35, 'Buffa', 'Çiftliği', 'Duracalı Mh. Alaybey Cad. No:125/5 Kandıra/KOCAELİ', '02625515151', 'info@buffa.com.tr', 41),
(36, 'Senem', 'ADALAN', 'Şirin Mh. Doğuş Cad. No:101 Kartepe/KOCAELİ', '05438638129', 'bilgi@kartepeorganik.com', 41);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

CREATE TABLE `urun` (
  `urun_id` int(11) NOT NULL,
  `adi` varchar(255) NOT NULL,
  `aciklama` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `uretici_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `urun`
--

INSERT INTO `urun` (`urun_id`, `adi`, `aciklama`, `kategori`, `uretici_id`) VALUES
(6, 'Büyük Fuerte Avokado', '200 gr ve üzeri', 'Avokado', 2),
(7, 'Orta Fuerte Avokado', '200 gr altı', 'Avokado', 2),
(8, 'Bebek Avokado', '', 'Avokado', 2),
(9, 'Büyük Fuerte Avokado', '250-300 gr arası', 'Avokado', 3),
(10, 'Orta Fuerte Avokado', '150-200 gr arası', 'Avokado', 3),
(11, 'Bebek Avokado', '', 'Avokado', 3),
(14, 'Büyük Fuerte Avokado', '200 gr ve üzeri', 'Avokado', 4),
(17, 'Muz Doğal Sarartma', '', 'Muz', 5),
(21, 'Yerli Muz A Kalite', '', 'Muz', 5),
(22, 'Premium Yerli Muz ', '', 'Muz', 6),
(23, 'Finike Portakalı Yemelik', 'Washington', 'Portakal', 7),
(24, 'Finike Portakalı Sıkmalık', 'Washington', 'Portakal', 7),
(25, 'Blushsweet Kan Portakalı', '', 'Portakal', 7),
(26, 'Taze Kekik', 'Nisan-Eylül arası', 'Kekik', 8),
(27, 'Sivri Kekik', 'El ile toplanmış, doğada kurutulmuş %100 Saf ve Doğal.', 'Kekik', 9),
(28, 'Bilyalı Kekik', 'El ile toplanmış, doğada kurutulmuş %100 Saf ve Doğal.', 'Kekik', 9),
(29, 'Yayla Kekik', 'El ile toplanmış, doğada kurutulmuş %100 Saf ve Doğal.', 'Kekik', 9),
(30, 'Kekik Suyu', 'Buhar Distilasyonu ile üretilmiştir. %100 Saf ve Doğal bitkisel sudur.', 'Kekik', 9),
(31, 'Sivri Kekik Yağı', 'Buhar Distilasyonu ile üretilmiştir. %100 Saf ve Doğal uçucu yağdır.', 'Kekik', 9),
(32, 'Taze Kuşkonmaz En Küçük Paket', '3x300 gr', 'Kuşkonmaz', 10),
(33, 'Taze Kuşkonmaz Küçük Paket', '6x300 gr', 'Kuşkonmaz', 10),
(34, 'Taze Kuşkonmaz Büyük Paket', '16x300 gr', 'Kuşkonmaz', 10),
(35, 'Manda Kaymağı', '250 gr', 'Kaymak', 11),
(36, 'Kaymak', 'Manda - İnek karışık 250 gr', 'Kaymak', 12),
(37, 'Klipsli Kangal Sucuk', '350 gr', 'Sucuk', 13),
(38, 'Baton Sucuk', '490-510 gr', 'Sucuk', 13),
(39, 'Doğal Kangal Sucuk', '500 gr', 'Sucuk', 13),
(40, 'Kangal Fermente Sucuk', '500 gr', 'Sucuk', 14),
(41, 'Geleneksel Fermente Sucuk', '200 gr', 'Sucuk', 14),
(42, 'Haşhaş Ezmesi', '500 gr', 'Haşhaş', 12),
(43, 'Sarı Haşhaş Ezmesi', '', 'Haşhaş', 15),
(44, 'Elma Dilim Patates', '', 'Patates', 16),
(45, 'Parmak Patates', '7x7', 'Patates', 16),
(46, 'Kızartmalık Patates', '', 'Patates', 17),
(47, 'Kumpirlik Patates', '', 'Patates', 17),
(48, 'Vişne', '', 'Vişne', 18),
(49, 'Erken Hasat Natürel Sızma Zeytinyağı', 'Taş Baskı Soğuk Sıkım', 'Zeytinyağı', 19),
(50, 'Natürel Birinci Yemeklik Zeytinyağı', 'Taş Baskı Soğuk Sıkım', 'Zeytinyağı', 19),
(51, 'Yeni Mahsul Erken Hasat Natürel Sızma Zeytinyağı', 'Ekim - Şubat ayları arası. Taş Baskı Soğuk Sıkım', 'Zeytinyağı', 19),
(52, 'Natürel Sızma Zeytinyağı', '', 'Zeytinyağı', 20),
(53, 'Natürel Birinci Zeytinyağı', '', 'Zeytinyağı', 20),
(54, 'Erken Hasat Sızma Zeytinyağı', '', 'Zeytinyağı', 20),
(55, 'Ayvalık Yeşil Çizik Zeytin', '', 'Zeytin', 19),
(56, 'Ayvalık Yeşil Kırma Zeytin', '', 'Zeytin', 19),
(57, 'Ayvalık Sele Zeytin', '', 'Zeytin', 19),
(58, 'Yuvarlama Siyah Zeytin', '', 'Zeytin', 20),
(59, 'Ayvalık Kırma Zeytin', '', 'Zeytin', 20),
(60, 'Ayvalık Çizik Zeytin', '', 'Zeytin', 20),
(61, 'Izgara Yeşil Zeytin', '', 'Zeytin', 19),
(62, 'Taze Günlük Süt', 'Sipariş Saatleri: 09.30-17.30 Teslimat Saatleri: 19.00-21.00', 'Süt', 21),
(63, 'Damla Sakızlı Saganaki Peyniri ', 'Az Tuzlu - Kızartmalık', 'Peynir', 22),
(64, 'Damla Sakızlı Saganaki Peyniri ', '', 'Peynir', 23),
(65, 'Taze Siyah İncir', 'Ağustos-Ekim arası', 'İncir', 24),
(66, 'Taze Siyah İncir', 'Ağustos-Ekim arası', 'İncir', 25),
(67, 'Kestane', 'Kasım-Aralık arası', 'Kestane', 25),
(68, 'Taze Şeftali', 'Haziran-Eylül arası', 'Şeftali', 24),
(69, 'Taze Şeftali', 'Haziran-Eylül arası', 'Şeftali', 26),
(70, 'Kestane', 'Kasım-Aralık arası', 'Kestane', 26),
(71, 'İpek Şal', '', 'İpek', 27),
(72, 'İpek Fular', '', 'İpek', 27),
(73, 'İpek Şal', '', 'İpek', 28),
(74, 'İpek Fular', '', 'İpek', 28),
(75, 'Siyah Gemlik Zeytini', 'Az Tuzlu', 'Zeytin', 29),
(76, 'Siyah Gemlik Zeytini', 'Az Tuzlu', 'Zeytin', 30),
(77, 'Gemlik Kırma Yeşil Zeytin', '', 'Zeytin', 30),
(78, 'Bardak Ayvası', 'Ekim - Mart ayları arası', 'Ayva', 31),
(79, 'Ekmek Ayvası', 'Ekim - Mart ayları arası', 'Ayva', 31),
(80, 'Eşme Ayvası', 'Ekim - Mart ayları arası', 'Ayva', 31),
(81, 'Taze Fındık', 'Ağustos-Ekim arası', 'Fındık', 32),
(82, 'Taze Fındık', 'Ağustos-Ekim arası', 'Fındık', 33),
(83, 'Karpuz', 'Haziran-Eylül arası', 'Karpuz', 34),
(84, 'Taze Günlük Süt', 'Pazar günü hariç dağıtım yapılır.', 'Süt', 36),
(85, 'Taze Günlük Süt', 'Hafta İçi: 08.00-20.00 Hafta Sonu: 10.00-18.00', 'Süt', 35);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorum`
--

CREATE TABLE `yorum` (
  `yorum_id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `uretici_id` int(11) DEFAULT NULL,
  `yorum` varchar(255) DEFAULT NULL,
  `puan` int(11) DEFAULT NULL CHECK (`puan` between 1 and 5),
  `olusturulma_tarihi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `yorum`
--

INSERT INTO `yorum` (`yorum_id`, `kullanici_id`, `uretici_id`, `yorum`, `puan`, `olusturulma_tarihi`) VALUES
(1, 2, 2, 'Çok taze ve lezzetliydi, kesinlikle tekrar alırım.', 5, '2025-01-07 00:34:44'),
(2, 18, 5, 'Doğal sarartma çeşitleri vardı her yerde bulunmuyor.', 4, '2025-01-07 00:37:51'),
(3, 17, 17, 'Tazecik ve dışarıya göre fiyatları çok iyidi.', 5, '2025-01-07 00:40:16'),
(4, 15, 19, 'Marketten aldıklarımız zeytinyağı değilmiş gerçek zeytinyağı budur.', 5, '2025-01-07 00:42:48'),
(5, 16, 31, 'Yol üstü geçerken aldık daha tatlı bekliyordum ama yine de lezzetliydi.', 4, '2025-01-07 00:44:43'),
(6, 18, 24, 'Mis kokulu, sulu suluydu çalışanlar çok ilgilendiler yolumuz düşerse kesinlikle tekrar uğrayacağız.', 5, '2025-01-07 00:47:41');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bolge`
--
ALTER TABLE `bolge`
  ADD PRIMARY KEY (`bolge_id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `uretici`
--
ALTER TABLE `uretici`
  ADD PRIMARY KEY (`uretici_id`),
  ADD KEY `bolge_id` (`bolge_id`);

--
-- Tablo için indeksler `urun`
--
ALTER TABLE `urun`
  ADD PRIMARY KEY (`urun_id`),
  ADD KEY `uretici_id` (`uretici_id`);

--
-- Tablo için indeksler `yorum`
--
ALTER TABLE `yorum`
  ADD PRIMARY KEY (`yorum_id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `uretici_id` (`uretici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bolge`
--
ALTER TABLE `bolge`
  MODIFY `bolge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `uretici`
--
ALTER TABLE `uretici`
  MODIFY `uretici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `urun`
--
ALTER TABLE `urun`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Tablo için AUTO_INCREMENT değeri `yorum`
--
ALTER TABLE `yorum`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `uretici`
--
ALTER TABLE `uretici`
  ADD CONSTRAINT `uretici_ibfk_1` FOREIGN KEY (`bolge_id`) REFERENCES `bolge` (`bolge_id`);

--
-- Tablo kısıtlamaları `urun`
--
ALTER TABLE `urun`
  ADD CONSTRAINT `urun_ibfk_1` FOREIGN KEY (`uretici_id`) REFERENCES `uretici` (`uretici_id`);

--
-- Tablo kısıtlamaları `yorum`
--
ALTER TABLE `yorum`
  ADD CONSTRAINT `yorum_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`),
  ADD CONSTRAINT `yorum_ibfk_2` FOREIGN KEY (`uretici_id`) REFERENCES `uretici` (`uretici_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
