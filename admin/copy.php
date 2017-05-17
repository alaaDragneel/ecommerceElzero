<?php

	/*
	=========================================
	== Templet Page
	=========================================
	*/
	ob_start(); //output buffring start
	session_start();
	if (isset($_SESSION['userName'])) {

		$pageTitle = 'Members';
		
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		//start manage page

		if ($do == 'manage') { // mange member page 
			echo "welcome to the manage page";
			} elseif ($do == 'add') { //add page 

			} elseif ($do == 'insert') { 

			} elseif ($do == 'edit') {	//edit page

			} elseif ($do == 'update') { //updaye page
		
			} elseif ($do == 'delete') { //delete page
			
			} elseif ($do == 'activate') {
			
			}	

		include $tpl . "footer.php";

	} else {
		header('location: index.php');
		 
		exit();
	}

	ob_end_flush();
