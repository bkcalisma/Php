<?php 
	session_start();
	if (!isset($_SESSION["bkys"])){
		header("location:login.php");
		}else {
        include_once("baglan.php");
        $sayfa = strip_tags(trim(@$_GET["p"]));
			
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php
    $temayibul = $db->query("SELECT * FROM tema WHERE id =1");
    $tema = $temayibul->fetch(PDO::FETCH_ASSOC);
        switch($tema["tID"]) {
            case "1";
                ?><link rel="stylesheet" type="text/css" href="css/cerulean.min.css"/> <?php
                break;
            case "2";
                ?><link rel="stylesheet" type="text/css" href="css/cosmo.min.css"/> <?php
                break;
            case "3";
                ?><link rel="stylesheet" type="text/css" href="css/cyborg.min.css"/> <?php
                break;
            case "4";
                ?><link rel="stylesheet" type="text/css" href="css/darkly.min.css"/> <?php
                break;
            case "5";
                ?><link rel="stylesheet" type="text/css" href="css/flatly.min.css"/> <?php
                break;
            case "6";
                ?><link rel="stylesheet" type="text/css" href="css/journal.min.css"/> <?php
                break;
            case "7";
                ?><link rel="stylesheet" type="text/css" href="css/lumen.min.css"/> <?php
                break;
            case "8";
                ?><link rel="stylesheet" type="text/css" href="css/superhero.min.css"/> <?php
                break;
            case "9";
                ?><link rel="stylesheet" type="text/css" href="css/United.min.css"/> <?php
                break;
            default;
                ?><link rel="stylesheet" type="text/css" href="css/bootstrap.css"/> <?php
                break;
        }

    ?>
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="css/ak-aga.css"/>
<title>EGE BK Yoklama Sistemi</title>
</head>

<body>
	<div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    <a class="navbar-brand" href="#">BKYS</a></div>
                <div class="collapse navbar-collapse" id="defaultNavbar1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php"><span class="fa fa-home"></span> Anasayfa</a></li>
                        <?php if ($_SESSION["yetki"] >= 1) {?>
                            <li><a href="index.php?p=devam"><span class="fa fa-desktop"></span>  Devamsızlık</a></li>
                            <li><a href="index.php?p=ogrenciekle"><span class="fa fa-graduation-cap"></span>  Öğrenci Ekle </a> </li>
                        <?php } ?>
                        <!--Yönetim yetkileri-->
                        <?php
                        if ($_SESSION["yetki"] > 3) {
                            ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list"></span> Kurs <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php?p=kurslar"><span class="fa fa-list"></span> Kurslar</a></li>
                                    <li><a href="index.php?p=kursekle"><span class="fa fa-plus"></span> Kurs Ekle</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-list"></span> Yetkililer <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php?p=yetkililer"><span class="fa fa-list"></span> Yetkililer</a></li>
                                    <li><a href="index.php?p=yetkiliekle"><span class="fa fa-user-plus"></span> Yetkili Ekle</a></li>
                                </ul>
                            </li>

                        <?php } ?>
                        <li><a href="logout.php"><span class="fa fa-remove"></span> Çıkış Yap</a></li>
                    </ul>
                    <?php
                    date_default_timezone_set("Europe/Istanbul");
                    $tarih = date("d-m-y");
                    $saat = date("H:i");
                    ?>
                    <div class="pull-right hidden-md hidden-sm hidden-xs" style="text-align:center;margin-top:5px;">Merhaba <b><?php echo @$_SESSION["kadi"]; ?></b><br />Zaman :<?php echo $tarih; ?> <b><?php echo $saat; ?></b></div>

                </div>
            </div>
        </nav>
    </div>
    <?php
        switch($sayfa) {
            case "devam";
                if ($_SESSION["yetki"] > 1) {
                ?>
                    <div class="container">
                        <?php
                            if (@$_GET["islem"]){
                                $islem = strip_tags(trim($_GET["islem"]));
                                switch  ($islem){
                                    case "remove";
                                        if ($_GET["idsi"]) {
                                            if ($_SESSION["yetki"] > 3) {
                                                $silinecek = trim(strip_tags($_GET["idsi"]));
                                                $varmi = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                                $varmi->execute(array($silinecek));
                                                if ($varmi->rowCount() > 0) {
                                                $sil = $db->prepare("DELETE FROM ogrenciler WHERE id = ?");
                                                $sil->execute(array($silinecek));
                                                if ($sil) {
                                                    ?><div class="alert alert-success"><strong>Başarılı!</strong> Öğrenci başarıyla silindi.</div> <?php
                                                }else {
                                                    ?><div class="alert alert-danger"><strong>HATA!</strong> Öğrenci silinirken bir hata oluştu!</div> <?php
                                                }
                                            }else {
                                                    ?><div class="alert alert-danger"><strong>HATA!</strong> Böyle bir öğrenci zaten bulunmamakta!</div> <?php
                                                }

                                            }
                                        }
                                        break;
                                    case "dinsert";
                                        if ($_GET["idsi"]) {
                                            if ($_SESSION["yetki"] > 0) {
                                                $eklenecek = trim(strip_tags($_GET["idsi"]));
                                                $varmi = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                                $varmi->execute(array($eklenecek));
                                                if ($varmi->rowCount() > 0) {
                                                    $dcek = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                                    $dcek->execute(array($eklenecek));
                                                    $zz = $dcek->fetch(PDO::FETCH_ASSOC);
                                                    $devam = $zz["oDevamsizlik"];
                                                    $devam = $devam + 1;
                                                    $kursaydi = $zz["kurs_id"];
                                                    $johnny = $db->prepare("UPDATE ogrenciler SET oDevamsizlik = ? WHERE id = ?");
                                                    $johnny->execute(array($devam,$eklenecek));
                                                    if ($johnny){
                                                        $tarih = date("d-m-y");
                                                        $ekleyen = $_SESSION["kidd"];
                                                        $sins = $db->prepare("INSERT INTO devamsizlik SET u_id = ?,k_id = ?,Tarih = ?,Ekleyen = ?,E_tarih = ?");
                                                        $sins->execute(array($eklenecek,$kursaydi,$tarih,$ekleyen,$tarih));
                                                        if ($sins) {
                                                            ?><div class="alert alert-success"><strong>Başarılı!</strong> Devamsızlık başarıyla eklendi.</div> <?php
                                                        }else {
                                                            ?><div class="alert alert-danger"><strong>HATA!</strong> Devamsızlık tarihi eklenirken bir hata oluştu!</div> <?php
                                                        }
                                                    }else {
                                                        ?><div class="alert alert-danger"><strong>HATA!</strong> Veritabanı güncellenirken bir hata oluştu!</div> <?php
                                                    }
                                                }else {
                                                    ?><div class="alert alert-danger"><strong>HATA!</strong> Böyle bir öğrenci bulunmamakta!</div> <?php
                                                }

                                            }
                                        }
                                        break;
                                    case "detay";
                                        if (@$_SESSION["yetki"] > 0) {
                                            if (@$_GET["idsi"]) {
                                                if (@$_GET["ss"]) {
                                                    $silal = strip_tags(trim($_GET["ss"]));
                                                    if (!empty($silal)){
                                                        $sil = $db->prepare("DELETE FROM devamsizlik WHERE id = ?");
                                                        $sil->execute(array($silal));
                                                        if ($sil){
                                                            ?>  <div class="alert alert-success"><strong>Başarılı!</strong> Veri başarıyla silindi.</div> <?php
                                                        }else {
                                                            ?>  <div class="alert alert-danger"><strong>Başarısız!</strong> Veri başarıyla silinemedi.</div> <?php
                                                        }
                                                    }
                                                }
                                                $idzz = strip_tags(trim($_GET["idsi"]));
                                                $bul = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                                $bul->execute(array($idzz));
                                                if ($bul->rowCount()> 0) {
                                                    $isim = $bul->fetch(PDO::FETCH_ASSOC);
                                                $ara = $db->prepare("SELECT * FROM devamsizlik WHERE u_id = ?");
                                                $ara->execute(array($idzz));
                                                if ($ara->rowCount() > 0) {

                                                    ?>
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading"><strong><?php echo $isim["oAd"]; ?> devamsızlık dökümü</strong></div>
                                                        <div class="panel-body">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tarih</th>
                                                            <th>Ekleyen</th>
                                                            <th>İşlemler</th>
                                                        </tr>
                                                        <?php foreach ($ara as $aa) {
                                                            $ekleyenbul = $db->prepare("SELECT * FROM users WHERE id = ?");
                                                            $ekleyenbul->execute(array($aa["Ekleyen"]));
                                                            $yilan = $ekleyenbul->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                        <tr>
                                                            <td><?php echo $aa["id"]; ?></td>
                                                            <td><?php echo $aa["Tarih"]; ?></td>
                                                            <td><strong><?php echo $yilan["uAS"]; ?></strong></td>
                                                            <td><a href="index.php?p=devam&islem=detay&idsi=<?php echo $idzz; ?>&ss=<?php echo $aa["id"]; ?>" title="Sil"><span class="fa fa-remove" style="color:red;"></span> </a></td>
                                                        </tr>
                                                        <?php

                                                        }
                                                        ?></table></div></div> <?php
                                                }else {
                                                    ?> <div class="alert alert-warning"><strong>Hmm </strong> Öğrencinin gösterilebilecek devamsızlığı bulunmamakta.</div> <?php
                                                }
                                                ?>

                                                <?php
                                            }else {
                                                    ?> <div class="alert alert-danger"><strong>Hata!</strong> Böyle bir öğrenci bulunmamaktadır.</div> <?php
                                                }}
                                        }
                                        break;
                                    case "info";

                                        if (@$_POST) {
                                            if ($_SESSION["yetki"] > 0) {
                                            $ogrencid = trim(strip_tags($_GET["idsi"]));
                                            $varmi = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                            $varmi->execute(array($ogrencid));
                                            if ($varmi->rowCount() > 0) {
                                                $ii = $varmi->fetch(PDO::FETCH_ASSOC);
                                                $idysi = $ii["id"];
                                                $adsoyad = strip_tags(trim($_POST["adi"]));
                                                $devamsizlik = strip_tags(trim($_POST["devam"]));
                                                $email = strip_tags(trim($_POST["email"]));
                                                $kurs = strip_tags(trim($_POST["kurs"]));
                                                $ekleyen = $_SESSION["kidd"];
                                                if (!empty($adsoyad) && !empty($devamsizlik) && !empty($email) && !empty($kurs)) {
                                                    $upup = $db->prepare("UPDATE ogrenciler SET oAd = ?,kurs_id = ?,oDevamsizlik = ?,oEmail = ? WHERE id = ?");
                                                    $upup->execute(array($adsoyad, $kurs, $devamsizlik, $email,$idysi));
                                                    if ($upup) {
                                                        ?>
                                                        <div class="alert alert-success"><strong>Başarılı!</strong>
                                                            Veriler başarıyla güncellendi!
                                                        </div> <?php
                                                    } else {
                                                        ?>
                                                        <div class="alert alert-danger"><strong>HATA!</strong> Veriler
                                                            güncellenirken bir hata oluştu!
                                                        </div> <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div> <?php
                                                }

                                        }else {

                                        ?><div class="alert alert-danger"><strong>HATA!</strong> Böyle bir kullanıcı yok!</div> <?php   }}
                                        else {
                                            ?><div class="alert alert-danger"><strong>HATA!</strong> Yetkiniz yetersiz!</div> <?php
                                        }
                                        }else {
                        if (@$_GET["idsi"]) {
                        if ($_SESSION["yetki"] > 0) {
                            $ogrencid = trim(strip_tags($_GET["idsi"]));
                            $varmi = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                            $varmi->execute(array($ogrencid));
                            if ($varmi->rowCount() > 0) {
                                $ooo = $varmi->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <h1><span class="fa fa-user" style="color:#269abc"></span> Öğrenci Bilgi Görüntüleme</h1>
                                <hr>
                                <form class="form-horizontal" method="post" action="">
                                    <input type="text" class="form-control" name="adi" id="adi" value="<?php echo $ooo["oAd"]; ?>"
                                           required/><br/>
                                    <input type="number" name="devam" id="devam" class="form-control" value="<?php echo $ooo["oDevamsizlik"]; ?>" min="0" max="14" step="1" required/><br/>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="<?php echo $ooo["oEmail"]; ?>" required/><br/>
                                    <select class="form-control" name="kurs" id="kurs">
                                        <option value="">Kurs seçiniz</option>
                                        <?php
                                        $hendrik = $db->query("SELECT * FROM kurslar");
                                        foreach ($hendrik as $vv) {
                                            ?>
                                            <option value="<?php echo $vv["id"]; ?>" <?php
                                            $kursv = $db->prepare("SELECT * FROM ogrenciler WHERE id = ?");
                                            $kursv->execute(array($ogrencid));
                                            $kk = $kursv->fetch(PDO::FETCH_ASSOC);
                                            if ($kk["kurs_id"] == $vv["id"]) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $vv["dAdi"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <input class="btn btn-block btn-info" style="margin-top:10px;" type="submit"
                                           value="Güncelle"/>
                                </form>
                                <br/>
                                <br/>
                            <?php }
                        }else {
                            ?><div class="alert alert-danger"><strong>HATA!</strong> Yetkiniz yetersiz!</div> <?php
                        }
                        }}
                                        break;
                                    default;
                                        break;
                                }
                            }
                            $idd = $_SESSION["kidd"];
                            $ara = $db->query("SELECT * FROM kurslar WHERE dEgitmen = '$idd' LIMIT 1");
                            if ($ara->rowCount() > 0) {
                                $kveri = $ara->fetch(PDO::FETCH_ASSOC);
                                $kursidsi = $kveri["id"];
                                $dersadi = $kveri["dAdi"];
                                $dersuresi = $kveri["dSure"];
                                $devamhakki = $dersuresi*20/100;
                                $devamhakki = ceil($devamhakki);
                                $yil = $kveri["dBgyil"]."-".$kveri["dBtyil"];
                                $kursadi = $dersadi." ".$yil;
                                ?>
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><h4><?php echo $kursadi; ?></h4></div>
                                    <div class="panel-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Ad Soyad</th>
                                        <th>Devamsızlık</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    <?php
                                        $listele = $db->query("SELECT * FROM ogrenciler WHERE kurs_id = '$kursidsi'");
                                    if ($listele->rowCount() > 0){
                                        foreach ($listele as $dd) {
                                            ?><?php
                                                $devameksi1 = $devamhakki-1;
                                                if ($dd["oDevamsizlik"] >= $devamhakki) {
                                                   ?><tr class="danger"><?php
                                                }elseif ($dd["oDevamsizlik"] == $devameksi1) {
                                                    ?><tr class="info"><?php
                                                }else {
                                                    ?><tr><?php
                                                }
                                            ?>

                                                <td><?php echo $dd["id"]; ?></td>
                                                <td><?php echo $dd["oAd"]; ?></td>
                                                <td><a href="index.php?p=devam&islem=detay&idsi=<?php echo $dd["id"]; ?>" title="Detaylı incele"><?php echo $dd["oDevamsizlik"]; ?></a></td>
                                                <td><a href="index.php?p=devam&islem=remove&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-remove" style="color:red;font-size:22px;" title="Öğrenciyi sil"></span></a>&nbsp;&nbsp;<a href="index.php?p=devam&islem=dinsert&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-plus-circle" style="color:green;font-size:22px;" title="Devamsızlık ekle"></span></a>&nbsp;&nbsp;<a href="index.php?p=devam&islem=info&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-tag" style="color:darkblue;font-size:22px;" title="Bilgileri görüntüle"></span></a> </td>
                                            </tr>
                                            <?php
                                    }}else {
                                        ?><div class="alert alert-danger"><strong>ÜZGÜNÜM!</strong> Derse kayıtlı öğrenci bulunmamakta.</div> <?php
                                    }
                                    ?>
                                </table>
                                    </div></div>
                                <?php

                            }else {
                                $yara = $db->query("SELECT * FROM kurslar WHERE dYardimci = '$idd' LIMIT 1");
                                if ($yara->rowCount() > 0) {

                                }else {
                                    $yetki = $_SESSION["yetki"];
                                    if ($yetki == 3){
                                        ?> <div class="alert alert-success"><strong>Kurs Birimi Yetkili Girişi</strong></div>
                                    <?php
                                        $kurslarisay = $db->query("SELECT * FROM kurslar");
                                        foreach ($kurslarisay as $kk) {
                                            $kursidsi = $kk["id"];
                                            $kursadi = $kk["dAdi"];
                                            $devamhakki = $kk["dSure"];
                                            $devamhakki = $devamhakki * 20;
                                            $devamhakki = $devamhakki / 100;
                                            $devamhakki = ceil($devamhakki);

                                            ?>
                                            <div class="panel panel-primary">
                                                <div class="panel-heading"><h4><?php echo $kursadi; ?></h4></div>
                                                <div class="panel-body">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ad Soyad</th>
                                                            <th>Devamsızlık</th>
                                                            <th>İşlemler</th>
                                                        </tr>
                                                        <?php
                                                        $listele = $db->query("SELECT * FROM ogrenciler WHERE kurs_id = '$kursidsi'");
                                                        if ($listele->rowCount() > 0){
                                                            foreach ($listele as $dd) {
                                                                ?><?php
                                                                $devameksi1 = $devamhakki-1;
                                                                if ($dd["oDevamsizlik"] > $devamhakki) {
                                                                    ?><tr class="danger"><?php
                                                                }elseif ($dd["oDevamsizlik"] == $devameksi1) {
                                                                    ?><tr class="info"><?php
                                                                }else {
                                                                    ?><tr><?php
                                                                }
                                                                ?>

                                                                <td><?php echo $dd["id"]; ?></td>
                                                                <td><?php echo $dd["oAd"]; ?></td>
                                                                <td><a href="index.php?p=devam&islem=detay&idsi=<?php echo $dd["id"]; ?>" title="Detaylı incele"><?php echo $dd["oDevamsizlik"]; ?></a></td>
                                                                <td><a href="index.php?p=devam&islem=remove&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-remove" style="color:red;font-size:22px;" title="Öğrenciyi sil"></span></a>&nbsp;&nbsp;<a href="index.php?p=devam&islem=dinsert&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-plus-circle" style="color:green;font-size:22px;" title="Devamsızlık ekle"></span></a>&nbsp;&nbsp;<a href="index.php?p=devam&islem=info&idsi=<?php echo $dd["id"]; ?>"><span class="fa fa-tag" style="color:darkblue;font-size:22px;" title="Bilgileri görüntüle"></span></a> </td>
                                                                </tr>
                                                                <?php
                                                            }}else {
                                                            ?><div class="alert alert-danger"><strong>ÜZGÜNÜM!</strong> Derse kayıtlı öğrenci bulunmamakta.</div> <?php
                                                        }
                                                        ?>
                                                    </table>
                                                </div></div>
                                            <?php

                                        }
                                        ?>

                                        <?php
                                    }else {
                                    ?>
                                    <div class="alert alert-danger"><strong>HATA!</strong> Eğitmen veya yardımcı eğitmen olduğunuz bir ders bulunmamaktadır!</div>
                                    <?php
                                    }
                                }
                            }
                        ?>
                    </div>
                <?php
                }else {
                    ?>
                    <div class="container">
                        <div class="alert alert-danger">Bu sayfaya giriş yetkiniz bulunmamaktadır!</div>
                    </div>
                    <?php
                }
                break;
            case "ogrenciekle";
                ?>
                    <div class="container">
                <?php
                if (@$_SESSION["yetki"] >= 2) {
                    if ($_POST) {
                        $ad = strip_tags(trim($_POST["ad"]));
                        $soyad = strip_tags(trim($_POST["soyad"]));
                        $email = strip_tags(trim($_POST["email"]));
                        $kursii = strip_tags(trim($_POST["kurs"]));
                        if(!empty($ad) && !empty($soyad) && !empty($email) && !empty($kursii)) {
                            $adsoyar = $ad." ".$soyad;
                            $arastir = $db->prepare("SELECT * FROM ogrenciler WHERE oAd = ? && kurs_id = ?");
                            $arastir->execute(array($adsoyar,$kursii));
                            if ($arastir->rowCount() > 0) {
                                ?>  <div class="alert alert-danger"><strong>HATA!</strong> Bu öğrenci bu derse zaten kayıtlı!</div> <?php
                            }else {
                                $ekleyen = $_SESSION["kidd"];
                                $resim = "Resim sistemi devre dışı!";
                                $devaaam = 0;
                                $kaydet = $db->prepare("INSERT INTO ogrenciler SET oAd = ?, kurs_id = ?, oDevamsizlik = ?, oEmail = ?, oResim = ?, oEkleyen = ?");
                                $kaydet->execute(array($adsoyar,$kursii,$devaaam,$email,$resim,$ekleyen));
                                if ($kaydet) {
                                    ?><div class="alert alert-success"><strong>Başarılı!</strong> Öğrenci başarıyla eklendi.</div> <?php
                                }else {
                                    ?><div class="alert alert-danger"><strong>Başarısız!</strong> Öğrenci veritabanına eklenirken bir hata oluştu.</div> <?php
                                }
                            }

                        }else {
                           ?>
                            <div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div>
                            <?php
                        }
                    }else {
                        ?>
                        <h1><span class="fa fa-graduation-cap"></span> Öğrenci Ekle</h1><hr>
                        <form class="form-horizontal" method="post" action="">
                            <input type="text" class="form-control" name="ad" id="ad" placeholder="İsim" required /><br />
                            <input type="text" class="form-control" name="soyad" id="soyad" placeholder="Soyisim" required /><br />
                            <input type="email" class="form-control" name="email" id="email" placeholder="bk@egebk.com" required /><br />
                            <select class="form-control" name="kurs" id="kurs">
                                <option value="">Kurs Seçiniz</option>
                                <?php
                                    $kurscek = $db->query("SELECT * FROM kurslar");
                                    foreach ($kurscek as $kurs) {
                                        ?><option value="<?php echo $kurs["id"]; ?>"><?php echo $kurs["dAdi"]." ".$kurs["dBgyil"]." ".$kurs["dBtyil"]; ?></option><?php
                                    }
                                ?>
                            </select>
                            <input class="btn btn-block btn-primary" style="margin-top:10px;" type="submit" value="Öğrenci Ekle" />
                        </form>
                        <?php
                    }
                }else {
                    ?><div class="alert alert-danger"><strong>Hata!</strong> Bu sayfaya giriş yetkiniz bulunmamaktadır!</div> <?php
                }?>
                </div><?php
                break;
            case "kurslar";
            ?> <div class="container"><?php
                if (@$_SESSION["yetki"] > 3){
                    if (@$_GET["sil"]) {
                        $xx = trim(strip_tags($_GET["sil"]));
                        if (is_numeric($xx)) {
                            $sss = $db->prepare("DELETE FROM kurslar WHERE id = ?");
                            $sss->execute(array($xx));
                            if ($sss) {
                                ?><div class="alert alert-success"><strong>Başarılı!</strong> Kurs başarıyla silindi.</div> <?php
                            }else {
                                ?><div class="alert alert-danger"><strong>Başarısız!</strong> Kurs silinirken bir hata oluştu!</div> <?php
                            }
                        }
                    }
                    if (@$_GET["guncelle"]) {
                        $zz = trim(strip_tags($_GET["guncelle"]));
                        if (is_numeric($zz)) {
                            if ($_POST){
                                $daa = strip_tags(trim($_POST["dersadi"]));
                                $dsure = strip_tags(trim($_POST["dsure"]));
                                $baslangic = strip_tags(trim($_POST["byil"]));
                                $bitis = strip_tags(trim($_POST["btsyil"]));
                                $dee = strip_tags(trim($_POST["egitmen"]));
                                $dye = strip_tags(trim($_POST["yegitmen"]));
                                if (!empty($daa) && !empty($dsure) && !empty($baslangic) && !empty($bitis) && !empty($dee) && !empty($dye)) {
                                    if (!is_numeric($dsure)) {
                                        ?><div class="alert alert-danger"><strong>HATA!</strong> Ders süresi sayı olarak yazılmalıdır!</div> <?php
                                    }else {
                                        if (is_numeric($baslangic) && is_numeric($bitis)) {
                                            if (strlen($baslangic) == 4 && strlen($bitis) == 4) {
                                                $kkke = $db->prepare("UPDATE kurslar SET dAdi = ?, dSure = ?, dEgitmen = ?, dYardimci = ?, dBgyil = ?, dBtyil = ? WHERE id=?");
                                                $kkke->execute(array($daa,$dsure,$dee,$dye,$baslangic,$bitis,$zz));
                                                if ($kkke) {
                                                    ?><div class="alert alert-success"><strong>Başarılı!</strong> Kurs Başarıyla güncellendi!</div> <?php
                                                }else {
                                                    ?><div class="alert alert-danger"><strong>Başarısız!</strong> Kurs güncellenirken bir hata oluştu!</div> <?php
                                                }
                                            }else {
                                                ?><div class="alert alert-danger"><strong>HATA!</strong> Başlangıç ve bitiş yılı 4 uzunluğu geçemez!</div> <?php
                                            }
                                        }else {
                                            ?><div class="alert alert-danger"><strong>HATA!</strong> Başlangıç ve bitiş yılı sayı olarak yazılmalıdır!</div> <?php
                                        }

                                    }
                                }else {
                                    ?><div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div> <?php
                                }
                            }
                            $cee = $db->prepare("SELECT * FROM kurslar WHERE id=? LIMIT 1");
                            $cee->execute(array($zz));
                            if ($cee->rowCount() > 0) {
                                $cee = $cee->fetch(PDO::FETCH_ASSOC);

                                ?>
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><?php echo $cee["dAdi"]." ".$cee["dBgyil"]."-".$cee["dBtyil"]; ?> Güncelle</div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" method="post" action="">
                                            <input type="text" class="form-control" name="dersadi" id="dersadi"
                                                   value="<?php echo $cee["dAdi"]; ?>" required/><br/>
                                            <input type="number" class="form-control" name="dsure" id="dsure"
                                                   value="<?php echo $cee["dSure"]; ?>" required/><br/>
                                            <input type="text" class="form-control" name="byil" id="byil"
                                                   value="<?php echo $cee["dBgyil"]; ?>" required/><br/>
                                            <input type="text" class="form-control" name="btsyil" id="btsyil"
                                                   value="<?php echo $cee["dBtyil"]; ?>" required/><br/>
                                            <select class="form-control" name="egitmen" id="egitmen" required>
                                                <option value="">Eğitmen Seçiniz</option>
                                                <?php
                                                $eebul = $db->query("SELECT * FROM users WHERE yetki >= 2");
                                                foreach ($eebul as $ees) {
                                                    ?>
                                                    <option
                                                    value="<?php echo $ees["id"]; ?>" <?php
                                                        if ($ees["id"] == $cee["dEgitmen"]) {
                                                            echo "selected";
                                                        }
                                                    ?>><?php echo $ees["uAS"]; ?></option><?php
                                                }
                                                ?>
                                            </select><br/>
                                            <select class="form-control" name="yegitmen" id="yegitmen" required>
                                                <option value="">Yardımcı Eğitmen Seçiniz</option>
                                                <?php
                                                $e2bul = $db->query("SELECT * FROM users WHERE yetki >= 1");
                                                foreach ($e2bul as $ee2) {
                                ?>
                                <option
                                value="<?php echo $ee2["id"]; ?>" <?php
                                if ($ee2["id"] == $cee["dYardimci"]) {
                                    echo "selected";
                                }
                                ?>><?php echo $ee2["uAS"]; ?></option><?php
                            }
                            ?>
                                            </select>
                                            <input class="btn btn-block btn-primary" style="margin-top:10px;"
                                                   type="submit" value="Kurs Güncelle"/>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }else {
                                ?><div class="alert alert-danger">Böyle bir kurs bulunmamakta!</div> <?php
                            }
                        }
                    }
                    ?>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Kurslar</div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th>Ders adı</th>
                                        <th>Eğitmen</th>
                                        <th>Y. Eğitmen</th>
                                        <th>Ders süresi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    <?php
                                        $kursa = $db->query("SELECT * FROM kurslar");
                                    foreach ($kursa as $zi) {
                                        ?>
                                        <tr>
                                            <td><?php echo $zi["id"]; ?></td>
                                            <td><strong><?php echo $zi["dAdi"] . " " . $zi["dBgyil"] . "-" . $zi["dBtyil"]; ?></strong></td>
                                            <?php
                                                $ebul = $db->prepare("SELECT * FROM users WHERE id = ?");
                                                $ebul->execute(array($zi["dEgitmen"]));
                                                $yebul = $db->prepare("SELECT * FROM users WHERE id = ?");
                                                $yebul->execute(array($zi["dYardimci"]));
                                                $ea = $ebul->fetch(PDO::FETCH_ASSOC);
                                                $ye = $yebul->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <td><?php echo $ea["uAS"]; ?></td>
                                            <td><?php echo $ye["uAS"]; ?></td>
                                            <td><?php echo $zi["dSure"]; ?></td>
                                            <td><a href="index.php?p=kurslar&sil=<?php echo $zi["id"]; ?>" title="Sil"><span class="fa fa-remove" style="color:red;"></span> </a>&nbsp;&nbsp; <a href="index.php?p=kurslar&guncelle=<?php echo $zi["id"]; ?>" title="Güncelle"><span class="fa fa-cogs" style="color:darkblue;"></span></a> </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                    <?php
                }else {
                    ?><div class="alert alert-danger"><strong>Hata!</strong> Bu sayfaya giriş yetkiniz bulunmamaktadır!</div> <?php
                }
                ?>
                </div><?php
                break;
            case "kursekle";
                ?><div class="container"> <?php
                if ($_SESSION["yetki"] > 3){
                    if ($_POST) {
                        $daa = strip_tags(trim($_POST["dersadi"]));
                        $dsure = strip_tags(trim($_POST["dsure"]));
                        $baslangic = strip_tags(trim($_POST["byil"]));
                        $bitis = strip_tags(trim($_POST["btsyil"]));
                        $dee = strip_tags(trim($_POST["egitmen"]));
                        $dye = strip_tags(trim($_POST["yegitmen"]));
                        if (!empty($daa) && !empty($dsure) && !empty($baslangic) && !empty($bitis) && !empty($dee) && !empty($dye)) {
                            if (!is_numeric($dsure)) {
                                ?><div class="alert alert-danger"><strong>HATA!</strong> Ders süresi sayı olarak yazılmalıdır!</div> <?php
                            }else {
                                if (is_numeric($baslangic) && is_numeric($bitis)) {
                                    if (strlen($baslangic) == 4 && strlen($bitis) == 4) {
                                        $kkke = $db->prepare("INSERT INTO kurslar SET dAdi = ?, dSure = ?, dEgitmen = ?, dYardimci = ?, dBgyil = ?, dBtyil = ?");
                                        $kkke->execute(array($daa,$dsure,$dee,$dye,$baslangic,$bitis));
                                        if ($kkke) {
                                            ?><div class="alert alert-success"><strong>Başarılı!</strong> Kurs Başarıyla eklendi!</div> <?php
                                        }else {
                                            ?><div class="alert alert-danger"><strong>Başarısız!</strong> Kurs eklenirken bir hata oluştu!</div> <?php
                                        }
                                    }else {
                                        ?><div class="alert alert-danger"><strong>HATA!</strong> Başlangıç ve bitiş yılı 4 uzunluğu geçemez!</div> <?php
                                    }
                                }else {
                                    ?><div class="alert alert-danger"><strong>HATA!</strong> Başlangıç ve bitiş yılı sayı olarak yazılmalıdır!</div> <?php
                                }

                            }
                        }else {
                        ?><div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div> <?php
                        }
                    }else {
                        ?>
                        <h1><span class="fa fa-plus"></span> Kurs Ekle</h1><hr>
                        <form class="form-horizontal" method="post" action="">
                            <input type="text" class="form-control" name="dersadi" id="dersadi" placeholder="Ders Adı" required /><br />
                            <input type="number" class="form-control" name="dsure" id="dsure" placeholder="Ders Suresi" required /><br />
                            <input type="text" class="form-control" name="byil" id="byil" placeholder="Başlangıç Yılı" required /><br />
                            <input type="text" class="form-control" name="btsyil" id="btsyil" placeholder="Bitiş Yılı" required /><br />
                            <select class="form-control" name="egitmen" id="egitmen" required>
                                <option value="">Eğitmen Seçiniz</option>
                                <?php
                                $eebul = $db->query("SELECT * FROM users WHERE yetki >= 2");
                                foreach ($eebul as $ees) {
                                    ?> <option value="<?php echo $ees["id"]; ?>"><?php echo $ees["uAS"]; ?></option><?php
                                }
                                ?>
                            </select><br />
                            <select class="form-control" name="yegitmen" id="yegitmen" required>
                                <option value="">Yardımcı Eğitmen Seçiniz</option>
                                <?php
                                $e2bul = $db->query("SELECT * FROM users WHERE yetki >= 1");
                                foreach ($e2bul as $ee2) {
                                    ?> <option value="<?php echo $ee2["id"]; ?>"><?php echo $ee2["uAS"]; ?></option><?php
                                }
                                ?>
                            </select>
                            <input class="btn btn-block btn-primary" style="margin-top:10px;" type="submit" value="Kurs Ekle" />
                        </form>
                        <?php
                    }
                }else {
                    ?><div class="alert alert-danger"><strong>HATA!</strong> Bu alana giriş yetkiniz bulunmamaktadır!</div> <?php
                }
        ?></div><?php
                break;
            case "yetkililer";
                ?>
                    <div class="container">
                        <?php
                            if ($_SESSION["yetki"] < 4){
                                ?>
                                    <div class="alert alert-danger"><strong>HATA!</strong> Buraya girmek için yetkiniz yetersizdir.</div>
                                <?php
                            }else {
                                if (@$_GET["sil"]) {
                                    $si = trim(strip_tags($_GET["sil"]));
                                    if (is_numeric($si)) {
                                        $sx = $db->prepare("DELETE FROM users WHERE id = ?");
                                        $sx->execute(array($si));
                                        if ($sx){
                                            ?> <div class="alert alert-success"><strong>BAŞARILI!</strong> Yetkili başarıyla silindi.</div> <?php
                                        }else {
                                            ?> <div class="alert alert-danger"><strong>HATA!</strong> Yetkili silinirken bir hata oluştu.</div> <?php
                                        }
                                    }
                                }
                                if (@$_GET["duzenle"]) {
                                    $dz = trim(strip_tags($_GET["duzenle"]));
                                    if (is_numeric($dz)) {
                                        if ($_POST){
                                            $ids = trim(strip_tags($_POST["ids"]));
                                            $ka = trim(strip_tags($_POST["kulad"]));
                                            $ks = trim(strip_tags($_POST["sifre"]));
                                            $ad = trim(strip_tags($_POST["ad"]));
                                            $em = trim(strip_tags($_POST["email"]));
                                            $yt = trim(strip_tags($_POST["yetki"]));

                                            if (!empty($ka) && !empty($ad) && !empty($em) && !empty($yt)) {
                                                if (empty($ks)) {
                                                    $sss = $db->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
                                                    $sss->execute(array($dz));
                                                    $xc = $sss->fetch(PDO::FETCH_ASSOC);
                                                    $ks = $xc["uSifre"];
                                                }else {
                                                    $ks = md5(md5($ks));
                                                }
                                                $yukle = $db->prepare("UPDATE users SET uKadi =?,uSifre=?,uAS=?,uEmail=?,yetki=? WHERE id = ?");
                                                $yukle->execute(array($ka,$ks,$ad,$em,$yt,$ids));
                                                if ($yukle){
                                                    ?>

                                                        <div class="alert alert-success"><strong>Başarılı!</strong> Yetkili başarıyla güncellendi.</div>
                                                    <?php
                                                }else {
                                                    ?>
                                                    <div class="alert alert-danger"><strong>HATA!</strong> Yetkili başarıyla güncellenemedi.</div>
                                                    <?php
                                                }
                                            }else {
                                                ?>
                                                <div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div>
                                                <?php
                                            }
                                        }
                                        $enayyi = $db->prepare("SELECT * FROM users WHERE id=? LIMIT 1");
                                        $enayyi->execute(array($dz));
                                        $ll = $enayyi->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="panel panel-info">
                                                <div class="panel-heading"><?php echo $ll["uAS"]; ?> bilgileri
                                                </div>;
                                            <div class="panel-body">
                                                    <form class="form-horizontal" method="post" action="">
                                                        <input type="text" class="hidden" name="ids" id="ids" value="<?php echo $ll["id"]; ?>" required />
                                                        <input type="text" class="form-control" name="kulad" id="kulad"
                                                               value="<?php echo $ll["uKadi"]; ?>" required/><br/>
                                                        <small>*Sifre degismeyecek ise boş bırakın!</small>
                                                        <input type="password" class="form-control" name="sifre"
                                                               id="sifre" placeholder="******"/><br/>
                                                        <input type="text" class="form-control" name="ad" id="ad"
                                                               value="<?php echo $ll["uAS"]; ?>" required/><br/>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                               value="<?php echo $ll["uEmail"]; ?>" required/><br/>
                                                        <select class="form-control" name="yetki" id="yetki">
                                                            <option value="0" <?php if ($ll["yetki"] == 0) {
                                                echo "selected";
                                            } ?>>Eski Üye
                                            </option>
                                            <option value="1" <?php if ($ll["yetki"] == 1) {
                                                echo "selected";
                                            } ?>>Yardımcı Eğitmen
                                            </option>
                                            <option value="2" <?php if ($ll["yetki"] == 2) {
                                                echo "selected";
                                                            } ?>>Eğitmen
                                                            </option>
                                                            <option value="3" <?php if ($ll["yetki"] == 3) {
                                                                echo "selected";
                                                            } ?>>Yetkili
                                                            </option>
                                                            <option value="4" <?php if ($ll["yetki"] == 4) {
                                                                echo "selected";
                                                            } ?>>Başkan
                                                            </option>
                                                        </select>
                                                        <input class="btn btn-block btn-primary"
                                                               style="margin-top:10px;" type="submit"
                                                               value="Yetkili Guncelle"/>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                }
                                ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading"><strong><h4>Yetkililer</h4></strong></div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <td>#</td>
                                        <td>Kullanıcı Adı</td>
                                        <td>Adı soyadı</td>
                                        <td>Yetkisi</td>
                                        <td>İşlemler</td>
                                    </tr>
                                    <?php
                                        $yetcek = $db->query("SELECT * from users ORDER BY yetki DESC");
                                        foreach ($yetcek as $yetkili) {
                                            ?>
                                            <tr>
                                                <td><?php echo $yetkili["id"]; ?></td>
                                                <td><a href="index.php?p=yetkililer&duzenle=<?php echo $yetkili["id"]; ?>"><?php echo $yetkili["uKadi"]; ?></a></td>
                                                <td><strong><?php echo $yetkili["uAS"]; ?></strong></td>
                                                <td><?php
                                                    $yy = $yetkili["yetki"];
                                                    if ($yy == 0){
                                                        echo "Eski Üye";
                                                    }
                                                    if ($yy == 1){
                                                        echo "Yardımcı Eğitmen";
                                                    }
                                                    if ($yy == 2){
                                                        echo "Eğitmen";
                                                    }
                                                    if ($yy == 3){
                                                        echo "Yetkili";
                                                    }
                                                    if ($yy == 4){
                                                        echo "Başkan";
                                                    }
                                                    ?></td>
                                                <td><a href="index.php?p=yetkililer&sil=<?php echo $yetkili["id"]; ?>"><span class="fa fa-remove" style="color:darkred;"></span> </a> </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </table>

                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php
                break;
            case "yetkiliekle";
                ?>

                    <div class="container">
                        <?php
                        if ($_SESSION["yetki"] > 3){
                        if ($_POST) {
                            $gkad = strip_tags(trim($_POST["kulad"]));
                            $gsif = strip_tags(trim($_POST["sifre"]));
                            $gad = strip_tags(trim($_POST["ad"]));
                            $gsad = strip_tags(trim($_POST["soyad"]));
                            $gmail = strip_tags(trim($_POST["email"]));
                            $gyet = strip_tags(trim($_POST["yetki"]));
                            if (!empty($gkad) && !empty($gsif) && !empty($gad) && !empty($gsad) && !empty($gmail) && !empty($gyet)){
                                $sordur = $db->query("SELECT * FROM users WHERE uKadi = '$gkad'");
                                if ($sordur->rowCount() > 0) {
                                    ?>
                                    <div class="alert alert-danger"><strong>HATA!</strong> Böyle bir yetkili zaten var!</div>
                                    <?php
                                }else {
                                    $ss = md5(md5($gsif));
                                    $aa = $gad . " " . $gsad;
                                    $dd = $db->prepare("INSERT INTO users SET uKadi = ?,uSifre = ?,uAS = ?,uEmail = ?,yetki = ?");
                                    $dd->execute(array($gkad, $ss, $aa, $gmail, $gyet));
                                    if ($dd) {
                                        ?>
                                        <div class="alert alert-success">Yetkili başarıyla eklendi!</div>
                                        <?php

                                    } else {
                                        ?>
                                        <div class="alert alert-warning">Yetkili ekleme işleminde bir hatayla
                                            karşılaşıldı!
                                        </div>
                                        <?php
                                    }
                                }
                            }else {
                                ?>
                                    <div class="alert alert-danger"><strong>HATA!</strong> Alanlar boş olamaz!</div>
                                <?php
                            }
                        }else {
                            ?>
                        <h1><span class="fa fa-user-plus"></span> Yetkili Ekle</h1><hr>
                        <form class="form-horizontal" method="post" action="">
                            <input type="text" class="form-control" name="kulad" id="kulad" placeholder="Kullanıcı Adı" required /><br />
                            <input type="password" class="form-control" name="sifre" id="sifre" placeholder="Şifre" required /><br />
                            <input type="text" class="form-control" name="ad" id="ad" placeholder="İsim" required /><br />
                            <input type="text" class="form-control" name="soyad" id="soyad" placeholder="Soyisim" required /><br />
                            <input type="email" class="form-control" name="email" id="email" placeholder="bk@egebk.com" required /><br />
                            <select class="form-control" name="yetki" id="yetki">
                                <option value="">Yetki Seçiniz</option>
                                <option value="0">Eski Üye</option>
                                <option value="1">Yardımcı Eğitmen</option>
                                <option value="2">Eğitmen</option>
                                <option value="3">Yetkili</option>
                                <option value="4">Başkan</option>
                            </select>
                            <input class="btn btn-block btn-primary" style="margin-top:10px;" type="submit" value="Yetkili Ekle" />
                        </form>
                    <?php } }else {
                            ?>
                                <div class="alert alert-danger">Bu sayfaya giriş yetkiniz bulunmamaktadır!</div>
                            <?php
                        } ?>
                    </div>

                <?php
                break;
            default;


    ?>
    <div class="container">
    	<div class="panel panel-primary">
        	<div class="panel-body">
            	<strong>Ege Üniversitesi Bilgisayar Kulübü</strong> kurs birimi yoklama sistemine hoşgeldiniz. Yoklama sistemi Ege Üniversitesi Bilgisayar Kulübü için hazırlanmış bir online yoklama sistemidir.<br /><br />İyi çalışmalar dileriz.
            </div>
        </div>
        <?php
         // Baskana ozel :)
         if ($_SESSION["yetki"] > 3) {
             if ($_POST) {
                 $temas = trim(strip_tags($_POST["tema"]));
                 if (is_numeric($temas)) {
                     $gg = $db->prepare("UPDATE tema SET tID = ? WHERE id = ?");
                     $gg->execute(array($temas,1));
                     if ($gg) {
                         ?><div class="alert alert-success"><strong>Başarılı!</strong> Sistem teması başarıyla güncellendi.</div> <?php
                     }else {
                         ?><div class="alert alert-alert"><strong>Başarısız!</strong> Tema güncellemesi sırasında bir</div> <?php
                     }
                 }
             }
             ?>
                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Sistem Ayarları</strong></div>
                    <div class="panel-body">
                        <?php

                            if (@$_GET["yonet"]){
                                $ybtn = strip_tags(trim($_GET["yonet"]));
                                switch($ybtn){
                                    case "ac";
                                        $sac = $db->query("UPDATE ayarlar SET ayarDurum=1 WHERE ayarId=1");
                                        if ($sac) {
                                            ?><div class="alert alert-success"><strong>Başarılı!</strong> Sistem başarıyla açıldı.</div> <?php
                                        }else {
                                            ?> <div class="alert alert-alert"><strong>Hata!</strong> Sistem açılırken bir hata oluştu!</div> <?php
                                        }
                                        break;
                                    case "kapat";
                                        $skapat = $db->query("UPDATE ayarlar SET ayarDurum=0 WHERE ayarId=1");
                                        if ($skapat) {
                                            ?><div class="alert alert-success"><strong>Başarılı!</strong> Sistem başarıyla kapatıldı.</div> <?php
                                        }else {
                                            ?> <div class="alert alert-alert"><strong>Hata!</strong> Sistem kapatılırken bir hata oluştu!</div> <?php
                                        }
                                        break;
                                    default;
                                        ?>
                                            <div class="alert alert-danger"><strong>HATA!</strong> Sisteme hatali bir giris yapildi.</div>
                                        <?php
                                        break;
                                }
                            }

                        ?>
                        <div class="col-md-12"></div>
                        <div class="col-md-2 col-sm-8"><strong>Devamsizlik Kontrol Sistemi :</strong></div>
                        <div class="col-md-10 col-sm-4">
                            <?php
                                $drmcek = $db->query("SELECT * FROM ayarlar WHERE ayarId=1");
                                $drmcek = $drmcek->fetch(PDO::FETCH_ASSOC);
                                if ($drmcek["ayarDurum"] >0) {
                                    ?>
                                        <form method="get" action="">
                                            <button class="btn btn-danger" name="yonet" value="kapat">Kapat</button>
                                        </form>
                                    <?php
                                }else {
                                    ?>  <form action="" method="get">
                                        <button class="btn btn-success" name="yonet" value="ac">Aç</button></form>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-12" style="margin-top: 15px;"></div>
                        <div class="col-md-2 col-sm-8"><strong>Sistem Teması :</strong></div>
                        <div class="col-md-10 col-sm-4">
                            <form action="" method="post">
                                <?php $temab = $db->query("SELECT * FROM tema WHERE id = 1");
                                $temab = $temab->fetch(PDO::FETCH_ASSOC);

                                ?>
                                <select class="form-control" name="tema">
                                    <option value="0" <?php if ($temab["tID"] == 0 ) {echo "selected"; }?>>Default</option>
                                    <option value="1" <?php if ($temab["tID"] == 1 ) {echo "selected"; }?>>Cerulean</option>
                                    <option value="2" <?php if ($temab["tID"] == 2 ) {echo "selected"; }?>>Cosmo</option>
                                    <option value="3" <?php if ($temab["tID"] == 3 ) {echo "selected"; }?>>Cyborg</option>
                                    <option value="4" <?php if ($temab["tID"] == 4 ) {echo "selected"; }?>>Darkly</option>
                                    <option value="5" <?php if ($temab["tID"] == 5 ) {echo "selected"; }?>>Flatly</option>
                                    <option value="6" <?php if ($temab["tID"] == 6 ) {echo "selected"; }?>>Journal</option>
                                    <option value="7" <?php if ($temab["tID"] == 7 ) {echo "selected"; }?>>Lumen</option>
                                    <option value="8" <?php if ($temab["tID"] == 8 ) {echo "selected"; }?>>Super Hero</option>
                                    <option value="9" <?php if ($temab["tID"] == 9 ) {echo "selected"; }?>>United</option>
                                </select>
                                <br>
                                <button class="btn btn-success btn-block"> Temayı Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
             <?php
         }
        ?>
    </div>
    <?php
        break;
        } ?>

    <hr />
    <br />
    <footer>
    <div class="container" style="text-align:center;">
    	Bu uygulama <a href="http://www.egebk.org" target="_blank">Ege Üniversitesi Bilgisayar Kulübü</a> tarafından hazırlanmıştır.
    </div></footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>