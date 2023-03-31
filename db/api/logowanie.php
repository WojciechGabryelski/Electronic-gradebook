<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
    if(isset($_POST['login'])) {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
		$uprawnienia = array("uczen", "nauczyciel", "admin");
		foreach($uprawnienia AS $numer => $rodzaj) {
			$query = "SELECT * FROM ".$rodzaj." WHERE login=?";
			$zalogowany = $strona->query($query,array($login),"Błąd pobierania danych ".($rodzaj == "uczen" ? "uczniów" :
			($rodzaj == "nauczyciel" ? "nauczycieli" : "administratorów")));
			if(count($zalogowany) == 1 && password_verify($haslo, $zalogowany[0]['haslo'])) {
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['haslo'] = $haslo;
				$_SESSION['zalogowany'] = $zalogowany;
				$_SESSION['uprawnienia'] = $rodzaj;
				header('location:login.php');
				exit;
			}
        }
		header('location:login.php?status=0');
		exit;
    }
	header('location:login.php');
	exit;
?>