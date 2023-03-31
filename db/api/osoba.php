<?php
    $admin=1;
	include("check.php");
?>
<h1><?php echo $site=="uczen" ? "Uczniowie" : ($site=="nauczyciel" ? "Nauczyciele" : "Administratorzy")?></h1>
<?php if($uprawnienia=="admin") { ?>
<form action="action.php" method="POST">
	<input type="hidden" name="site" value="<?php echo $url ?>">
	<input type="hidden" name="prev_site" value="<?php echo $site ?>">
	<div class="form-group">
		<label for="pesel">PESEL:</label>
		<input type="text" name="pesel" id="pesel" class="form-control" value=
		"<?php echo isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : ''?>" maxlength="11" required>
		<input type="hidden" name="pesel_stary" class="form-control" value=
		"<?php echo isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : ''?>">
	</div>
	<div class="form-group">
		<label for="imie">IMIĘ:</label>
		<input type="text" name="imie" id="imie" class="form-control" value=
		"<?php echo isset($osoba[0]['imie']) ? $osoba[0]['imie'] : ''?>" required>
	</div>
	<div class="form-group">
		<label for="nazwisko">NAZWISKO:</label>
		<input type="text" name="nazwisko" id="nazwisko" class="form-control" value=
		"<?php echo isset($osoba[0]['nazwisko']) ? $osoba[0]['nazwisko'] : ''?>" required>
	</div>
	<div class="form-group">
		<label for="data_urodzenia">DATA URODZENIA:</label>
		<input type="text" name="data_urodzenia" id="data_urodzenia" class="form-control " value=
		"<?php echo isset($osoba[0]['data_urodzenia']) ? $osoba[0]['data_urodzenia'] : ''?>" required>
	</div>
	<?php
		echo !isset($osoba[0]['pesel']) ?
		'<div class="form-group">
			<label for="login">LOGIN:</label>
			<input type="text" name="login" id="login" class="form-control " value="" required>
		</div>' : '';
		echo !isset($osoba[0]['pesel']) ?
		'<div class="form-group">
			<label for="haslo">HASŁO:</label>
			<input type="password" name="haslo" id="haslo" class="form-control " value="" required>
		</div>' : '';
		echo !isset($osoba[0]['pesel']) ?
		'<div class="form-group">
			<label for="powtorz_haslo">POWTÓRZ HASŁO:</label>
			<input type="password" name="powtorz_haslo" id="powtorz_haslo" class="form-control " value="" required>
		</div>' : '';
	?>
	<div class="form-group">
		<input type="submit" value="zapisz" class="btn btn-success">
		<?php echo $url == "osoba_edit" ? '<a href="index.php?site='.$site.'" class="btn btn-warning">anuluj</a>' : ''?>
	</div>
</form>
<?php } ?>
<h2>Wykaz <?php echo $site=="uczen" ? "uczniów" : ($site=="nauczyciel" ? "nauczycieli" : "administratorów")?></h2>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="width100">L.p.</th>
				<?php echo $uprawnienia=="admin" ? '<th class="width150">PESEL</th>' : ''?>
				<th>NAZWISKO</th>
				<th>IMIĘ</th>
				<?php echo $uprawnienia=="admin" ? '<th class="width130">DATA URODZENIA</th>' : ''?>
				<th class="width300">&nbsp;</th>'
			</tr>
		</thead>
		<tbody>
			<?php
				
				if(is_array($dane) && count($dane)>0)
					foreach($dane AS $numerWiersza => $informacje)
						echo '
							
							<tr>
								<td>'.($numerWiersza+1).'</td>
								'.($uprawnienia=="admin" ? '<td class="center">'.$informacje['pesel'].'</td>' : '').'
								<td>'.$informacje['nazwisko'].'</td>
								<td>'.$informacje['imie'].'</td>
								'.($uprawnienia=="admin" ? '<td class="center">'.$informacje['data_urodzenia'].'</td>' : '').'
								<td class="center">
								'.($uprawnienia=="admin" ? '<a href="index.php?site='.$site.'&pesel='.$informacje['pesel'].'" class="btn btn-primary">edytuj</a>
								'.($informacje['pesel']==$zalogowany[0]['pesel'] ? '' : '<a href="action.php?site=osoba_delete&prev_site='.$site.'&pesel='.$informacje['pesel'].'" class="btn btn-danger">usuń</a>')  : '')
								.($site == "uczen" && $uprawnienia == "nauczyciel" ? '<a href="index.php?site=oceny&pesel='.$informacje['pesel'].'" class="btn btn-warning">oceny</a>' :
								($site == "nauczyciel" ? '<a href="index.php?site=nauczyciel_przedmiot&pesel='.$informacje['pesel'].
								'" class="btn btn-warning">przedmioty</a>' : '')).'
								</td>
							</tr>
						';
				else
					echo '
						<tr>
							<td colspan="6">Brak danych</td>
						</tr>
					';
				
			?>
		</tbody>
	</table>
</div>