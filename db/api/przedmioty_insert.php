<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"nazwa"))
	{
		$query ="SELECT id FROM przedmioty WHERE nazwa=?";
		$dane = $strona->query($query,array($_POST['nazwa']), "Błąd sprawdzania czy przedmiot już istnieje");
		if(!isset($dane[0]['id']))
		{
			$query="INSERT INTO przedmioty (nazwa) VALUES(?)";
			if(!$strona->insert($query, array(trim($_POST['nazwa'])), "Błąd dodawania ucznia do bazy danych"))
				$status=0;
		}
		else
			$status=3;
	}
	else
		$status=0;
	
	header("location:index.php?site=przedmioty&status=".$status);
	exit;
?>