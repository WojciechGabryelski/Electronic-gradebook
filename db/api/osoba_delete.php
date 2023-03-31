<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$strona = new db($host,$dbname,$dbusr,$dbpass);
	
	$status=1;
	if(!isset($_GET['prev_site'])) {
		header("location:index.php");
		exit;
	}
	if($strona->sprawdzDane(isset($_GET) ? $_GET : array(),"pesel"))
	{
		$query ="DELETE FROM ".$_GET['prev_site']." WHERE pesel = ?";
		
		if(!$strona->delete($query, array(trim($_GET['pesel'])), "Błąd usuwania "
		.$_GET['prev_site']=="uczen" ? "ucznia" : ($_GET['prev_site']=="nauczyciel" ?"nauczyciela" :
		"administratora")." z bazy danych")) //trim - usuwanie spacji z końca
			$status=0;
	}
	else
		$status=0;
	
	header("location:index.php?site=".$_GET['prev_site']."&status=".$status);
	exit;
?>