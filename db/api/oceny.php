<?php
	$admin=1;
	include("check.php");
	if($uprawnienia!="uczen"){
?>
<h1>Oceny ucznia: <?php echo (isset($osoba[0]['nazwisko']) ? $osoba[0]['nazwisko'] : '')." ".
(isset($osoba[0]['imie']) ? $osoba[0]['imie'] : '') ?></h1>
<form action="action.php" method="POST">
	<div class="form-group">
		<label for="ocena">Ocena:</label>
		<input type="hidden" name="pesel" value=<?php echo (isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '')?>>
		<input type="hidden" name="id" value=<?php echo (isset($oceny[0]['id']) ? $oceny[0]['id'] : '')?>>
		<input type="hidden" name="site" value="<?php echo $url ?>">
		<select name="ocena" id="ocena" class="form-control">
			<option value="">- wybierz ocenę -</option>
			<?php
				if(isset($listaOcen) && is_array($listaOcen) && count($listaOcen) > 0)
					foreach($listaOcen AS $i=>$ocena)
						echo '<option value="'.$ocena.'"'.(isset($oceny[0]['id']) && '"'.$oceny[0]['ocena'].'"'
						== '"'.$ocena.'"' ? ' selected="selected"' : '').'>'.$ocena.'</option>';
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="przedmiot">Przedmiot:</label>
		<select name="przedmiot" id="przedmiot" class="form-control">
			<option value="">- wybierz przedmiot -</option>
			<?php
				if(isset($przedmioty) && is_array($przedmioty) && count($przedmioty) > 0)
					foreach($przedmioty AS $pozycja => $danePrzedmiotu)
						echo '<option value='.$danePrzedmiotu['id'].(isset($oceny[0]['id']) && $oceny[0]['id_przedmiotu']
						== $danePrzedmiotu['id'] ? ' selected="selected"' : '').'>'.$danePrzedmiotu['nazwa'].'</option>';
			?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" value="zapisz" class="btn btn-success">
		<?php echo $url == "osoba_edit" ? '<a href="index.php?site=oceny" class="btn btn-warning">anuluj</a>' : ''?>
	</div>
</form>
<?php } ?>
<h2>Wykaz ocen</h2>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="width100">L.p.</th>
				<th class="width200">Przedmiot</th>
				<th>Oceny</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if(is_array($ocenyUcznia) && count($ocenyUcznia)>0)
				{
					$numerWiersza=1;
					foreach($ocenyUcznia AS $nazwaPrzedmiotu => $informacje)
					{
						echo '
							<tr>
								<td>'.($numerWiersza++).'</td>
								<td>'.$nazwaPrzedmiotu.'</td>
								<td>
						';
						foreach($informacje AS $numerOceny => $szczegolyOceny)	
							echo ($numerOceny > 0 ? ', ' : '').'<div class="ocena">
							'.$szczegolyOceny['ocena'].($uprawnienia == "uczen" ? '' : '
								<div class="opcjeOceny"><small>'.$nazwaPrzedmiotu.'<br>'.$szczegolyOceny['data'].'<br>ocena: '.$szczegolyOceny['ocena'].'<br></small>
									<a href="action.php?site=oceny_delete&id='.$szczegolyOceny['id'].'
									&pesel='.(isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '').'"><img src="icons/delete.png" class="icon"></a> 
									<a href="index.php?site=oceny&pesel='.(isset($osoba[0]['pesel']) ? $osoba[0]['pesel'] : '').'
									&id='.$szczegolyOceny['id'].'"><img src="icons/edit.png" class="icon"></a>
								</div>').'
							</div>';
							
						echo '
								</td>
							</tr>
						';
					}
				}
				else
					echo '
						<tr>
							<td colspan="6">Brak ocen</td>
						</tr>
					';
				
			?>
		</tbody>
	</table>
</div>