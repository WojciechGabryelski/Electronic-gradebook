<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	if(!isset($_SESSION)) {
        session_start(); 
    }
	if(isset($_SESSION['login'])) {
		$zalogowany = $_SESSION['zalogowany'];
		$uprawnienia = $_SESSION['uprawnienia'];
		if($uprawnienia == "uczen") {
			if(!isset($uczen) || $uczen!=1) {
				header("location:index.php");
				exit;
			}
		} else if($uprawnienia == "nauczyciel") {
			if(!isset($nauczyciel) || $nauczyciel!=1) {
				header("location:index.php");
				exit;
			}
		} else if($uprawnienia == "admin") {
			if(!isset($admin) || $admin!=1) {
				header("location:index.php");
				exit;
			}
		}
	} else {
		if(!isset($logging) || $logging!=1) {
			header("location:login.php");
			exit;
		}
	}
?>