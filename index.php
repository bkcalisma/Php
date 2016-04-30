<?php
    include_once("baglan.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EGE BKYS - Bilgisayar Kulübü Yoklama Sistemi</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/ana.css" rel="stylesheet">
</head>

<body>
<?php
    $vericek = $db->prepare("SELECT * FROM ayarlar WHERE ayarId = ?");
    $vericek->execute(array(1));
    $ad = $vericek->fetch(PDO::FETCH_ASSOC);
    if ($ad["ayarDurum"] == 0) {
        ?>
            <div class="container">
                <div class="alert alert-danger">Devamsızlık kontrol sistemi yönetim tarafından kapatılmıştır.</div>
                <hr>
                <br>
                <h4 style="text-align: center"><a href="http://egebk.com">Ege Üniversitesi Bilgisayar Kulübü</a> tarafından
                    hazırlanmıştır. <br>
                    <a href="Yonetim/">Yönetim paneline gitmek için tıklayın.</a></h4>
            </div>
        <?php
    }else {

        ?>
        <div class="container">
            <?php
            if ($_POST) {
                $email = trim(strip_tags($_POST["email"]));
                if (!empty($email)) {
                    $ara = $db->prepare("SELECT * FROM ogrenciler WHERE oEmail =?");
                    $ara->execute(array($email));
                    if ($ara->rowCount()>0) {
                        $aa = $ara->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading"><?php echo $aa["oAd"]; ?> Devamsızlık Bilgisi</div>
                            <div class="panel-body">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Kurs adı</th>
                                    <th>Devamsızlık</th>
                                </tr>
                                <?php
                                $nolur = $db->prepare("SELECT * FROM ogrenciler WHERE oEmail =?");
                                $nolur->execute(array($email));
                                foreach ($nolur as $nolmaz) {
                                    $kid = $nolmaz["kurs_id"];
                                    $kbl = $db->prepare("SELECT * FROM kurslar WHERE id = ?");
                                    $kbl->execute(array($kid));
                                    $kb = $kbl->fetch(PDO::FETCH_ASSOC);
                                    $kursismi = $kb["dAdi"].' '.$kb["dBgyil"].'-'.$kb["dBtyil"];
                                    $dhakki = $kb["dSure"]*20/100;
                                    $dhakkie1 = $dhakki-1;

                                    ?>
                                    <tr<?php if ($nolmaz["oDevamsizlik"] > $dhakki) {
                                        ?> class="danger"<?php
                                    }elseif ($nolmaz["oDevamsizlik"] >= $dhakkie1){
                                    ?> class="info"<?php
                                    } ?>>
                                        <th><?php echo $nolmaz["id"]; ?></th>
                                        <th><?php echo $kursismi; ?></th>
                                        <th><?php echo $nolmaz["oDevamsizlik"]; ?></th>
                                    </tr>
                                    <?php
                                }

                                ?>
                            </table>
                            </div>
                            </div>
                        <?php
                    }else {
                        ?>
                        <div class="alert alert-danger"><strong>HATA!</strong> Sistemde böyle bir eposta adresi kayıtlı değil.</div>
                        <?php
                    }
                }else {
                    ?>
                    <div class="alert alert-danger"><strong>HATA!</strong> Alan boş olamaz.</div>
                    <?php
                }
            }
            ?>
            <form class="form-signin" action="" method="post">
                <h2 class="form-signin-heading">EGE BKYS</h2>
                <label for="inputEmail" class="sr-only">Email adresi</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email adresi" required autofocus>
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Devamsızlık Sorgula</button>
            </form>

        </div>
        <hr>
        <br>
        <h4 style="text-align: center"><a href="http://egebk.org">Ege Üniversitesi Bilgisayar Kulübü</a> tarafından
            hazırlanmıştır. <br>
            <a href="Yonetim/">Yönetim paneline gitmek için tıklayın.</a></h4>
        <?php
    }
?>
</body>
</html>
