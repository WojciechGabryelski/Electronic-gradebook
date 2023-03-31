<?php
	if(isset($_GET['status'])) {
		switch($_GET['status'])
		{
			case 0:
				echo '<div class="alert alert-danger alert-dismissible fade show mTop20">Operacja nie została wykonana
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 1:
				echo '<div class="alert alert-success alert-dismissible fade show mTop20">Operacja została wykonana
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 2:
				echo '<div class="alert alert-warning alert-dismissible fade show mTop20">Brak osoby
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 3:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Przedmiot istnieje w bazie danych
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 4:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Brak przedmiotu
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 5:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Błędna ocena
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 6:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Błąd zapisania oceny
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 7:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Błąd zapisania relacji między nauczycielem a przedmiotem
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
				break;
			case 8:
				echo '<div class="alert alert-warning alert-danger fade show mTop20">Niezgodne hasła
				<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
		}
	}
?>