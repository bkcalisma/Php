<?php
    @session_start();
	include("baglan.php");
if (!isset($_SESSION["bkys"])) {
	if($_POST) {
            $gkad = strip_tags(trim($_POST["kad"]));
            $gsif = strip_tags(trim($_POST["sif"]));
            $veri = $db->prepare("SELECT * FROM users WHERE uKadi=?");
            $veri->execute(array($gkad));
            if ($veri->rowCount() > 0) {
                $aktar = $veri->fetch(PDO::FETCH_ASSOC);
                $sifrele = md5(md5($gsif));
                $as = $aktar["uSifre"];
                if ($sifrele == $as) {
                    $_SESSION["bkys"] = true;
                    $_SESSION["adsoyad"] = $aktar["uAS"];
                    $_SESSION["kadi"] = $aktar["uKadi"];
                    $_SESSION["kidd"] = $aktar["id"];
                    $_SESSION["yetki"] = $aktar ["yetki"];
                    $_SESSION["email"] = $aktar["uEmail"];
                    header("location:index.php");
                } else {
                    echo "Kullanıcı adı veya şifre hatalı!";
                }
            } else {
                echo "Böyle bir kullanıcı bulunmamaktadır!";
            }

	}
else {
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BKYS Giriş">
    <meta name="author" content="">
    <title>BK YS Giriş</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
	<script src="js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

    <div class="container">
<div class="guney" style="margin-top:200px;">
      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading" style="text-align:center;">BKYS Giriş</h2>
        <label for="inputUn" class="sr-only">Kullanıcı Adı</label>
        <input type="text"  name="kad" class="form-control" placeholder="Kullanıcı Adı" required autofocus>
        <label for="inputPassword" class="sr-only">Şifre</label>
        <input type="password"  name="sif" class="form-control" placeholder="Şifre" style="margin-top:10px;" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Giriş Yap</button>
      </form>
		</div>
    </div>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
	<?php }
    }else {
        header("location:index.php");
    }?>