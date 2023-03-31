<?php
	include_once('api/config.php');
	include_once('api/db.php');
	
	if(isset($_REQUEST['site']) && $_REQUEST['site']!="" && file_exists('api/'.$_REQUEST['site'].'.php'))
	{
		$strona = new db($host,$dbname,$dbusr,$dbpass);
		include('api/'.$_REQUEST['site'].'.php');
	}
?>