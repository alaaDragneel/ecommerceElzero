<?php 
	session_start();
	
	$pageTitle = 'Login';

	if (isset($_SESSION['user'])) {
		header('location: index.php'); //redirect to the index page
	}
	
	include "init.php";

	//check if user coming from http post request

	if($_SERVER["REQUEST_METHOD"] == 'POST') {

		$userName 	= $_POST["userName"];
		$password 	= $_POST["password"];
		$hashedpass = sha1($password);

		//check if user exist in Database

		$stmt = $conn->prepare("SELECT 
									userId,userName, password 
								FROM 
									users 
								WHERE
									 userName = ?
								AND 
									password = ? 
								");
		$stmt->execute(array($userName, $hashedpass));
		$count = $stmt->rowCount();

		//if count > 0 this mean the database have he information for this user name

		if ($count > 0) {
			
			$_SESSION['user'] = $userName; //register session name
		
			header('location: index.php');//redirect to the dashboard page
			exit();
		}
	}
?>

<div class='container login-page'>
	<h1 class="text-center">
		<span class="selected" data-class="login">login</span> | 
		<span data-class="signup">signup</span>
	</h1>
	<!-- start login form -->
	<form class="login formValidation" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input 
			type="text" 
			name="userName" 
			class="form-control inputValidation" 
			autocomplete="off" 
			placeholder="User Name" />
		<input 
			type="password" 
			name="password" 
			class="form-control inputValidation" 
			autocomplete="new-password" 
			placeholder="Password" />
		<input type="submit" value="LogIn" class="btn btn-primary btn-block	" />
		<div class="errorMessage"></div>
	</form>
	<!-- end login form -->
	<!-- start sign up form-->
	<form class="signup formValidation2">
		<input 
			type="text" 
			name="userName" 
			class="form-control inputValidation2" 
			autocomplete="off" 
			placeholder="User Name Must be More Than 4 " />
		<input
			type="password" 
			name="password" 
			class="form-control inputValidation2" 
			autocomplete="new-password" 
			placeholder="Password" />
		<input
			type="password" 
			name="re_password" 
			class="form-control inputValidation2" 
			autocomplete="new-password" 
			placeholder="Re Enter Your Password" />	
		<input 
			type="email" 
			name="email" 
			class="form-control inputValidation2"  
			placeholder="Email" />	
		<input type="submit" value="SginUp" class="btn btn-success btn-block" />
		<div class="errorMessage2"></div>
	</form>
	<!-- end sign up form-->
</div>

<?php include $tpl . "footer.php";?>