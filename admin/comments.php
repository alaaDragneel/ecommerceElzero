<?php

	/*
	=========================================
	== Manage comments page
	== Can Delete | Edit | approve comments From This Page 
	=========================================
	*/
	ob_start();
	session_start();
	if (isset($_SESSION['userName'])) {

		$pageTitle = 'Members';
		
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		//start manage page

		if ($do == 'manage') { // mange member page 
			//select the data from comments table execpt the admin
			$stmt = $conn->prepare("SELECT 
										comments.* ,
										items.itemName AS Item_Name,
										users.userName AS User_Name
									FROM 
									 	comments

									INNER JOIN
									 	items
									ON 
										items.item_ID = comments.item_ID

									INNER JOIN
									 	users
									ON 
										users.userId = comments.userId	 
									ORDER BY c_ID DESC		

								  ");
			//execute the statement
			$stmt->execute();

			//assign to variable

			$rows = $stmt->fetchAll();
			if(!empty($rows)){
		?>

			<h1 class='text-center'>manage  comments</h1>
			<div class='container'>
				<div class='table-responsive'>
					<table class='main-table text-center table table-bordered table-hover'>
						<tr>
							<td>#ID</td>
							<td>comment</td>
							<td>item name</td>
							<td>member name</td>
							<td>added Date</td>
							<td>control</td>
						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['c_ID'] . "</td>";
									echo "<td>" . $row['commentName'] . "</td>";
									echo "<td>" . $row['Item_Name'] . "</td>";
									echo "<td>" . $row['User_Name'] . "</td>";
									echo "<td>" . $row['commentDate'] . "</td>";
									echo "<td>
											<a href='comments.php?do=edit&c_id=".$row['c_ID']."' class='btn btn-info'><i class='fa fa-edit'></i> edit</a>
											<a href='comments.php?do=delete&c_id=".$row['c_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete</a>";

										  if ($row['commentStatuse'] == 0) {
										  
										  	echo "<a href='comments.php?do=approve&c_id=".$row['c_ID']."' class='btn btn-primary activate'><i class='fa fa-check'></i> Approve</a>";

										  }

										  echo "</td>";
								echo "</tr>";

							}
						?>
					</table>
				</div>
			</div>

			

		<?php }else{
				echo '
					 	 <div 
					  		class	=	"container text-center" 
							style	=	"
											position: absolute;
											margin-top: 20px;
											background-color: #fff;
											left: 94px;
											top: 156px;
											padding: 40px;
											border-radius: 10px;
											box-shadow: 1px 4px 19px #eee;
										">
							 ';
				echo'<div class="alert alert-warning">there is no comments to show</div> ';
				
				echo"</div>";
			}
			  } elseif ($do == 'edit') {	//edit page

			//check if the user id is numeric and get the integer value
			$comId = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;

			//select all data depend on the id
			$stmt = $conn->prepare("SELECT * FROM comments WHERE c_ID = ?");
			//excute he data
			$stmt->execute(array($comId));
			//fetch the data
			$row = $stmt->fetch();
			//row count
			$count = $stmt->rowCount();
			//if there is such id show form
			if ($count > 0) { ?>	

			<h1 class='text-center'>Edit comment</h1>

			<div class='container'>
				<div class='center'>
					<form class='form-horizontal formValidation' action="?do=update" method='post'>
					<input type='hidden' name='comId' value='<?php echo $comId; ?>' />
					<fieldset>
						<legend>Main Information</legend>
						<!-- start comment field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>comment</label>
								<div class='col-sm-10 col-md-4'>
									<textarea type='text' name='commentName' class='form-control inputValidation' ><?php echo $row['commentName'];?></textarea>
								</div>
							</div>	
							<!-- end comment field -->
					<div class='errorMessage'></div>
						</fieldset>
						<fieldset>
							<legend>options</legend>
							<!-- start submit button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='submit' class='btn btn-primary btn-lg btn-block' value='Edit' />
								</div>
							</div>	
							<!-- end submit button -->
							<!-- start submit button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='reset' class='btn btn-danger btn-lg btn-block' value='clear' />
								</div>
							</div>	
							<!-- end submit button -->	
						</fieldset>	
					</form>
				</div>
			</div>


		<?php 

			} else {//if there is no such id do't show the form
			echo '
					 	 <div 
					  		class	=	"container text-center" 
							style	=	"
											position: absolute;
											margin-top: 20px;
											background-color: #fff;
											left: 94px;
											top: 156px;
											padding: 40px;
											border-radius: 10px;
											box-shadow: 1px 4px 19px #eee;
										">
							 ';

				$msg =  "<div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'><strong>there is no such ID[] ". $userId ." ]</strong></div>";

				redirect($msg);

				echo "</div>";
			}
	} elseif ($do == 'update') { //updaye page
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo "<h1 class='text-center'>update comment</h1>";
			//get varibles from the form

			$comId 			= trim(strip_tags($_POST['comId']));
			$comment 		= trim(strip_tags($_POST['commentName']));

	
			//update the database

			$stmt = $conn->prepare("UPDATE comments SET commentName = ? WHERE c_ID = ?");
			$stmt->execute(array($comment, $comId));

			//echo success massage

			echo '
		 	 <div 
		  		class	=	"container text-center" 
				style	=	"
								position: absolute;
								margin-top: 20px;
								background-color: #fff;
								left: 94px;
								top: 156px;
								padding: 40px;
								border-radius: 10px;
								box-shadow: 1px 4px 19px #eee;
							">
				 ';
				$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
				 $stmt->rowCount() . " Recourd updated </strong></div>";
				 redirect($msg, 'backPage', 'prev');


		} else {
		echo '
			 <div 
				class	=	"container text-center" 
			style	=	"
							position: absolute;
							margin-top: 20px;
							background-color: #fff;
							left: 94px;
							top: 156px;
							padding: 40px;
							border-radius: 10px;
							box-shadow: 1px 4px 19px #eee;
						">
			 ';
			$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>you can\'t browes this page directlly</storng></div> ';
			redirect($msg);
			echo "</div>";
		}

	} elseif ($do == 'delete') { //delete page
			echo "<h1 class='text-center'>delete comments page</h1>";
		//check if the user id is numeric and get the integer value
			$comId = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'c_ID', 'comments', $comId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("DELETE FROM comments WHERE c_ID = :com");
				$stmt->bindParam(":com", $comId);
				$stmt->execute();

				//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						 $stmt->rowCount() . " Recourd deleted </strong></div>";
						 redirect($msg, 'manage', 'manage');
				} else {
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">';
				$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>this id not exist</storng></div> ';
				redirect($msg);
				echo "</div>";
			
			} 

		} elseif ($do == 'approve') {
			echo "<h1 class='text-center'>approve comment page</h1>";
		//check if the user id is numeric and get the integer value
			$comId = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'c_ID', 'comments', $comId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("UPDATE comments SET commentStatuse = 1 WHERE c_ID = ?");
				$stmt->execute(array($comId));

				//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						 $stmt->rowCount() . " Recourd approved </strong></div>";
						 redirect( $msg, 'ApprovePage', 'approve comments');
				} else {
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">';
				$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>this id not exist</storng></div> ';
				redirect($msg);
				echo "</div>";
			}
		}	

		include $tpl . "footer.php";

	} else {
		header('location: index.php');
		 
		exit();
	}

	ob_end_flush();
