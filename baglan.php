<?php 
	try {
		$db = new PDO("mysql:host=127.0.0.1;dbname=bkys;charset=utf8;", "root" , "");
		$db->query("SET CHARACTER SET utf8");
	} catch( PDOException $e ){
		print $e->getMessage();
	}
?>