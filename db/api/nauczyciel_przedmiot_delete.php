<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	if($strona->sprawdzDane(isset($_GET) ? $_GET : array(),"id,pesel"))
	{
		$query ="DELETE FROM nauczyciel_przedmiot WHERE pesel = ? AND id = ?";
		
		if(!$strona->delete($query, array(trim($_GET['pesel']),trim($_GET['id'])),
		"Błąd usuwania relacji nauczyciela z przedmiotem z bazy danych")) //trim - usuwanie spacji z końca
			$status=0;
	}
	else
		$status=0;
	
	if($status==1)
		header("location:index.php?site=nauczyciel_przedmiot&pesel=".$_GET['pesel']."&status=".$status);
	else
		header("location:index.php?site=nauczyciel&status=".$status);
	exit;
?>