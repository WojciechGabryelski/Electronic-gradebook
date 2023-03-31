<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$strona = new db($host,$dbname,$dbusr,$dbpass);
	
	$status=1;
	
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,przedmiot"))
	{
		$query="SELECT pesel FROM uczen WHERE pesel = ?";
		$osoba = $strona->query($query,array($_POST['pesel']),"Błąd pobierania danych ucznia");
		if(count($osoba)>0)
		{
			$query = "UPDATE oceny SET ocena=?, id_przedmiotu=? WHERE id=?";
			if(!$strona->update($query, array($_POST['ocena'], $_POST['przedmiot'], $_POST['id']), "Błąd edycji danych oceny"))
				$status=0;
		}
		else
			$status=2;
	}
	else
		$status=0;
	
	header("location:index.php?site=oceny&pesel=".$_POST['pesel']."&status=".$status);
	exit;
?>