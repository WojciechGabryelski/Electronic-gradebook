<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	if($strona->sprawdzDane(isset($_GET) ? $_GET : array(),"id,pesel"))
	{
		$query ="DELETE FROM oceny WHERE pesel = ? and id = ?";
		
		if(!$strona->delete($query, array(trim($_GET['pesel']),trim($_GET['id'])), "Błąd usuwania oceny z bazy danych")) //trim - usuwanie spacji z końca
			$status=0;
	}
	else
		$status=0;
	
	if($status==1)
		header("location:index.php?site=oceny&pesel=".$_GET['pesel']."&status=".$status);
	else
		header("location:index.php?site=uczen&status=".$status);
	exit;
?>