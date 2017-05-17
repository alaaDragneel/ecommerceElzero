<?php
	
	session_start();

	$pageTitle = 'profile';

	include "init.php";

	if(isset($_SESSION["user"])) {

	$getUser = $conn->prepare("SELECT * FROM users WHERE userName = ?");

	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();
?>


 <h1 class="text-center">My Profile </h1>
 <!-- start block information -->
 <div class="information block">
 	<div class="container">
 		<div class="panel panel-primary">
 			<div class="panel-heading">	my information </div>
 			<div class="panel-body">
 				Name: <?php echo $info["userName"]?> <br/>
 				email: <?php echo $info["email"]?> <br/>
 				full Name: <?php echo $info["fullName"]?> <br/>
 				reg Date: <?php echo $info["Date"]?> <br/>
 				favorite Category: 
 			</div>
 		</div>
 	</div>
 </div>
<!-- end block information -->
<!-- start block ads -->
 <div class="ads block">
 	<div class="container">
 		<div class="panel panel-primary">
 			<div class="panel-heading">	latest Ads </div>
 			<div class="panel-body">
	 			<div class="row">
					<?php
					  	$users = getItems('userId', $info["userId"]);

						foreach ($users as $item ) {
							echo "<div class='col-sm-6 col-md-3'> ";
								echo "<div class='thumbnail item-box'> ";
									echo "<span class='price'>". $item["itemPrice"] ."</span>";
									echo "<img class='img-responsive' src='avatar.jpg' alt='' />";
									echo "<div class='captions' >";
										echo "<h3 class='text-center' >" . $item["itemName"] . "</h3>";
										echo "<p>" . $item["itemDesc"] . "</p>";
									echo "</div>";
								echo "</div>";
							echo "</div>";	
						}
					?>
				</div>
 			</div>
 		</div>
 	</div>
 </div>
 <!-- end block ads -->
 <!-- start block comment -->
 <div class="comment block">
 	<div class="container">
 		<div class="panel panel-primary">
 			<div class="panel-heading">	latest comment </div>
 			<div class="panel-body">
 				<?php
 					//select the data from users table execpt the admin
					$comm = $conn->prepare("SELECT commentName FROM comments WHERE userId = ?	");
					//execute the statement
					$comm->execute(array($info["userId"]));

					//assign to variable

					$comments = $comm->fetchAll();

					if(!empty($comments)) {

						foreach ($comments as $comm) {
							
							echo "<p>" . $comm["commentName"] ."</p>";
						}

					}else{
						echo ' <div class="alert alert-info text-center" style="margin-bottom: 0;">
								 there is no items to show
							   </div>
							 ';
					}
 				?>
 			</div>
 		</div>
 	</div>
 </div>
 <!-- end block comment -->





<?php
	}else{
		header("location: login.php");
		exit();
	}
 	include $tpl . "footer.php";

  ?>