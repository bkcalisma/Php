-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 01 May 2016, 11:03:19
-- Sunucu sürümü: 5.6.24
-- PHP Sürümü: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `bkys-sifir`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE IF NOT EXISTS `ayarlar` (
  `id` int(11) NOT NULL,
  `ayarId` int(11) NOT NULL,
  `ayarDurum` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `ayarId`, `ayarDurum`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `devamsizlik`
--

CREATE TABLE IF NOT EXISTS `devamsizlik` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `k_id` int(11) NOT NULL,
  `Tarih` varchar(125) COLLATE utf8_turkish_ci NOT NULL,
  `Ekleyen` int(11) NOT NULL,
  `E_tarih` varchar(225) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kurslar`
--

CREATE TABLE IF NOT EXISTS `kurslar` (
  `id` int(11) NOT NULL,
  `dAdi` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `dSure` int(11) NOT NULL,
  `dEgitmen` int(11) NOT NULL,
  `dYardimci` int(11) NOT NULL,
  `dBgyil` varchar(75) COLLATE utf8_turkish_ci NOT NULL,
  `dBtyil` varchar(75) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kurslar`
--

INSERT INTO `kurslar` (`id`, `dAdi`, `dSure`, `dEgitmen`, `dYardimci`, `dBgyil`, `dBtyil`) VALUES
(1, 'Php', 14, 2, 2, '2015', '2016');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenciler`
--

CREATE TABLE IF NOT EXISTS `ogrenciler` (
  `id` int(11) NOT NULL,
  `oAd` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `kurs_id` int(11) NOT NULL,
  `oDevamsizlik` int(11) NOT NULL DEFAULT '0',
  `oEmail` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `oResim` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `oEkleyen` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ogrenciler`
--

INSERT INTO `ogrenciler` (`id`, `oAd`, `kurs_id`, `oDevamsizlik`, `oEmail`, `oResim`, `oEkleyen`) VALUES
(2, 'Abdullah Kalay', 1, 5, 'apo@apo.com', '', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
  `id` int(11) NOT NULL,
  `tID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tema`
--

INSERT INTO `tema` (`id`, `tID`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `uKadi` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `uSifre` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `uAS` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `uEt` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `uEmail` varchar(225) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `uKadi`, `uSifre`, `uAS`, `uEt`, `uEmail`, `yetki`) VALUES
(2, 'abdullahkalay', '76919fcd8756db0902b5fce2832a4184', 'Abdullah Kalay', '', 'apo@egebk.org', 4);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `devamsizlik`
--
ALTER TABLE `devamsizlik`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kurslar`
--
ALTER TABLE `kurslar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ogrenciler`
--
ALTER TABLE `ogrenciler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `devamsizlik`
--
ALTER TABLE `devamsizlik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- Tablo için AUTO_INCREMENT değeri `kurslar`
--
ALTER TABLE `kurslar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `ogrenciler`
--
ALTER TABLE `ogrenciler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
