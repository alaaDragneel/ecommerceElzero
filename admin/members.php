<?php

	/*
	=========================================
	== Manage members page
	== Can Add | Delete | Edit Members From This Page 
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
			// variable to use with pending check
			$query = '';
			
			if (isset($_GET['page']) && $_GET['page'] == 'pending') { //if isset he get value

				$query = 'AND regStatuse = 0'; // add this query to the prepare statement
			
			}

			//select the data from users table execpt the admin
			$stmt = $conn->prepare("SELECT * FROM users WHERE groubId != 1 $query ORDER BY userId DESC");
			//execute the statement
			$stmt->execute();

			//assign to variable

			$rows = $stmt->fetchAll();
			if(!empty($rows)){
		?>

			<h1 class='text-center'>manage  member</h1>
			<div class='container'>
				<div class='table-responsive'>
					<table class='main-table text-center table table-bordered table-hover'>
						<tr>
							<td>#ID</td>
							<td>username</td>
							<td>email</td>
							<td>full name</td>
							<td>registerd date</td>
							<td>control</td>
						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['userId'] . "</td>";
									echo "<td>" . $row['userName'] . "</td>";
									echo "<td>" . $row['email'] . "</td>";
									echo "<td>" . $row['fullName'] . "</td>";
									echo "<td>" . $row['Date'] . "</td>";
									echo "<td>
											<a href='members.php?do=edit&id=".$row['userId']."' class='btn btn-info'><i class='fa fa-edit'></i> edit</a>
											<a href='members.php?do=delete&id=".$row['userId']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete</a>";

										  if ($row['regStatuse'] == 0) {
										  
										  	echo "<a href='members.php?do=activate&id=".$row['userId']."' class='btn btn-primary activate'><i class='fa fa-check'></i> activate</a>";

										  }

										  echo "</td>";
								echo "</tr>";

							}
						?>
					</table>
				</div>
				<a href='?do=add' class='btn btn-success '>
					<i class='fa fa-plus'></i> new member
				</a>
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
			echo'<div class="alert alert-warning">there is no members to show</div> ';
			
			echo"</div>";			 
		} 
			}elseif ($do == 'add') { //add page ?>
			<h1 class='text-center'>add new member</h1>
			<div class='container'>
				<div class='center'>
					<form class='form-horizontal formValidation' action="?do=insert" method='post'>
					<fieldset class='col-sm-10 col-md-12'>
						<legend>Main Information</legend>
						<!-- start user name field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>Username</label>
								<div class='col-sm-10 col-md-4'>
									<input type='text' name='userName' class='form-control inputValidation' autocomplete='off' placeholder="user name here" />
								</div>
							</div>	
							<!-- end user name field -->

							<!-- start password field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>password</label>
								<div class='col-sm-10 col-md-4'>
									<input type='password' name='password' class='password form-control inputValidation'  autocomplete="new-password" placeholder="password must be hard"  />
									<i class="show-pass fa fa-eye fa-2x"></i>
								</div>
							</div>	
							<!-- end password field -->

							<!-- start Email field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>Email</label>
								<div class='col-sm-10 col-md-4'>
									<input type='Email' name='email' class='form-control inputValidation' placeholder="enter a valid email"/>
								</div>
							</div>	
							<!-- end Email field -->

							<!-- start fullname field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>fullname</label>
								<div class='col-sm-10 col-md-4'>
									<input type='text' name='fullName' class='form-control inputValidation' placeholder="enter your full name here"/>
								</div>
							</div>	
							<!-- end fullnamefield -->
							<div class='errorMessage'></div>
						</fieldset>
						<fieldset class='col-sm-10 col-md-12''>
							<legend>options</legend>
							<!-- start submit button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='submit' class='btn btn-primary btn-lg btn-block' value='add member' />
								</div>
							</div>	
							<!-- end submit button -->
							<!-- start clear button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='reset' class='btn btn-danger btn-lg btn-block' value='clear' />
								</div>
							</div>	
							<!-- end clear button -->	
						</fieldset>	
					</form>
				</div>
			</div>
		

		<?php 
		} elseif ($do == 'insert') { //insert page

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			echo "<h1 class='text-center'>add new member</h1>";
			//get varibles from the form

			$user 		= trim(strip_tags($_POST['userName']));
			$pass 		= trim(strip_tags($_POST['password']));
			$email 		= trim(strip_tags($_POST['email']));
			$name 		= trim(strip_tags($_POST['fullName']));

			$hashedpass = sha1($pass);

			//validate the form

			$formErrors = array();

			if (strlen($user) < 4) {
				$formErrors[] = 'username can\'t be less than 4 characters';
			}
			if (strlen($user) > 20) {
				$formErrors[] = 'username can\'t be more than 20 characters';
			}
			if (empty($user)) {
				$formErrors[] = 'username can\'t be empty';
			}
			if (trim(strip_tags($_POST['userName'])) === false) {
				$formErrors[] = 'please use a validate characters in the username field';
			} 
			if (strlen($pass) < 4) {
				$formErrors[] = 'password must be more than 4 characters';
			}
			if (empty($pass)) {
				$formErrors[] = 'password can\'t be empty';
			}
			if (trim(strip_tags($_POST['password'])) === false) {
				$formErrors[] = 'please use a validate characters in the password field';
			} 
			if (empty($name)) {
				$formErrors[] = 'fullname can\'t be empty';
			}
			if (trim(strip_tags($_POST['fullName'])) === false) {
				$formErrors[] = 'please use a validate characters in the full name field';

			} 
			if (empty($email)) {
				$formErrors[] = 'email can\'t be empty';
			}

				if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE ){
                    //the result that will happend
					$formErrors[] = "Please Enter A Validate Email";	
				} 
				if(filter_var($email, FILTER_SANITIZE_EMAIL) === FALSE ){
                    //the result that will happend
					$formErrors[] = "Please Enter A Validate Email";
				} 
				if(!empty($formErrors)){
					//the result of the validation and inputs
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
					//start loop to get the errors
					foreach ($formErrors as $error) {
							
						echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
					
					}//end loop
					
					echo '</div>';
					
				}

				//if the array is empty compelete the query
				if (empty($formErrors)) {

					//check if user exist in database
					$check = checkItme("userName", "users", $user);
					if ($check == 1) {
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
						$msg = '<div class="alert alert-danger"><strong>sorry this username is exist</strong></div>';
						redirect($msg, 'prev', 'prev');
					
					echo '</div>';

					} else {

						//insert user information into the database

						$stmt = $conn->prepare("INSERT INTO 
														users(userName, password, email, fullName, regStatuse, Date) 
												VALUES(:zuser, :zpass, :zemail, :zname, 1, now()) ");

						$stmt->execute(array(

							'zuser' 	 => $user,
							'zpass' 	 => $hashedpass,
							'zemail'	 => $email,
							'zname' 	 => $name

							));

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
							 $stmt->rowCount() . " Recourd inserted </strong></div>";

							 redirect($msg, 'backPage', 'prev');
					}
				}

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
			$msg = "<div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'><strong>you can\'t browes this page directlly </srtrong></div>";
			redirect($msg);
		}
		echo '</div>';
		} elseif ($do == 'edit') {	//edit page

			//check if the user id is numeric and get the integer value
			$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id
			$stmt = $conn->prepare("SELECT * FROM users WHERE userId = ? LIMIT 1");
			//excute he data
			$stmt->execute(array($userId));
			//fetch the data
			$row = $stmt->fetch();
			//row count
			$count = $stmt->rowCount();
			//if there is such id show form
			if ($count > 0) { ?>	

			<h1 class='text-center'>Edit member</h1>

			<div class='container'>
				<div class='center'>
					<form class='form-horizontal formValidation' action="?do=update" method='post'>
					<input type='hidden' name='userId' value='<?php echo $userId; ?>' />
					<fieldset>
						<legend>Main Information</legend>
						<!-- start user name field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>Username</label>
								<div class='col-sm-10 col-md-4'>
									<input type='text' name='userName' class='form-control inputValidation' autocomplete='off' value='<?php echo $row['userName'];?>' />
								</div>
							</div>	
							<!-- end user name field -->

							<!-- start password field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>password</label>
								<div class='col-sm-10 col-md-4'>
									<input type='hidden' name='oldPassword' value='<?php echo $row['password']?>'/>
									<input type='password' name='newPassword' class='form-control'  autocomplete="new-password" placeholder="Leave If Don't Need Change Password"  />
								</div>
							</div>	
							<!-- end password field -->

							<!-- start Email field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>Email</label>
								<div class='col-sm-10 col-md-4'>
									<input type='Email' name='email' class='form-control inputValidation' value='<?php echo $row['email']?>'/>
								</div>
							</div>	
							<!-- end Email field -->

							<!-- start fullname field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>fullname</label>
								<div class='col-sm-10 col-md-4'>
									<input type='text' name='fullName' class='form-control inputValidation' value='<?php echo $row['fullName']?>'/>
								</div>
							</div>	
							<!-- end fullnamefield -->
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
		echo "<h1 class='text-center'>update member</h1>";
			//get varibles from the form

			$userId 	= trim(strip_tags($_POST['userId']));
			$user 		= trim(strip_tags($_POST['userName']));
			$email 		= trim(strip_tags($_POST['email']));
			$name 		= trim(strip_tags($_POST['fullName']));

			//password trick
			//short condition
			$pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

			//validate the form

			$formErrors = array();

			if (strlen($user) < 4) {
				$formErrors[] = 'username can\'t be less than 4 characters';
			}
			if (strlen($user) > 20) {
				$formErrors[] = 'username can\'t be more than 20 characters';
			}
			if (empty($user)) {

				$formErrors[] = 'username can\'t be empty';
			}
			if (trim(strip_tags($_POST['userName'])) === false) {
				$formErrors[] = 'please use a validate characters in the username field';
			} 
			if (empty($name)) {
				$formErrors[] = 'fullname can\'t be empty';
			}
			if (trim(strip_tags($_POST['fullName'])) === false) {
				$formErrors[] = 'please use a validate characters in the full name field';

			} 
			if (empty($email)) {
				$formErrors[] = 'email can\'t be empty';
			}

			if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE ){
                    //the result that will happend
					$formErrors[] = "Please Enter A Validate Email";	
				} 
				if(filter_var($email, FILTER_SANITIZE_EMAIL) === FALSE ){
                    //the result that will happend
					$formErrors[] = "Please Enter A Validate Email";
				} 
				if(!empty($formErrors)){
					//the result of the validation and inputs
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
					//start loop to get the errors
					foreach ($formErrors as $error) {
							
						echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
					
					}//end loop
					
					echo '</div>';
					
				}

				//if the array is empty compelete the query
				if (empty($formErrors)) {

					$vSelect = $conn->prepare("SELECT * FROM users WHERE userName = ? && userId != ?");

					$vSelect->execute(array($user, $userId));

					$count = $vSelect->rowCount();

					if($count == 1){
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
						$msg = '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>this user is exist </strong></div>';
						 redirect($msg, 'backPage', 'prev');
					}else{
						
						//update the database

						$stmt = $conn->prepare("UPDATE users SET userName = ?, email = ?, fullName = ?, password = ? WHERE userId = ?");
						$stmt->execute(array($user, $email, $name, $pass,$userId));

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
					}
				}

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
			echo "<h1 class='text-center'>delete member page</h1>";
		//check if the user id is numeric and get the integer value
			$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'userId', 'users', $userId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("DELETE FROM users WHERE userId = :zuser");
				$stmt->bindParam(":zuser", $userId);
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

		} elseif ($do == 'activate') {
			echo "<h1 class='text-center'>activate member page</h1>";
		//check if the user id is numeric and get the integer value
			$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'userId', 'users', $userId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("UPDATE users SET regStatuse = 1 WHERE userId = ?");
				$stmt->execute(array($userId));

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
						 $stmt->rowCount() . " Recourd activated </strong></div>";
						 redirect( $msg, 'activePage', 'active member');
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
