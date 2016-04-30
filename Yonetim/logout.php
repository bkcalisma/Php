<?php
session_start();
if (isset($_SESSION["bkys"])){
	unset($_SESSION["aktoolsg"]);
	}
if(isset($_SESSION["adsoyad"])){
	unset($_SESSION["adsoyad"]);
	}
if(isset($_SESSION["yetki"])){
	unset($_SESSION["yetki"]);
	}
if(isset($_SESSION["email"])){
	unset($_SESSION["email"]);
	}

session_destroy();
header("location:login.php");
?>