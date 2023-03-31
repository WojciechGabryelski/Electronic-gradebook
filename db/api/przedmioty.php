<?php
	$admin=1;
	include("check.php");
?>
<h1>Przedmioty</h1>
<form action="action.php" method="POST">
	<input type="hidden" name="site" value="<?php echo $url ?>">
	<div class="form-group">
		<label for="nazwa">Nazwa przedmiotu:</label>
		<input type="text" name="nazwa" id="nazwa" class="form-control" value=
		"<?php echo isset($przedmioty[0]['nazwa']) ? $przedmioty[0]['nazwa'] : ''?>">
		<input type="hidden" name="id" class="form-control" value=
		"<?php echo isset($przedmioty[0]['id']) ? $przedmioty[0]['id'] : ''?>">
	</div>
	<div class="form-group">
		<input type="submit" value="zapisz" class="btn btn-success">
		<?php echo $url == "przedmioty_edit" ? '<a href="index.php?site=przedmioty" class="btn btn-warning">anuluj</a>' : ''?>
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
				
				if(is_array($dane) && count($dane)>0)
					foreach($dane AS $numerWiersza => $informacje)
						echo '
							
							<tr>
								<td>'.($numerWiersza+1).'</td>
								<td>'.$informacje['nazwa'].'</td>
								<td class="center">
								<a href="index.php?site=przedmioty&id='.$informacje['id'].'" class="btn btn-primary">edytuj</a>
								<a href="action.php?site=przedmioty_delete&id='.$informacje['id'].'" class="btn btn-danger">usuń</a>
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