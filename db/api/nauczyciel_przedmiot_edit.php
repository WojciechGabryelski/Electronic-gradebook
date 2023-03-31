<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$strona = new db($host,$dbname,$dbusr,$dbpass);
	
	$status=1;
	
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,przedmiot"))
	{
		$query="SELECT pesel FROM nauczyciel WHERE pesel = ?";
		$osoba = $strona->query($query,array($_POST['pesel']),"Błąd pobierania danych nauczyciela");
		if(count($osoba)>0)
		{
			$query = "UPDATE nauczyciel_przedmiot SET id_przedmiotu=? WHERE id=?";
			if(!$strona->update($query, array($_POST['przedmiot'], $_POST['id']), "Błąd edycji relacji nauczycieli z przedmiotami"))
				$status=0;
		}
		else
			$status=2;
	}
	else
		$status=0;
	
	header("location:index.php?site=nauczyciel_przedmiot&pesel=".$_POST['pesel']."&status=".$status);
	exit;
?>