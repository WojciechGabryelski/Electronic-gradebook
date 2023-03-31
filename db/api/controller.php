<?php
    $uczen=1;
	$nauczyciel=1;
	$admin=1;
	include("check.php");
	include_once("config.php");
	include_once('db.php');
	
	$site="";
	if(isset($_GET['site']))
	{
		$strona = new db($host,$dbname,$dbusr,$dbpass);
		if(($_GET['site']=="uczen" || $_GET['site']=="nauczyciel" || $_GET['site']=="admin") && $uprawnienia=="admin"
		|| $_GET['site']=="uczen" && $uprawnienia=="nauczyciel")
		{
			$site=$_GET['site'];
			$osoba=array();
			$url = "osoba_insert";
			
			if(isset($_GET['pesel']) && trim($_GET['pesel'])!="")
			{
				$query = "SELECT pesel, nazwisko, imie, data_urodzenia FROM	".$site." WHERE	pesel=?";
				$osoba = $strona->query($query, array($_GET['pesel']), "Błąd pobierania danych "
				.($site == "uczen" ? "ucznia" : ($site == "nauczyciel" ? "nauczyciela" : "administratora")));
				if(count($osoba)>0)
					$url="osoba_edit";
			}
			
			$query = "
				SELECT
					pesel,
					nazwisko,
					imie,
					data_urodzenia
				FROM
					".$site."
				ORDER BY
					nazwisko ASC, imie DESC
			";
			
			$dane = $strona->query($query, array(), "Błąd pobierania danych"
			.($site == "uczen" ? "uczniów" : ($site == "nauczyciel" ? "nauczycieli" : "administratorów")));
		}
		else if($_GET['site']=="przedmioty" && $uprawnienia=="admin")
		{
			$site="przedmioty";
			$przedmioty=array();
			$url = "przedmioty_insert";
			
			if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0)
			{
				$query = "SELECT id, nazwa FROM	przedmioty WHERE id=?";
				$przedmioty = $strona->query($query, array($_GET['id']), "Błąd pobierania nazw przedmiotów");
				if(count($przedmioty)>0)
					$url="przedmioty_edit";
			}
			
			$query = "SELECT * FROM przedmioty ORDER BY nazwa";
			$dane = $strona->query($query, array(), "Błąd pobierania danych przedmiotów");
		}
		else if($_GET['site']=="oceny" && $uprawnienia != "admin")
		{
			$listaUczniow=true;
			if(isset($_GET['pesel']) && trim($_GET['pesel'])!="" || $uprawnienia=="uczen")
			{
				if($uprawnienia=="uczen") {
					$osoba = $zalogowany;
					$pesel = $zalogowany[0]['pesel'];
				} else {
					$query = "SELECT pesel, nazwisko, imie, data_urodzenia FROM uczen WHERE pesel=?";
					$osoba = $strona->query($query, array($_GET['pesel']), "Błąd pobierania danych ucznia");
					$pesel = $_GET['pesel'];
				}
				if(count($osoba)>0)
				{
					if($uprawnienia == "nauczyciel") {
						$query = "SELECT przedmioty.id, nazwa FROM przedmioty INNER JOIN nauczyciel_przedmiot ON przedmioty.id=
						nauczyciel_przedmiot.id_przedmiotu WHERE pesel=? ORDER BY nazwa";
						$przedmioty = $strona->query($query, array($zalogowany[0]['pesel']), "Błąd pobierania nazw przedmiotów");
					} else {
						$query = "SELECT * FROM przedmioty ORDER BY nazwa";
						$przedmioty = $strona->query($query, array($pesel), "Błąd pobierania nazw przedmiotów");
					}
					if(count($przedmioty)>0)
					{
						$url="oceny_insert";
						$site="oceny";
						$oceny=array();
						
						if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0) {
							$query = "SELECT * FROM	oceny WHERE	id=?";
							$oceny = $strona->query($query, array($_GET['id']), "Błąd pobierania danych oceny");
							if(count($oceny)>0)
								$url="oceny_edit";
						}
						
						if($uprawnienia == "nauczyciel") {
							$query = "
								SELECT
									przedmioty.nazwa AS przedmiot, oceny.ocena, oceny.data, oceny.id
								FROM
									przedmioty INNER JOIN nauczyciel_przedmiot ON przedmioty.id=nauczyciel_przedmiot.id_przedmiotu
									INNER JOIN oceny ON przedmioty.id = oceny.id_przedmiotu
								WHERE
									nauczyciel_przedmiot.pesel=? AND oceny.pesel=?
								ORDER BY
									przedmioty.nazwa, oceny.data
							";

							$ocenyUcznia = $strona->query($query,array($zalogowany[0]['pesel'], $pesel), "Błąd pobierania ocen ucznia",'przedmiot');
						} else {
							$query = "
								SELECT 
									przedmioty.nazwa AS przedmiot, oceny.ocena, oceny.data, oceny.id
								FROM
									przedmioty INNER JOIN oceny ON przedmioty.id = oceny.id_przedmiotu
								WHERE
									oceny.pesel = ?
								ORDER BY
									przedmioty.nazwa, oceny.data
							";
							
							$ocenyUcznia = $strona->query($query,array($pesel), "Błąd pobierania ocen ucznia",'przedmiot');
						}
						
						$listaUczniow=false;
					}
				}
			}
			
			if($listaUczniow)
			{
				$site="uczen";
				$url="osoba_insert";
				$query = "SELECT pesel, nazwisko, imie, data_urodzenia FROM uczen ORDER BY nazwisko ASC, imie DESC";
				$dane = $strona->query($query, array(), "Błąd pobierania danych uczniów");
			}
		}
		else if($_GET['site']=="nauczyciel_przedmiot" && $uprawnienia=="admin")
		{
			$listaNauczycieli=true;
			if(isset($_GET['pesel']) && trim($_GET['pesel'])!="")
			{
				$query = "SELECT pesel, nazwisko, imie, data_urodzenia FROM nauczyciel WHERE pesel=?";
				$osoba = $strona->query($query, array($_GET['pesel']), "Błąd pobierania danych nauczyciela");
				if(count($osoba)>0)
				{
					$query = "SELECT * FROM przedmioty ORDER BY nazwa";
					$przedmioty = $strona->query($query, array($_GET['pesel']), "Błąd pobierania nazw przedmiotów");
					if(count($przedmioty)>0)
					{
						$url="nauczyciel_przedmiot_insert";
						$site="nauczyciel_przedmiot";
						$nauczyciel_przedmiot=array();
						
						if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0) {
							$query = "SELECT * FROM	nauczyciel_przedmiot WHERE id=?";
							$nauczyciel_przedmiot = $strona->query($query, array($_GET['id']), "Błąd pobierania relacji nauczycieli z przedmiotami");
							if(count($nauczyciel_przedmiot)>0)
								$url="nauczyciel_przedmiot_edit";
						}
						
						$query = "
							SELECT 
								przedmioty.nazwa, nauczyciel_przedmiot.id
							FROM
								nauczyciel_przedmiot INNER JOIN przedmioty ON nauczyciel_przedmiot.id_przedmiotu = przedmioty.id
							WHERE
								nauczyciel_przedmiot.pesel = ?
							ORDER BY
								przedmioty.nazwa
						";
						
						$przedmiotyNauczyciela = $strona->query($query,array($_GET['pesel']), "Błąd pobierania przedmiotów, których uczy nauczyciel");
						$listaNauczycieli=false;
					}
				}
			}
			
			if($listaNauczycieli)
			{
				$site="nauczyciel";
				$url="osoba_insert";
				$query = "SELECT pesel, nazwisko, imie, data_urodzenia FROM nauczyciel ORDER BY nazwisko ASC, imie DESC";
				$dane = $strona->query($query, array(), "Błąd pobierania danych nauczycieli");
			}
		}
	}
?>