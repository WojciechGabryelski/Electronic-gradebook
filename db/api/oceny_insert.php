<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,ocena,przedmiot"))
	{
		$query="SELECT pesel FROM uczen WHERE pesel = ?";
		$osoba = $strona->query($query,array($_POST['pesel']),"Błąd pobierania danych ucznia");
		if(count($osoba) == 1)
		{
			if(in_array($_POST['ocena'],$listaOcen))
			{
				$query = "SELECT id, nazwa FROM	przedmioty WHERE id=?";
				$przedmioty = $strona->query($query, array($_POST['przedmiot']), "Błąd pobierania danych przedmiotu");
				if(count($przedmioty)==1)
				{
					$query ="INSERT INTO oceny (ocena,pesel,id_przedmiotu,data) VALUES(?,?,?,?)";
					
					if(!$strona->insert($query, array($_POST['ocena'], $_POST['pesel'], $_POST['przedmiot'],
					Date("Y-m-d")), "Błąd dodawania ucznia do bazy danych"))
						$status=6;
				}
				else
					$status=4;
			}
			else
				$status=5;
		}
		else
			$status=2;
	}
	else
		$status=0;
	if($status==1 || $status>=4)
		header("location:index.php?site=oceny&pesel=".$_POST['pesel']."&status=".$status);
	else
		header("location:index.php?site=uczen&status=".$status);
?>