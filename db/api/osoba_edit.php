<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$strona = new db($host,$dbname,$dbusr,$dbpass);
	
	$status=1;
	if(!isset($_POST['prev_site'])) {
		header("location:index.php");
		exit;
	}
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,nazwisko,imie,data_urodzenia"))
	{
		$query= "SELECT pesel FROM ".$_POST['prev_site']." WHERE pesel = ?";
		$dane = $strona->query($query, array($_POST['pesel_stary']), "Błąd pobierania danych "
		.$_POST['prev_site']=="uczen" ? "ucznia" : ($_POST['prev_site']=="nauczyciel" ? "nauczyciela" : "administratora"));
		if(count($dane)>0)
		{
			$query = "UPDATE ".$_POST['prev_site']." SET pesel=?, imie=?, nazwisko=?, data_urodzenia=? WHERE pesel=?";
			if(!$strona->update($query, array(trim($_POST['pesel']), trim($_POST['imie']), trim($_POST['nazwisko']),
			trim($_POST['data_urodzenia']), trim($_POST['pesel_stary'])), "Błąd edycji danych "
			.$_POST['prev_site']=="uczen" ? "ucznia" : ($_POST['prev_site']=="nauczyciel" ? "nauczyciela" : "administratora")))
				$status=0;
		}
		else
			$status=2;
	}
	else
		$status=0;
	
	header("location:index.php?site=".$_POST['prev_site']."&status=".$status);
	exit;
?>