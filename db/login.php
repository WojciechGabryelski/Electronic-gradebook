<?php
    $logging=1;
	include("api/check.php");
?>
<html>
	<head><link rel="stylesheet" type="text/css" href="css.css"><title>Dziennik elektroniczny</title></head>
	<body>
		<table width="200" border="0" cellspacing="1" align="center">
			<form id="form1" method="POST" action="action.php">
				<input type="hidden" name="site" value="logowanie">
				<tr>
					<td colspan="2"><h2>Zaloguj się</h2></td>
				</tr>
				<tr>
					<td>Login: </td>
					<td>
						<input type="text" name="login" id="login"/>
					</td>
				</tr>
				<tr>
					<td>Hasło: </td>
						<td><input type="password" name="haslo" id="haslo"/> </td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="zaloguj się"/>
					</td>
				</tr>
			</form>
		</table>
		<div align="center">
		<?php
			if(isset($_GET['status']) && $_GET['status'] == 0) {
				echo 'Nieprawidłowy login lub hasło';
			}
		?>
		</div>
	</body>
</html>