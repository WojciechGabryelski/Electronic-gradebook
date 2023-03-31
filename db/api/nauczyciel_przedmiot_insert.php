<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,przedmiot"))
	{
		$query="SELECT pesel FROM nauczyciel WHERE pesel = ?";
		$osoba = $strona->query($query,array($_POST['pesel']),"Błąd pobierania danych nauczyciela");
		if(count($osoba) == 1)
		{
			$query = "SELECT id, nazwa FROM	przedmioty WHERE id=?";
			$przedmioty = $strona->query($query, array($_POST['przedmiot']), "Błąd pobierania danych przedmiotu");
			if(count($przedmioty)==1)
			{
				$query ="INSERT INTO nauczyciel_przedmiot (pesel,id_przedmiotu) VALUES(?,?)";
				
				if(!$strona->insert($query, array($_POST['pesel'], $_POST['przedmiot']),
				"Błąd dodawania relacji między nauczycielem a przedmiotem do bazy danych"))
					$status=7;
			}
			else
				$status=4;
		}
		else
			$status=2;
	}
	else
		$status=0;
	if($status==1 || $status>=4)
		header("location:index.php?site=nauczyciel_przedmiot&pesel=".$_POST['pesel']."&status=".$status);
	else
		header("location:index.php?site=nauczyciel&status=".$status);
?>