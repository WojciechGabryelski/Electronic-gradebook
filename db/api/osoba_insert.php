<?php
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == "/db/api") {
		header("location:../index.php");
		exit;
	}
	$status=1;
	if(!isset($_POST['prev_site'])) {
		header("location:index.php");
		exit;
	}
	$site=$_POST['prev_site'];
	if($_POST['haslo'] != $_POST['powtorz_haslo'])
		$status=8;
	else if($strona->sprawdzDane(isset($_POST) ? $_POST : array(),"pesel,nazwisko,imie,data_urodzenia,login,haslo"))
	{
		$query ="INSERT INTO ".$site." VALUES(?,?,?,?,?,?)";
		if(!$strona->insert($query, array(trim($_POST['pesel']), trim($_POST['imie']), trim($_POST['nazwisko']),
		trim($_POST['data_urodzenia']), $_POST['login'], password_hash($_POST['haslo'], PASSWORD_DEFAULT)), "Błąd dodawania ".($site == "uczen" ? "ucznia" : ($site == "nauczyciel" ?
		"nauczyciela" : "administratora"))." do bazy danych"))
			$status=0;
	}
	else
		$status=0;
	
	header("location:index.php?site=".$site."&status=".$status);
	exit;
?>