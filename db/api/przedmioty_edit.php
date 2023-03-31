<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"nazwa,id"))
	{
		$query= "SELECT id FROM przedmioty WHERE id = ?";
		$dane = $strona->query($query, array($_POST['id']), "Błąd pobierania danych przedmiotu");
		if(count($dane)>0)
		{
			$query= "SELECT id FROM przedmioty WHERE id <> ? AND nazwa = ?";
			$dane = $strona->query($query, array($_POST['id'], trim($_POST['nazwa'])), "Błąd pobierania danych przedmiotu");
			if(count($dane)==0)
			{
				$query = "UPDATE przedmioty SET nazwa = ? WHERE id = ?";
				if(!$strona->update($query, array(trim($_POST['nazwa']), trim($_POST['id'])), "Błąd edycji danych ucznia"))
					$status=0;
			}
			else
				$status=3;
		}
		else
			$status=4;
	}
	else
		$status=0;
	
	header("location:index.php?site=przedmioty&status=".$status);
	exit;
?>