<?php
	include_once("api/controller.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Dziennik elektroniczny</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<style>
			.center
			{
				text-align:center;
			}
			.mTop20
			{
				margin0top:20px;
			}
			.width100
			{
				width:100px;
			}
			.width130
			{
				width:130px;
			}
			.width150
			{
				width:150px;
			}
			.width200
			{
				width:200px;
			}
			.width300
			{
				width:300px;
			}
			.ocena
			{
				display:inline-block;
				zoom:1;
				*display:inline;
			}
			.opcjeOceny
			{
				border:1px solid #444444;
				background:#dcdcdc;
				border-radius:4px;
				-webkit-border-radius:4px;
				-moz-border-radius:4px;
				padding:10px;
				display:none;
			}
			.ocena:hover > .opcjeOceny
			{
				display:block;
				position:fixed;
				margin-top:-75px;
				margin-left:-20px;
			}
			.icon
			{
				width:24px;
				margin:5px;
			}
		</style>
		<script>
			$( function() 
			{
				$( "#data_urodzenia" ).datepicker(
				{
					changeMonth: true,
					changeYear: true,
					dateFormat: 'yy-mm-dd'
				});
			} );
	    </script>
	</head>
	<body>
		<h1><?php echo $zalogowany[0]['imie']." ".$zalogowany[0]['nazwisko']?></h1>
		<form action="logout.php">
			<input type="submit" action="costam" value="wyloguj">
		</form>
		<br/>
		<?php if($uprawnienia=="admin") { ?>
		<a href="index.php?site=uczen">uczniowie</a>
		<a href="index.php?site=nauczyciel">nauczyciele</a>
		<a href="index.php?site=admin">administratorzy</a>
		<a href="index.php?site=przedmioty">przedmioty</a>
		<?php } else if($uprawnienia=="uczen") { ?>
		<a href="index.php?site=oceny">oceny</a>
		<?php } else { ?>
		<a href="index.php?site=uczen">uczniowie</a>
		<?php } ?>
		<div class="container">
			<?php
				if(isset($_GET['status']) && file_exists('api/status.php'))
					include_once('api/status.php');
				if(isset($site) && $site!="" && file_exists('api/'.$site.'.php'))
					include('api/'.$site.'.php');
			?>
		<div>
	</body>
</html>