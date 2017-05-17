<?php 
	session_start();
	$noNavbar = '';
	$pageTitle = 'Login';

	if (isset($_SESSION['userName'])) {
		header('location: dashboard.php');//redirect to the dashboard page
	}
	include "init.php";


	//check if user coming from http post request

	if($_SERVER["REQUEST_METHOD"] == 'POST') {

		$userName 	= $_POST["user"];
		$password 	= $_POST["pass"];
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
								AND 
									groubId = 1
								LIMIT 1");
		$stmt->execute(array($userName, $hashedpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		//if count > 0 this mean the database have he information for this user name

		if ($count > 0) {
			$_SESSION['userName'] = $userName; //register session name
			$_SESSION['id'] = $row['userId']; // register session id
			header('location: dashboard.php');//redirect to the dashboard page
			exit();
		}
	}
?>
		

	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<h2 class="text-center">Admin login</h2>
		<input class="form-control" type="text" name="user" placeholder="username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="login"  />

	</form>



<?php include $tpl . "footer.php"; ?>