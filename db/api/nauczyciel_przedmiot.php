<h1>Przedmioty, których uczy: <?php echo (isset($osoba[0]['nazwisko']) ? $osoba[0]['nazwisko'] : '')." ".
(isset($osoba[0]['imie']) ? $osoba[0]['imie'] : '') ?></h1>
<form action="action.php" method="POST">
	<div class="form-group">
		<input type="hidden" name="pesel" value=<?php echo (isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '')?>>
		<input type="hidden" name="id" value=<?php echo (isset($nauczyciel_przedmiot[0]['id']) ? $nauczyciel_przedmiot[0]['id'] : '')?>>
		<input type="hidden" name="site" value="<?php echo $url ?>">
		<label for="przedmiot">Przedmiot:</label>
		<select name="przedmiot" id="przedmiot" class="form-control">
			<option value="">- wybierz przedmiot -</option>
			<?php
				if(isset($przedmioty) && is_array($przedmioty) && count($przedmioty) > 0) {
					foreach($przedmioty AS $pozycja => $danePrzedmiotu) {
						$tmp = 1;
						foreach($przedmiotyNauczyciela AS $numer => $danePrzedmiotuNauczyciela) {
							if($danePrzedmiotu['nazwa'] == $danePrzedmiotuNauczyciela['nazwa']) {
								$tmp = 0;
								break;
							}
						}
						if($tmp == 1) {
							echo '<option value='.$danePrzedmiotu['id'].(isset($nauczyciel_przedmiot[0]['id']) && $nauczyciel_przedmiot[0]['id_przedmiotu']
							== $danePrzedmiotu['id'] ? ' selected="selected"' : '').'>'.$danePrzedmiotu['nazwa'].'</option>';
							break;
						}
					}
				}
			?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" value="zapisz" class="btn btn-success">
		<?php echo $url == "nauczyciel_przedmiot_edit" ? '<a href="index.php?site=nauczyciel_przedmiot&pesel='
		.(isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '').'" class="btn btn-warning">anuluj</a>' : ''?>
	</div>
</form>
<h2>Wykaz przedmiotów</h2>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>L.p.</th>
				<th>Nazwa przedmiotu</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php
				
				if(is_array($przedmiotyNauczyciela) && count($przedmiotyNauczyciela)>0)
					foreach($przedmiotyNauczyciela AS $numerWiersza => $informacje)
						echo '
							<tr>
								<td>'.($numerWiersza+1).'</td>
								<td>'.$informacje['nazwa'].'</td>
								<td class="center">
								<a href="index.php?site=nauczyciel_przedmiot&pesel='.(isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '').'
								&id='.$informacje['id'].'" class="btn btn-primary">edytuj</a>
								<a href="action.php?site=nauczyciel_przedmiot_delete&pesel='.(isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '').'
								&id='.$informacje['id'].'" class="btn btn-danger">usuń</a>
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