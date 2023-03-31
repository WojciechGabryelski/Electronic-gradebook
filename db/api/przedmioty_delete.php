<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$strona = new db($host,$dbname,$dbusr,$dbpass);
	
	$status=1;
	
	if($strona->sprawdzDane(isset($_GET) ? $_GET : array(),"id"))
	{
		$query ="DELETE FROM przedmioty WHERE id = ?";
		
		if(!$strona->delete($query, array(trim($_GET['id'])), "Błąd usuwania ucznia z bazy danych"))
			$status=0;
	}
	else
		$status=0;
	
	header("location:index.php?site=przedmioty&status=".$status);
	exit;
?>