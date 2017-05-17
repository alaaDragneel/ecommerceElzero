<?php
	//connect file
	include "admin/db.php";

	$sessionUser = '';
	if(isset($_SESSION['user'])) {	
		$sessionUser = $_SESSION['user'];
	}

	//Routes

	$tpl  = "includes/templetes/"; //templetes directory
	$lang = 'includes/languages/'; //language directory
	$func = 'includes/functions/'; //language directory
	$css  = "layout/css/"; //css directory

	$js = "layout/js/"; //js directory

	//include the important file

	include $func . "functions.php";
	include $lang 	. "eng.php";
	include $tpl 	. "header.php";
