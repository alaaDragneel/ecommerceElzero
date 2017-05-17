<?php

	/*start get record function V1.0*/
	
	/*
	** function to get the categories from database [ User | Items | Comments ]
	*/
	
	function getCat() {
		global $conn;

		$getCat = $conn->prepare("SELECT * FROM categories ORDER BY cat_ID ASC");

		$getCat->execute();

		$rowsCat = $getCat->fetchAll();

		return $rowsCat;
	}

	/*end latest record function V2.0*/


	/*start get categories items function V2.0*/
	
	/*
	** function to get the categories items from database [ User | Items | Comments ]
	** use to get the latest item to the users 
	*/
	
	function getItems($where, $value) {
		global $conn;

		$getItems = $conn->prepare("SELECT * FROM items WHERE $where = ? ORDER BY item_ID DESC");

		$getItems->execute(array($value));

		$rowsItems = $getItems->fetchAll();

		return $rowsItems;
	}

	/*end latest record function V2.0*/


	/* start get user statyse function V1.0*/

	/*
	** check if user is not ACTIVE
	** chyeck he restatuse of user
	*/

	function checkUserStatuse($user){
		global $conn;

		$statuse = $conn->prepare("SELECT 
									userName, regStatuse 
								FROM 
									users 
								WHERE
									 userName = ?
								AND 
									regStatuse = 0 
								");
		$statuse->execute(array($user));

		$count = $statuse->rowCount();
		
		return $count;
	}

	/* end get user statyse function V1.0*/

	/*
	** title function V1.0  that echo the page title in 
	**case the page has variable $pageTitle and echo defult title for other pages
	*/
	/*start function title*/
	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;
		} else {

			echo 'Defult';
		}

	}

	/*end function title*/

	/*redirect function start*/

	/*
	** Home Redirect Function[This Function Accept Prameters]V2.0
	** $msg = echo the massage [ error | scusess| warning ]
	** $url = the link that will make redirect
	** $secong = seconds before redirecting
	*/

	function redirect($msg, $url = null, $page = 'home ', $seconds = 3) {

		if ($url === null) {
			$url = 'index.php';
		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

			$url = $_SERVER['HTTP_REFERER'];
			
			} else {
				$url = 'index.php';
			}


		}


			echo $msg;
			//the massage style that will change [ <div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'>$msg<strong></strong></div> ]

			echo "<div class='alert alert-info' style='font-size: 17px;'><strong>you will direct to the $page page after $seconds seconds</strong></div>";
	

		header("refresh: $seconds;url=$url");

		exit();

	}

	/*redirect function end*/

	/*start check item function V1.0 */

	/*
	**function accept parameters
	** $select = the item to select [Example: user, item]
	** $from = the table to select from [Example: user, item]
	** $value = the value of select 
	*/

	function checkItme($select, $from, $value) {
		global $conn;

		$st = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
		$st->execute(array($value));

		$count = $st->rowCount();

		return $count;

	}

	/*end check item function V1.0 */

	/* start check item count function V1.0 */
	
	/*
	**function use to count the items rows
	** function use parameter
	** $item = use item to count about it [ users | items ]
	** $table = the required table to count from [ users | product ] 
	*/

	function countItem($item, $table) {
		global $conn;

		$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table ");

		$stmt2->execute();

		return $stmt2->fetchColumn();
	}

	/* end check item count function V1.0 */